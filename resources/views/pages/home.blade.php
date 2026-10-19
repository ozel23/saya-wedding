@extends('layouts.app')
@section('content')
<header class="site-header">
    <a class="nav-brand" href="#beranda" aria-label="SAYA — Beranda">
        <img src="{{ asset('brand/bee.png') }}" width="54" height="38" alt=""><span>SAYA</span>
    </a>
    <button class="menu-toggle" aria-expanded="false" aria-controls="navigation" hidden>Menu <span aria-hidden="true">＋</span></button>
    <nav id="navigation" aria-label="Navigasi utama">
        @foreach($wedding['navigation'] as $id => $label)<a href="#{{ $id }}">{{ $label }}</a>@endforeach
    </nav>
    <x-wedding.cta location="header" class="header-cta" />
</header>
<main id="main">
    <section class="masthead" id="beranda" aria-labelledby="brand-title">
        <h1 id="brand-title" aria-label="{{ $wedding['name'] }}">
            <span class="wordmark">
                <span class="wordmark-main" aria-hidden="true">@foreach(str_split('SAYA') as $letter)<span class="letter-window"><span class="masthead-letter" style="--letter: {{ $loop->index }}">{{ $letter }}</span></span>@endforeach</span>
                <span class="masthead-script" aria-hidden="true"><span>wedding</span></span>
            </span>
            <span class="brand-descriptor">WEDDING ORGANIZER</span>
        </h1>
        <div class="masthead-bottom">
            <p>@foreach($wedding['copy']['masthead_left'] as $line){{ $line }}@unless($loop->last)<br>@endunless @endforeach</p>
            <p>@foreach($wedding['copy']['masthead_right'] as $line){{ $line }}@unless($loop->last)<br>@endunless @endforeach</p>
        </div>
    </section>

    <section id="film" class="hero-media" aria-label="Slideshow foto pernikahan. Tekan spasi untuk menjeda atau melanjutkan." aria-roledescription="slideshow" tabindex="0" data-slideshow data-interval="{{ $wedding['media']['interval'] }}">
        <div class="hero-slides">
            @foreach($wedding['media']['slides'] as $photo)
                <div class="hero-slide {{ $loop->first ? 'is-active' : '' }}" data-slide role="group" aria-roledescription="slide" aria-label="{{ $loop->iteration }} dari {{ $loop->count }}" aria-hidden="{{ $loop->first ? 'false' : 'true' }}">
                    @if($loop->first)
                        <x-wedding.photo :photo="$photo" :priority="true" class="hero-poster" />
                    @else
                        <img class="hero-poster" data-src="{{ asset($photo['src']) }}" data-srcset="{{ collect($photo['sources'])->map(fn ($source) => asset($source['src']).' '.$source['width'].'w')->implode(', ') }}" sizes="100vw" width="{{ $photo['width'] }}" height="{{ $photo['height'] }}" alt="{{ $photo['alt'] }}" decoding="async" style="object-position: {{ $photo['position'] }}">
                    @endif
                </div>
            @endforeach
        </div>
        <div class="media-heading"><span>A LITTLE GLIMPSE OF</span><p>your beautiful beginning.</p></div>
    </section>

    <section class="statement dark" id="tentang">
        <span class="eyebrow" data-reveal>TENTANG SAYA</span>
        <h2 data-line-reveal>
            @foreach($wedding['copy']['statement'] as $line)<span class="reveal-line"><span class="reveal-ink" style="--line: {{ $loop->index }}">{{ $line }}</span></span>@endforeach
        </h2>
        <div class="statement-art" aria-hidden="true" data-script-motion><div class="script-decoration"><span class="script-drift">bersama</span></div></div>
        <div class="statement-bottom">
            <p data-reveal>{{ $wedding['copy']['about'] }}</p>
            <a class="pill-button pill-outline" href="#proses" data-reveal>Kenali pendekatan kami</a>
        </div>
    </section>

    <section class="inspiration" id="inspirasi">
        <div class="section-intro">
            <span class="eyebrow">INSPIRASI PERAYAAN</span>
            <h2 data-line-reveal>@foreach($wedding['copy']['inspiration'] as $line)<span class="reveal-line"><span class="reveal-ink" style="--line: {{ $loop->index }}">{{ $line }}</span></span>@endforeach</h2>
            <div class="inspiration-art" aria-hidden="true" data-script-motion><span class="script-decoration"><span class="script-drift">cerita</span></span></div>
        </div>
        <div class="inspiration-stories">
            @foreach($wedding['inspirations'] as $item)
                <figure class="inspiration-story" data-story>
                    <x-wedding.photo :photo="$item['photo']" class="story-photo" />
                    <figcaption class="story-caption" data-reveal>
                        <h3>{{ $item['title'] }}</h3>
                        <p>{{ $item['description'] }}</p>
                    </figcaption>
                </figure>
            @endforeach
        </div>
    </section>

    <section class="services section-pad" id="layanan">
        <div class="service-heading">
            <span class="eyebrow" data-reveal>RUANG UNTUK RENCANA ANDA</span>
            <h2 data-line-reveal><span class="reveal-line"><span class="reveal-ink">Anda punya cerita.</span></span><span class="reveal-line"><span class="reveal-ink" style="--line: 1"><em>Kita rangkai bersama.</em></span></span></h2>
        </div>
        <div class="service-editorial">
            <figure class="service-portrait" data-reveal><x-wedding.photo :photo="$wedding['service_photo']" sizes="(max-width: 700px) 100vw, 45vw" /><figcaption>A LITTLE CARE. A BEAUTIFUL CELEBRATION.</figcaption></figure>
            <div class="service-options">
                <p class="service-intro" data-reveal>Mulai dari gambaran besar hingga detail kecil. Temukan bentuk pendampingan yang terasa pas untuk hari Anda.</p>
                @forelse($services as $service)
                    <details class="service-option" name="wedding-services" @if($loop->first) open @endif>
                        <summary><span class="service-number">0{{ $loop->iteration }}</span><h3>{{ $service['title'] }}</h3><span class="service-plus" aria-hidden="true">＋</span></summary>
                        <div class="service-content"><p>{{ $service['description'] }}</p><x-wedding.cta location="service-{{ $service['id'] }}" label="Mari diskusikan" :message="$wedding['message'].PHP_EOL.'Layanan yang ingin didiskusikan: '.$service['title']" /></div>
                    </details>
                @empty
                    <p>Informasi pendampingan akan segera tersedia.</p>
                @endforelse
            </div>
        </div>
    </section>

    <section class="process dark section-pad" id="proses">
        <div class="process-heading"><span class="eyebrow">DARI RENCANA MENJADI PERAYAAN</span><h2 data-reveal>SATU LANGKAH.<br><em>Satu cerita bersama.</em></h2></div>
        <div class="steps">@foreach($wedding['process'] as $step)<article data-reveal><span class="step-number">0{{ $loop->iteration }}</span><h3>{{ $step['title'] }}</h3><p>{{ $step['description'] }}</p></article>@endforeach</div>
    </section>

    <section class="faq section-pad" id="faq">
        <div class="section-split"><div><span class="eyebrow">SEBELUM KITA BERCERITA</span><h2>Hal kecil yang<br><em>ingin Anda tahu.</em></h2></div><div class="faq-list">@foreach($wedding['faqs'] as $faq)<details><summary>{{ $faq['question'] }}<span aria-hidden="true">＋</span></summary><p>{{ $faq['answer'] }}</p></details>@endforeach</div></div>
    </section>

    <section class="consultation dark section-pad" id="konsultasi">
        <span class="eyebrow">CERITA INDAH DIMULAI DARI PERCAKAPAN</span>
        <h2 data-line-reveal><span class="reveal-line"><span class="reveal-ink">Mari merangkai</span></span><span class="reveal-line closing-script-line"><span class="reveal-ink" style="--line: 1"><em><span class="script-drift">hari Anda.</span></em></span></span></h2>
        <x-wedding.cta location="closing" class="closing-cta" />
        @unless($whatsapp)<noscript><p class="no-js-contact">Kontak konsultasi belum tersedia.</p></noscript>@endunless
    </section>
