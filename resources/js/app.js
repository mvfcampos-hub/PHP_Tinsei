import './bootstrap';
import Alpine from 'alpinejs';

window.Alpine = Alpine;

// Contador animado (números institucionais): x-data="counter(3230)".
Alpine.data('counter', (target = 0, duration = 1600) => ({
    value: target,
    init() {
        const run = () => {
            if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) return;
            this.value = 0;
            const start = performance.now();
            const step = (now) => {
                const p = Math.min(1, (now - start) / duration);
                this.value = Math.round(target * (1 - Math.pow(1 - p, 3)));
                if (p < 1) requestAnimationFrame(step);
            };
            requestAnimationFrame(step);
        };
        if (!('IntersectionObserver' in window)) return run();
        const io = new IntersectionObserver((entries) => {
            if (entries.some((e) => e.isIntersecting)) { run(); io.disconnect(); }
        });
        io.observe(this.$el);
    },
    get formatted() {
        return this.value.toLocaleString('pt-BR');
    },
}));

Alpine.start();

// Revela seções ao rolar a página.
document.addEventListener('DOMContentLoaded', () => {
    const items = document.querySelectorAll('.reveal');
    if (!('IntersectionObserver' in window)) {
        items.forEach((el) => el.classList.add('is-visible'));
        return;
    }
    const io = new IntersectionObserver((entries) => {
        entries.forEach((e) => {
            if (e.isIntersecting) { e.target.classList.add('is-visible'); io.unobserve(e.target); }
        });
    }, { threshold: 0.12 });
    items.forEach((el) => io.observe(el));
});

window.trackEvent = function (name, params = {}) {
    if (typeof window.gtag === 'function' && window.googleAnalyticsLoaded) {
        window.gtag('event', name, params);
    }
};
