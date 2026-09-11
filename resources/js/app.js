import './bootstrap';

const savedTheme = localStorage.getItem('portfolio-theme');
const prefersLight = window.matchMedia('(prefers-color-scheme: light)').matches;
if ((savedTheme || (prefersLight ? 'light' : 'dark')) === 'light') document.documentElement.classList.add('theme-light');

document.addEventListener('DOMContentLoaded', () => {
    document.getElementById('public-menu')?.setAttribute('aria-expanded', 'false');
    const header = document.querySelector('.public-header .flex.items-center.gap-3');
    if (header && !document.getElementById('theme-toggle')) {
        const button = document.createElement('button');
        button.id = 'theme-toggle';
        button.type = 'button';
        button.className = 'theme-toggle rounded-full border border-white/15 px-3 py-1.5 text-xs text-white/70';
        button.setAttribute('aria-label', 'Toggle color theme');
        button.textContent = document.documentElement.classList.contains('theme-light') ? 'Dark' : 'Light';
        button.addEventListener('click', () => {
            const light = document.documentElement.classList.toggle('theme-light');
            localStorage.setItem('portfolio-theme', light ? 'light' : 'dark');
            button.textContent = light ? 'Dark' : 'Light';
        });
        header.prepend(button);
    }
});
