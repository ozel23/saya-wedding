import { initCursor } from './cursor';
import { initMotion } from './motion';
import { initSlideshow } from './slideshow';
import { initDialogs } from './dialogs';

const toggle = document.querySelector('.menu-toggle');
const navigation = document.querySelector('#navigation');
if (toggle && navigation) {
    toggle.hidden = false;
    document.documentElement.classList.add('js-menu');
    const closeMenu = (restoreFocus = false) => {
        toggle.setAttribute('aria-expanded', 'false');
        navigation.classList.remove('is-open');
        if (restoreFocus) toggle.focus();
    };
    toggle.addEventListener('click', () => {
        const opened = toggle.getAttribute('aria-expanded') === 'true';
        toggle.setAttribute('aria-expanded', String(!opened));
        navigation.classList.toggle('is-open', !opened);
    });
    navigation.querySelectorAll('a').forEach(link => link.addEventListener('click', () => closeMenu()));
    document.addEventListener('keydown', event => {
        if (event.key === 'Escape' && toggle.getAttribute('aria-expanded') === 'true') closeMenu(true);
    });
    document.addEventListener('click', event => {
        if (!event.target.closest('.site-header')) closeMenu();
    });
}
initMotion();
initCursor();
initSlideshow();
initDialogs();
