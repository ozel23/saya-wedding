function prepareHeading(heading) {
    const walker = document.createTreeWalker(heading, NodeFilter.SHOW_TEXT, {
        acceptNode: node => node.textContent.trim() && !node.parentElement.closest('.script-drift, .motion-word')
            ? NodeFilter.FILTER_ACCEPT : NodeFilter.FILTER_REJECT,
    });
    const nodes = [];
    while (walker.nextNode()) nodes.push(walker.currentNode);
    let index = 0;
    nodes.forEach(node => {
        const fragment = document.createDocumentFragment();
        node.textContent.split(/(\s+)/).forEach(part => {
            if (!part.trim()) { fragment.append(document.createTextNode(part)); return; }
            const word = document.createElement('span');
            word.className = 'motion-word';
            word.style.setProperty('--word', Math.min(index++, 9));
            word.textContent = part;
            fragment.append(word);
        });
        node.replaceWith(fragment);
    });
}

export function initMotion() {
    const preference = window.matchMedia('(prefers-reduced-motion: reduce)');
    if (!('IntersectionObserver' in window)) return;
    const root = document.documentElement;
    root.classList.toggle('motion-enabled', !preference.matches);
    root.classList.toggle('motion-suspended', document.hidden);

    document.querySelectorAll('h2').forEach(heading => {
        heading.removeAttribute('data-reveal');
        heading.dataset.lineReveal = '';
        prepareHeading(heading);
    });
    const targets = new Set(document.querySelectorAll('[data-reveal], [data-line-reveal], [data-script-motion]'));
    const text = document.querySelectorAll('h3, p, a, .eyebrow, .menu-toggle, .pill-button, summary, .brand-descriptor, .media-heading > span, .footer-signature, .footer-brand > span, .footer-bottom > span');
    text.forEach((element, index) => {
        if (element.matches('.skip-link') || element.closest('dialog, .masthead, .site-header')) return;
        if (element.parentElement.closest('[data-reveal], [data-line-reveal], [data-script-motion]')) return;
        if (!targets.has(element)) {
            element.dataset.reveal = '';
            element.style.setProperty('--reveal-delay', `${(index % 4) * 40}ms`);
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
    }, { threshold: .06, rootMargin: '0px 0px -16px 0px' });
    targets.forEach(element => observer.observe(element));
    const masthead = document.querySelector('.masthead');
    if (masthead) observer.observe(masthead);
    preference.addEventListener('change', () => root.classList.toggle('motion-enabled', !preference.matches));
    document.addEventListener('visibilitychange', () => root.classList.toggle('motion-suspended', document.hidden));
}
