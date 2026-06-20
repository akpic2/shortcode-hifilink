<?php
/**
 * Shortcode: [hifilink_simulateur_credit]
 * Remplace le calculateur "Simulateur de crédit" du plugin Cost Calculator Builder
 */
add_shortcode('hifilink_simulateur_credit', function () {
    $uid = 'credit_' . wp_generate_uuid4();

    ob_start(); ?>
    <div class="hifilink-credit" id="<?php echo esc_attr($uid); ?>">
        <div class="hifilink-credit__form">
            <div class="hifilink-credit__field">
                <label>Montant du projet total (€)</label>
                <input type="number" data-field="C" min="1" max="10000000" step="0.01" value="">
            </div>

            <div class="hifilink-credit__field">
                <label>Apport personnel (€)</label>
                <input type="number" data-field="D" min="0" max="10000000" step="0.01" value="">
                <span class="hifilink-credit__error" data-error="D"></span>
            </div>

            <div class="hifilink-credit__field">
                <label>Remboursement souhaité (mois)</label>
                <input type="number" data-field="B" min="1" max="120" step="1" value="">
            </div>
        </div>

        <div class="hifilink-credit__results">
            <h3>Résultats</h3>
            <table>
                <tbody>
                    <tr><td>Montant du projet total</td>  <td data-out="C">0,00 €</td></tr>
                    <tr><td>Apport personnel</td>         <td data-out="D">0,00 €</td></tr>
                    <tr><td>Montant du crédit</td>        <td data-out="credit">0,00 €</td></tr>
                    <tr><td>Remboursement souhaité</td>   <td data-out="B">0 mois</td></tr>
                    <tr class="hifilink-credit__highlight">
                        <td>Mensualités</td>
                        <td data-out="mensualite">0,00 €</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <style>
        .hifilink-credit { font-family: inherit; max-width: 700px; margin: 1em 0; }
        .hifilink-credit__form { display: grid; gap: 1em; margin-bottom: 1.5em; }
        .hifilink-credit__field { display: flex; flex-direction: column; }
        .hifilink-credit__field label { font-weight: 600; margin-bottom: .3em; }
        .hifilink-credit__field input { padding: .6em; border: 1px solid #ccc; border-radius: 4px; font-size: 1em; }
        .hifilink-credit__field input:invalid { border-color: #c00; }
        .hifilink-credit__error { color: #c00; font-size: .85em; margin-top: .25em; min-height: 1em; }
        .hifilink-credit__results table { width: 100%; border-collapse: collapse; }
        .hifilink-credit__results td { padding: .6em; border-bottom: 1px solid #eee; }
        .hifilink-credit__results td:last-child { text-align: right; font-weight: 600; }
        .hifilink-credit__highlight td { background: #f0f9f0; color: #1a7f1a; font-size: 1.1em; }
    </style>

    <script>
    (function () {
        const root = document.getElementById('<?php echo esc_js($uid); ?>');
        if (!root) return;

        const TAUX_ANNUEL = 0.0734;
        const TAUX_MENSUEL = TAUX_ANNUEL / 12;

        const inputs = root.querySelectorAll('input[data-field]');
        const outputs = {};
        root.querySelectorAll('[data-out]').forEach(el => {
            outputs[el.dataset.out] = el;
        });

        const fmtEuro = new Intl.NumberFormat('fr-FR', {
            style: 'currency',
            currency: 'EUR'
        });

        function calc() {
            const C = parseFloat(root.querySelector('[data-field="C"]').value) || 0;
            const D = parseFloat(root.querySelector('[data-field="D"]').value) || 0;
            const B = parseFloat(root.querySelector('[data-field="B"]').value) || 0;

            const errD = root.querySelector('[data-error="D"]');
            if (C > 0 && D > C) {
                errD.textContent = 'L\'apport ne peut pas dépasser le montant total du projet';
            } else {
                errD.textContent = '';
            }

            outputs.C.textContent = fmtEuro.format(C);
            outputs.D.textContent = fmtEuro.format(D);
            outputs.B.textContent = B + ' mois';

            if (C <= 0 || B <= 0 || D > C) {
                outputs.credit.textContent = fmtEuro.format(0);
                outputs.mensualite.textContent = fmtEuro.format(0);
                return;
            }

            const montantCredit = C - D;
            const mensualite = (montantCredit * TAUX_MENSUEL) / (1 - Math.pow(1 + TAUX_MENSUEL, -B));

            outputs.credit.textContent = fmtEuro.format(montantCredit);
            outputs.mensualite.textContent = fmtEuro.format(mensualite);
        }

        inputs.forEach(input => {
            input.addEventListener('input', calc);
        });

        calc();
    })();
    </script>
    <?php
    return ob_get_clean();
});