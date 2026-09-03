import './bootstrap';
import Alpine from 'alpinejs';

window.Alpine = Alpine;
Alpine.start();

// Envia um evento ao Google Analytics quando configurado e o visitante já
// aceitou os cookies de análise; não faz nada (sem erro) caso contrário.
window.trackEvent = function (name, params = {}) {
    if (typeof window.gtag === 'function' && window.googleAnalyticsLoaded) {
        window.gtag('event', name, params);
    }
};