</main>

<footer class="site-footer dark">
    <div class="footer-brand"><span aria-hidden="true">SAYA</span></div>
    <div class="footer-links">
        <p>HARI ISTIMEWA.<br>CERITA MILIK ANDA.</p>
        <div class="social-links">
            @if(filter_var($wedding['instagram'], FILTER_VALIDATE_URL) && str_starts_with($wedding['instagram'], 'https://www.instagram.com/'))
                <a class="social-link" href="{{ $wedding['instagram'] }}" target="_blank" rel="noopener noreferrer"><span class="social-icon"><x-wedding.social-icon name="instagram" /></span><span>Instagram</span></a>
            @endif
            @if($whatsapp)
                <a class="social-link" href="{{ $whatsapp }}" target="_blank" rel="noopener noreferrer" data-cta-location="footer"><span class="social-icon"><x-wedding.social-icon name="whatsapp" /></span><span>WhatsApp</span></a>
            @endif
        </div>
        <div class="footer-signoff">@if($wedding['area'])<p>{{ $wedding['area'] }}</p>@endif<span class="footer-signature">with love, SAYA.</span></div>
    </div>
    <div class="footer-bottom"><span>© {{ date('Y') }} {{ $wedding['name'] }}</span><a href="{{ route('privacy') }}">Privasi</a></div>
</footer>

@unless($whatsapp)
<dialog class="contact-dialog" id="contact-dialog" aria-labelledby="contact-dialog-title">
    <button class="dialog-close" type="button" data-close-contact aria-label="Tutup">×</button>
    <span class="eyebrow">SAYA WEDDING ORGANIZER</span><h2 id="contact-dialog-title">Mari segera<br><em>bercerita.</em></h2><p>Kontak WhatsApp sedang disiapkan. Konsultasi belum tersedia saat ini.</p><button class="pill-button" type="button" data-close-contact>Kembali ke cerita</button>
</dialog>
@endunless
@endsection
