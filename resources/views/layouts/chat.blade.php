<!doctype html>
<html lang="en" class="scroll-smooth">
@php($profile = $profile ?? null)
@php($settings = $settings ?? collect())
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $seoTitle ?? ($settings['website_title'] ?? ($profile?->user?->name ?? 'Portfolio')) }} · Messages</title>
    <meta name="description" content="{{ $seoDescription ?? ($settings['meta_description'] ?? ($profile?->bio ?? 'Developer portfolio')) }}">
    <link rel="canonical" href="{{ url()->current() }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-slate-100 text-slate-900 antialiased">
    @if(session('success'))
        <div class="mx-auto max-w-7xl px-4 pt-6">
            <div class="rounded-xl border border-emerald-200 bg-emerald-50 px-5 py-3 text-sm text-emerald-700">
                {{ session('success') }}
            </div>
        </div>
    @endif

    <main>
        @yield('content')
    </main>
</body>
</html>