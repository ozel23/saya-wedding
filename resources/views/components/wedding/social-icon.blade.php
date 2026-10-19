@props(['name'])
<svg viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false">
    @if($name === 'instagram')
        <rect x="5" y="5" width="22" height="22" rx="7" stroke="currentColor" stroke-width="2" />
        <circle cx="16" cy="16" r="5.2" stroke="currentColor" stroke-width="2" />
        <circle cx="23" cy="9.2" r="1.5" fill="currentColor" />
    @else
        <path d="M6.4 24.1 4.7 28l4.7-1.3A12 12 0 1 0 6.4 24.1Z" stroke="currentColor" stroke-width="1.8" stroke-linejoin="round" />
        <path d="M11 9.6c.4-.4 1.2-.4 1.5.1l1.6 2.8c.2.4.1.8-.2 1.2l-.9 1.1c.9 2 2.4 3.5 4.6 4.4l1-1c.3-.4.8-.4 1.2-.2l2.6 1.3c.6.3.7 1 .4 1.6-.6 1.3-1.9 2-3.3 1.7-5.2-1-9.4-5.2-10.1-10.2-.1-1.1.4-2 1.6-2.8Z" fill="currentColor" />
    @endif
</svg>
