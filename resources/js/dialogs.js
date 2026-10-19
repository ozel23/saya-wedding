export function initDialogs() {
    const dialog = document.querySelector('#contact-dialog');
    if (!dialog || typeof dialog.showModal !== 'function') return;
    dialog.addEventListener('close', () => document.body.classList.remove('dialog-open'));
    dialog.addEventListener('click', event => {
        if (event.target !== dialog) return;
        const rect = dialog.getBoundingClientRect();
        if (event.clientX < rect.left || event.clientX > rect.right || event.clientY < rect.top || event.clientY > rect.bottom) dialog.close();
    });
    document.querySelectorAll('[data-contact-pending]').forEach(button => {
        button.disabled = false;
        button.addEventListener('click', () => {
            dialog.showModal();
            document.body.classList.add('dialog-open');
            document.documentElement.classList.remove('cursor-enabled');
        });
    });
    dialog.querySelectorAll('[data-close-contact]').forEach(button => button.addEventListener('click', () => dialog.close()));
}
