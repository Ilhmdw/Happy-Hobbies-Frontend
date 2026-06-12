import Alpine from 'alpinejs';

window.Alpine = Alpine;
Alpine.start();

// Flash message auto-hide
document.addEventListener('DOMContentLoaded', () => {
    const flash = document.getElementById('flash-message');
    if (flash) {
        setTimeout(() => {
            flash.style.opacity = '0';
            flash.style.transform = 'translateY(8px)';
            flash.style.transition = 'all 0.5s';
        }, 3000);
        setTimeout(() => flash.remove(), 3500);
    }
});