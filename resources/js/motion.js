export function initMotion() {
    const preference = window.matchMedia('(prefers-reduced-motion: reduce)');
    if (!('IntersectionObserver' in window)) return;
    const root = document.documentElement;
    root.classList.toggle('motion-enabled', !preference.matches);
    root.classList.toggle('motion-suspended', document.hidden);
    const targets = new Set(document.querySelectorAll('[data-reveal], [data-line-reveal], [data-script-motion]'));
    const text = document.querySelectorAll('h2, h3, p, a, .eyebrow, .menu-toggle, .pill-button, summary, .brand-descriptor, .media-heading > span, .step-number, .footer-signature, .footer-brand > span, .footer-bottom > span, .service-portrait figcaption');
    text.forEach((element, index) => {
        if (element.matches('.skip-link') || element.closest('dialog')) return;
        if (element.parentElement.closest('[data-reveal], [data-line-reveal], [data-script-motion]')) return;
        if (element.parentElement.closest('.reveal-ready')) return;
        if (!targets.has(element)) {
            element.dataset.reveal = '';
            element.style.setProperty('--reveal-delay', `${(index % 4) * 65}ms`);
            targets.add(element);
        }
    });
    targets.forEach(element => {
        element.classList.add(element.hasAttribute('data-line-reveal') ? 'line-prepared' : element.hasAttribute('data-script-motion') ? 'script-prepared' : 'reveal-ready');
    });
    const observer = new IntersectionObserver(entries => {
        for (const entry of entries) {
            entry.target.classList.toggle('is-in-view', entry.isIntersecting);
            if (entry.isIntersecting) entry.target.classList.add('is-visible');
        }
    }, { threshold: .08 });
    targets.forEach(element => observer.observe(element));
    const masthead = document.querySelector('.masthead');
    if (masthead) observer.observe(masthead);
    preference.addEventListener('change', () => root.classList.toggle('motion-enabled', !preference.matches));
    document.addEventListener('visibilitychange', () => root.classList.toggle('motion-suspended', document.hidden));
}
