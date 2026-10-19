export function initConsultation() {
    const form = document.querySelector('#consultation-form');
    if (!form) return;
    form.hidden = false;
    const review = form.querySelector('.message-review');
    const preview = form.querySelector('#message-preview');
    const proceed = form.querySelector('#continue-whatsapp');
    form.addEventListener('input', () => {
        review.hidden = true;
        proceed.removeAttribute('href');
    });
    form.addEventListener('submit', event => {
        event.preventDefault();
        if (!/^[1-9][0-9]{7,14}$/.test(form.dataset.number)) return;
        const data = new FormData(form);
        const parts = [form.dataset.message];
        if (data.get('date')) parts.push(`Tanggal rencana: ${data.get('date')}`);
        if (data.get('location')?.trim()) parts.push(`Lokasi rencana: ${data.get('location').trim().slice(0, 120)}`);
        if (data.get('service')) parts.push(`Pendampingan: ${data.get('service')}`);
        const message = parts.join('\n');
        preview.textContent = message;
        proceed.href = `https://wa.me/${form.dataset.number}?text=${encodeURIComponent(message)}`;
        review.hidden = false;
        proceed.focus();
    });
}
