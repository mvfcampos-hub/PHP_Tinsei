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
