export function initSlideshow() {
    const root = document.querySelector('[data-slideshow]');
    if (!root) return;
    const slides = [...root.querySelectorAll('[data-slide]')];
    if (slides.length < 2) return;
    const motion = window.matchMedia('(prefers-reduced-motion: reduce)');
    const interval = Math.max(3000, Number(root.dataset.interval) || 3000);
    let active = 0;
    let timer = null;
    let request = 0;
    let inView = false;
    let userPaused = false;
    let touchStart = null;
    const failed = new Set();
    const pending = new WeakMap();
    const stop = () => { clearTimeout(timer); timer = null; };
    const autoAllowed = () => inView && !document.hidden && !userPaused && !motion.matches && !navigator.connection?.saveData;
    const load = slide => {
        if (pending.has(slide)) return pending.get(slide);
        const result = (async () => {
            const img = slide.querySelector('img');
            if (img.dataset.src) {
                img.srcset = img.dataset.srcset || '';
                img.src = img.dataset.src;
                delete img.dataset.src;
            }
            try { await img.decode(); } catch { return false; }
            return img.naturalWidth > 0;
        })();
        pending.set(slide, result);
        return result;
    };
    const nextIndex = () => {
        for (let step = 1; step < slides.length; step++) {
            const index = (active + step) % slides.length;
            if (!failed.has(index)) return index;
        }
        return active;
    };
    const schedule = () => {
        stop();
        if (!autoAllowed()) return;
        const next = nextIndex();
        if (next === active) return;
        load(slides[next]);
        timer = setTimeout(() => show(next), interval);
    };
    const show = async (index, manual = false) => {
        stop();
        const token = ++request;
        if (index === active) { schedule(); return; }
        const loaded = await load(slides[index]);
        if (token !== request) return;
        if (!manual && !autoAllowed()) return;
        if (!loaded) { failed.add(index); schedule(); return; }
        slides.forEach(slide => slide.classList.remove('is-leaving'));
        const previous = slides[active];
        previous.classList.add('is-leaving');
        previous.classList.remove('is-active');
        previous.setAttribute('aria-hidden', 'true');
        slides[index].classList.add('is-active');
        slides[index].setAttribute('aria-hidden', 'false');
        active = index;
        schedule();
    };
    root.addEventListener('keydown', event => {
        if (event.code === 'Space' || event.key === 'Escape') {
            event.preventDefault();
            userPaused = event.key === 'Escape' ? true : !userPaused;
            schedule();
        } else if (event.key === 'ArrowRight' || event.key === 'ArrowLeft') {
            event.preventDefault();
            show((active + (event.key === 'ArrowRight' ? 1 : slides.length - 1)) % slides.length, true);
        }
    });
    root.addEventListener('touchstart', event => { touchStart = event.touches[0].clientX; stop(); }, { passive: true });
    root.addEventListener('touchend', event => {
        if (touchStart === null) return;
        const distance = event.changedTouches[0].clientX - touchStart;
        touchStart = null;
        if (Math.abs(distance) > 50) show((active + (distance < 0 ? 1 : slides.length - 1)) % slides.length, true);
        else schedule();
    }, { passive: true });
    root.addEventListener('touchcancel', () => { touchStart = null; schedule(); }, { passive: true });
    document.addEventListener('visibilitychange', schedule);
    motion.addEventListener('change', schedule);
    navigator.connection?.addEventListener?.('change', schedule);
    if ('IntersectionObserver' in window) {
        new IntersectionObserver(entries => {
            inView = entries[0].isIntersecting;
            if (autoAllowed()) slides.forEach(load);
            schedule();
        }, { threshold: .15 }).observe(root);
    }
}
