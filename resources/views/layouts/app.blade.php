<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', config('wedding.name').' — Hari Istimewa, Dirancang Bersama')</title>
    <meta name="description" content="{{ config('wedding.description') }}">
    <meta name="theme-color" content="#f8c5cd">
    @if(!app()->isProduction() || config('wedding.preview'))<meta name="robots" content="noindex, nofollow">@else<link rel="canonical" href="{{ url()->current() }}">@endif
    <meta property="og:title" content="{{ config('wedding.name') }}">
    <meta property="og:description" content="{{ config('wedding.description') }}">
    <meta property="og:image" content="{{ asset('brand/logo-original.jpg') }}">
    <meta property="og:type" content="website">
    <link rel="icon" type="image/png" href="{{ asset('brand/bee.png') }}">
    <link rel="preload" href="{{ asset('fonts/archivo.ttf') }}" as="font" type="font/ttf" crossorigin>
    @stack('head')
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
<a class="skip-link" href="#main">Lewati ke konten</a>
@yield('content')
</body>
</html>
