<?php
add_shortcode('hifilink_simulateur_loa', function () {
    $uid = 'loa_' . wp_generate_uuid4();

    ob_start(); ?>
    <style>
    .hifilink-fin {
        --hl-bg: #1A1A1A;
        --hl-bg-soft: #222222;
        --hl-line: rgba(255, 255, 255, 0.10);
        --hl-line-soft: rgba(255, 255, 255, 0.06);
        --hl-orange: #CD6637;
        --hl-orange-hi: #e07b4d;
        --hl-text: #FFFFFF;
        --hl-text-mute: rgba(255, 255, 255, 0.55);
        --hl-text-faint: rgba(255, 255, 255, 0.35);
        --hl-error: #e07b4d;
        font-family: 'Lato', Arial, Helvetica, sans-serif;
        color: var(--hl-text);
        background: var(--hl-bg);
        max-width: 1100px;
        margin: 2rem auto;
        padding: 0;
        border: 1px solid var(--hl-line);
        box-shadow: 0 30px 80px -20px rgba(0,0,0,0.5);
        overflow: hidden;
    }
    .hifilink-fin__header {
        padding: 2.5rem 3rem 2rem;
        border-bottom: 1px solid var(--hl-line);
        background: var(--hl-bg);
    }
    .hifilink-fin__eyebrow {
        font-size: 11px;
        font-weight: 700;
        letter-spacing: 0.22em;
        text-transform: uppercase;
        color: var(--hl-orange);
        margin: 0 0 0.75rem;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }
    .hifilink-fin__eyebrow::before {
        content: '';
        width: 24px;
        height: 2px;
        background: var(--hl-orange);
    }
    .hifilink-fin__title {
        font-weight: 900;
        font-size: 2rem;
        line-height: 1.2;
        margin: 0 0 0.5rem;
        color: var(--hl-text);
        letter-spacing: -0.01em;
        text-transform: uppercase;
    }
    .hifilink-fin__subtitle {
        font-size: 0.875rem;
        color: var(--hl-text-mute);
        margin: 0;
        max-width: 56ch;
        line-height: 1.6;
        font-weight: 300;
    }
    .hifilink-fin__body {
        display: grid;
        grid-template-columns: 1fr 1.15fr;
        min-height: 480px;
    }
    .hifilink-fin__form {
        padding: 2.5rem 3rem;
        display: flex;
        flex-direction: column;
        gap: 1.75rem;
    }
    .hifilink-fin__field {
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
        position: relative;
    }
    .hifilink-fin__field label {
        font-size: 0.7rem;
        font-weight: 700;
        letter-spacing: 0.15em;
        text-transform: uppercase;
        color: var(--hl-text-mute);
    }
    .hifilink-fin__field input[type="number"] {
        background: transparent !important;
        border: none !important;
        border-bottom: 1px solid var(--hl-line) !important;
        color: #FFFFFF !important;
        -webkit-text-fill-color: #FFFFFF !important;
        font-family: 'Lato', Arial, Helvetica, sans-serif !important;
        font-size: 1.6rem;
        font-weight: 400;
        padding: 0.4rem 0;
        outline: none;
        width: 100%;
        transition: border-color 0.3s ease;
        -moz-appearance: textfield;
        box-shadow: none !important;
    }
    .hifilink-fin__field input[type="number"]::-webkit-outer-spin-button,
    .hifilink-fin__field input[type="number"]::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }
    .hifilink-fin__field input[type="number"]::placeholder {
        color: var(--hl-text-faint) !important;
        -webkit-text-fill-color: var(--hl-text-faint) !important;
        opacity: 1;
    }
    .hifilink-fin__field input[type="number"]:focus {
        border-bottom-color: var(--hl-orange) !important;
        color: #FFFFFF !important;
        -webkit-text-fill-color: #FFFFFF !important;
        background: transparent !important;
        outline: none !important;
    }
    .hifilink-fin__field input[type="number"]:hover {
        border-bottom-color: rgba(255, 255, 255, 0.25) !important;
    }
    .hifilink-fin__field input[type="number"]:-webkit-autofill,
    .hifilink-fin__field input[type="number"]:-webkit-autofill:hover,
    .hifilink-fin__field input[type="number"]:-webkit-autofill:focus {
        -webkit-text-fill-color: #FFFFFF !important;
        -webkit-box-shadow: 0 0 0 1000px var(--hl-bg) inset !important;
        caret-color: #FFFFFF !important;
    }
    .hifilink-fin__field small {
        font-size: 0.7rem;
        color: var(--hl-text-mute);
        margin-top: 0.15rem;
    }
    .hifilink-fin__error {
        color: var(--hl-error);
        font-size: 0.75rem;
        margin-top: 0.25rem;
        min-height: 1em;
        opacity: 0;
        transition: opacity 0.2s ease;
    }
    .hifilink-fin__error:not(:empty) { opacity: 1; }
    .hifilink-fin__field--currency,
    .hifilink-fin__field--month {
        position: relative;
    }
    .hifilink-fin__field--currency .hifilink-fin__field-input,
    .hifilink-fin__field--month .hifilink-fin__field-input {
        position: relative;
        display: block;
    }
    .hifilink-fin__field--currency input[type="number"] {
        padding-right: 2.25rem;
    }
    .hifilink-fin__field--month input[type="number"] {
        padding-right: 3.75rem;
    }
    .hifilink-fin__field--currency .hifilink-fin__suffix,
    .hifilink-fin__field--month .hifilink-fin__suffix {
        position: absolute;
        right: 0.75rem;
        top: 50%;
        transform: translateY(-50%);
        color: var(--hl-text-mute);
        pointer-events: none;
        line-height: 1;
    }
    .hifilink-fin__field--currency .hifilink-fin__suffix {
        font-size: 1.3rem;
        font-weight: 300;
    }
    .hifilink-fin__field--month .hifilink-fin__suffix {
        font-size: 0.75rem;
        font-weight: 700;
        letter-spacing: 0.1em;
        text-transform: uppercase;
    }
    .hifilink-fin__results {
        padding: 2.5rem 3rem;
        background: var(--hl-bg-soft);
        border-left: 1px solid var(--hl-line);
    }
    .hifilink-fin__results-label {
        font-size: 11px;
        font-weight: 700;
        letter-spacing: 0.22em;
        text-transform: uppercase;
        color: var(--hl-orange);
        margin: 0 0 1.5rem;
    }
    .hifilink-fin__results table {
        width: 100%;
        border-collapse: collapse;
        margin: 0;
    }
    .hifilink-fin__results tr {
        border-bottom: 1px solid var(--hl-line-soft);
    }
    .hifilink-fin__results tr:last-child { border-bottom: none; }
    .hifilink-fin__results td {
        padding: 0.85rem 0;
        font-size: 0.875rem;
        vertical-align: baseline;
    }
    .hifilink-fin__results td:first-child {
        color: var(--hl-text-mute);
        font-weight: 400;
        padding-right: 1rem;
    }
    .hifilink-fin__results td:last-child {
        text-align: right;
        font-size: 0.95rem;
        font-weight: 700;
        color: var(--hl-text);
        font-variant-numeric: tabular-nums;
        white-space: nowrap;
    }
    .hifilink-fin__highlight {
        margin-top: 1.5rem !important;
        border-top: 1px solid var(--hl-orange) !important;
        border-bottom: none !important;
    }
    .hifilink-fin__highlight td {
        padding-top: 1.75rem !important;
        padding-bottom: 0 !important;
    }
    .hifilink-fin__highlight td:first-child {
        color: var(--hl-text) !important;
        font-size: 0.7rem !important;
        font-weight: 700 !important;
        letter-spacing: 0.18em;
        text-transform: uppercase;
    }
    .hifilink-fin__highlight td:last-child {
        font-size: 2.1rem !important;
        font-weight: 900 !important;
        color: var(--hl-orange) !important;
        line-height: 1.1;
        letter-spacing: -0.01em;
    }
    .hifilink-fin [data-out] {
        transition: color 0.4s ease;
    }
    .hifilink-fin [data-out].is-updating {
        color: var(--hl-orange-hi);
    }
    @media (max-width: 820px) {
        .hifilink-fin { margin: 1rem; }
        .hifilink-fin__header { padding: 2rem 1.5rem 1.5rem; }
        .hifilink-fin__title { font-size: 1.5rem; }
        .hifilink-fin__body { grid-template-columns: 1fr; min-height: auto; }
        .hifilink-fin__form,
        .hifilink-fin__results { padding: 2rem 1.5rem; }
        .hifilink-fin__results {
            border-left: none;
            border-top: 1px solid var(--hl-line);
        }
        .hifilink-fin__highlight td:last-child { font-size: 1.6rem !important; }
    }
    </style>

    <div class="hifilink-fin hifilink-fin--loa" id="<?php echo esc_attr($uid); ?>">

        <header class="hifilink-fin__header">
            <p class="hifilink-fin__eyebrow">Financement professionnel</p>
            <h2 class="hifilink-fin__title">Simulateur LOA</h2>
            <p class="hifilink-fin__subtitle">
                Estimez le coût réel de votre installation hi-fi en location avec option d'achat,
                après récupération de TVA et économie d'impôt sur les sociétés.
            </p>
        </header>

        <div class="hifilink-fin__body">

            <div class="hifilink-fin__form">
                <div class="hifilink-fin__field hifilink-fin__field--currency">
                    <label>Montant total du projet</label>
                    <div class="hifilink-fin__field-input">
                        <input type="number" data-field="A" min="1" max="10000000" step="0.01" placeholder="0" inputmode="decimal">
                        <span class="hifilink-fin__suffix">€</span>
                    </div>
                </div>

                <div class="hifilink-fin__field hifilink-fin__field--currency">
                    <label>Premier loyer majoré</label>
                    <div class="hifilink-fin__field-input">
                        <input type="number" data-field="B" min="0" max="10000000" step="0.01" placeholder="0" inputmode="decimal">
                        <span class="hifilink-fin__suffix">€</span>
                    </div>
                    <small>Plafonné à 30 % du montant total</small>
                    <span class="hifilink-fin__error" data-error="B"></span>
                </div>

                <div class="hifilink-fin__field hifilink-fin__field--month">
                    <label>Durée de location</label>
                    <div class="hifilink-fin__field-input">
                        <input type="number" data-field="D" min="1" max="120" step="1" placeholder="0" inputmode="numeric">
                        <span class="hifilink-fin__suffix">mois</span>
                    </div>
                </div>
            </div>

            <div class="hifilink-fin__results">
                <p class="hifilink-fin__results-label">Votre simulation</p>
                <table>
                    <tbody>
                        <tr><td>Montant de la LOA</td>                          <td data-out="C">0,00 €</td></tr>
                        <tr><td>Mensualité</td>                                 <td data-out="E">0,00 €</td></tr>
                        <tr><td>Réduction d'impôt sur les sociétés (25 %)</td>  <td data-out="G">0,00 €</td></tr>
                        <tr><td>Récupération de TVA (20 %)</td>                 <td data-out="F">0,00 €</td></tr>
                        <tr><td>Coût réel de la location / mois</td>            <td data-out="H">0,00 €</td></tr>
                        <tr><td>Coût réel de l'achat</td>                       <td data-out="I">0,00 €</td></tr>
                        <tr class="hifilink-fin__highlight">
                            <td>Soit une économie de</td>
                            <td data-out="economie">0,00 €</td>
                        </tr>
                    </tbody>
                </table>
            </div>

        </div>

    </div>

    <script>
    (function(){
        const root = document.getElementById('<?php echo esc_js($uid); ?>');
        if (!root) return;

        const fmt = new Intl.NumberFormat('fr-FR', {
            style: 'currency', currency: 'EUR',
            minimumFractionDigits: 2, maximumFractionDigits: 2
        });

        function formatEuro(val) {
            if (!isFinite(val) || isNaN(val)) return '0,00 €';
            return fmt.format(val);
        }
        function setOut(key, value) {
            const cell = root.querySelector('[data-out="' + key + '"]');
            if (!cell) return;
            const newText = formatEuro(value);
            if (cell.textContent !== newText) {
                cell.classList.add('is-updating');
                cell.textContent = newText;
                setTimeout(() => cell.classList.remove('is-updating'), 400);
            }
        }
        function getNum(field) {
            const el = root.querySelector('[data-field="' + field + '"]');
            if (!el) return 0;
            const v = parseFloat(el.value);
            return isNaN(v) ? 0 : v;
        }

        function recompute() {
            const A = getNum('A');
            const B = getNum('B');
            const D = getNum('D');

            const errB = root.querySelector('[data-error="B"]');
            if (B > A * 0.3 && A > 0) {
                errB.textContent = 'Le 1er loyer ne peut excéder 30 % du montant total.';
            } else {
                errB.textContent = '';
            }

            const C = Math.max(0, A - B);
            const E = D > 0 ? C / D : 0;
            const G = C * 0.25;
            const F = E * 0.20;
            const H = Math.max(0, E - F);
            const I = Math.max(0, A - G);
            const economie = G;

            setOut('C', C);
            setOut('E', E);
            setOut('G', G);
            setOut('F', F);
            setOut('H', H);
            setOut('I', I);
            setOut('economie', economie);
        }

        root.querySelectorAll('input[type="number"]').forEach(input => {
            input.addEventListener('input', recompute);
        });
        recompute();
    })();
    </script>
    <?php
    return ob_get_clean();
});