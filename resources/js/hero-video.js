export function initHeroVideo() {
    const video = document.querySelector('[data-hero-video]');
    const button = document.querySelector('.video-toggle');
    if (!video || !button) return;
    let userPaused = false, inView = false, failed = false;
    const motion = window.matchMedia('(prefers-reduced-motion: reduce)');
    const autoAllowed = () => !motion.matches && !navigator.connection?.saveData;
    const play = async () => {
        if (!video.src) video.src = video.dataset.src;
        try { await video.play(); } catch { button.textContent = 'Putar film'; }
    };
    button.hidden = false;
    video.addEventListener('play', () => { button.textContent = 'Jeda film'; button.setAttribute('aria-label', 'Jeda film'); });
    video.addEventListener('pause', () => { button.textContent = 'Putar film'; button.setAttribute('aria-label', 'Putar film'); });
    video.addEventListener('error', () => { failed = true; video.hidden = true; button.textContent = 'Film belum tersedia'; button.disabled = true; });
    button.addEventListener('click', () => {
        if (video.paused) { userPaused = false; play(); }
        else { userPaused = true; video.pause(); }
    });
    const update = () => {
        if (document.hidden || !inView || !autoAllowed()) video.pause();
        else if (!userPaused && !failed) play();
    };
    new IntersectionObserver(entries => { inView = entries[0].isIntersecting; update(); }, { threshold: 0.15 }).observe(video);
    document.addEventListener('visibilitychange', update);
    motion.addEventListener('change', update);
}
