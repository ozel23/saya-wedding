export function initCursor() {
    const allowed = window.matchMedia('(hover: hover) and (pointer: fine) and (prefers-reduced-motion: no-preference)');
    if (!allowed.matches) return;
    const bee = new Image();
    bee.className = 'bee-cursor';
    bee.alt = '';
    bee.setAttribute('aria-hidden', 'true');
    bee.hidden = true;
    let x = 0, y = 0, currentX = 0, currentY = 0, frame = null;
    const stop = () => {
        cancelAnimationFrame(frame);
        frame = null;
        bee.hidden = true;
        document.documentElement.classList.remove('cursor-enabled');
    };
    const render = () => {
        currentX += (x - currentX) * 0.24;
        currentY += (y - currentY) * 0.24;
        bee.style.transform = `translate3d(${currentX - 8}px,${currentY - 8}px,0)`;
        frame = requestAnimationFrame(render);
    };
    bee.onload = () => {
        document.body.append(bee);
        document.addEventListener('pointermove', event => {
            if (!allowed.matches || event.target.closest('input, textarea, select, dialog')) return stop();
            x = event.clientX; y = event.clientY;
            if (!frame) {
                currentX = x; currentY = y;
                bee.hidden = false;
                document.documentElement.classList.add('cursor-enabled');
                frame = requestAnimationFrame(render);
            }
        });
        document.documentElement.addEventListener('pointerleave', stop);
        window.addEventListener('blur', stop);
        document.addEventListener('visibilitychange', () => { if (document.hidden) stop(); });
        allowed.addEventListener('change', stop);
    };
    bee.onerror = stop;
    bee.src = '/brand/bee.png';
}
