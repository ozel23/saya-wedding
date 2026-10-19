@props(['photo', 'priority' => false, 'sizes' => '100vw'])
<img
    {{ $attributes }}
    src="{{ asset($photo['src']) }}"
    srcset="{{ collect($photo['sources'])->map(fn ($source) => asset($source['src']).' '.$source['width'].'w')->implode(', ') }}"
    sizes="{{ $sizes }}"
    width="{{ $photo['width'] }}"
    height="{{ $photo['height'] }}"
    alt="{{ $photo['alt'] }}"
    loading="{{ $priority ? 'eager' : 'lazy' }}"
    @if($priority) fetchpriority="high" @endif
    decoding="async"
    style="object-position: {{ $photo['position'] }}"
>
