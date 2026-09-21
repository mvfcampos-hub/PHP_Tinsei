import './bootstrap';
import Alpine from 'alpinejs';

// Aplica as preferências de acessibilidade (tamanho do texto, alto
// contraste) o quanto antes, antes do Alpine iniciar, para minimizar o
// "flash" de estilo padrão em navegações subsequentes.
try {
    const scale = localStorage.getItem('crn9_font_scale');
    if (scale === '2') document.documentElement.classList.add('font-scale-2');
    if (scale === '3') document.documentElement.classList.add('font-scale-3');
    if (localStorage.getItem('crn9_high_contrast') === '1') document.documentElement.classList.add('high-contrast');
} catch (e) {}

window.Alpine = Alpine;
Alpine.start();

// Chat de atendimento (hub DataSac — https://datasac.com.br). Só carrega
// quando um token de canal estiver configurado (DATASAC_WEBSITE_TOKEN no
// .env), para não abrir conversas de teste na fila real de produção.
// Posição à esquerda para não sobrepor o botão do WhatsApp.
(function () {
    const token = document.body?.dataset.datasacToken;
    if (!token) return;

    window.datasacSettings = { position: 'left', locale: 'pt_BR' };

    const BASE_URL = 'https://app.datasac.com.br';
    const script = document.createElement('script');
    script.src = BASE_URL + '/packs/js/sdk.js';
    script.async = true;
    document.body.appendChild(script);
    script.onload = function () {
        window.datasacSDK.run({ websiteToken: token, baseUrl: BASE_URL });
    };
})();
