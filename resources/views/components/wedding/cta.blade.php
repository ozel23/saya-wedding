@props(['location', 'label' => "Let's talk", 'message' => null, 'class' => ''])
@php($link = \App\Support\WhatsAppLink::make(config('wedding.whatsapp'), $message ?? config('wedding.message')))
@if($link)
    <a class="pill-button {{ $class }}" href="{{ $link }}" target="_blank" rel="noopener noreferrer" data-cta-location="{{ $location }}">{{ $label }}</a>
@else
    <button class="pill-button {{ $class }}" type="button" data-contact-pending data-cta-location="{{ $location }}" disabled>{{ $label }}</button>
@endif
