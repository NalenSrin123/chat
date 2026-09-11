@extends('layouts.portfolio')

@section('content')
<section class="mx-auto max-w-7xl px-6 py-24">
    <p class="font-mono text-sm uppercase tracking-widest text-cyan-300">Portfolio</p>
    <h1 class="mt-4 text-5xl font-bold capitalize text-white">{{ $page }}</h1>
    <div class="mt-12 grid gap-6 md:grid-cols-2">
        @if ($page === 'about')
            <div class="rounded-3xl border border-white/10 bg-white/[.03] p-8 md:col-span-2">
                <h2 class="text-2xl font-semibold text-white">{{ $profile?->title ?? 'Full-Stack Developer' }}</h2>
                <p class="mt-5 max-w-3xl whitespace-pre-line text-lg leading-8 text-slate-400">{{ $profile?->bio ?? 'I design and build dependable digital experiences from idea to launch.' }}</p>
                <div class="mt-8 flex flex-wrap gap-3 text-sm text-slate-300"><span>📍 {{ $profile?->location ?? 'Available worldwide' }}</span><span>✦ {{ $profile?->years_of_experience ?? 5 }}+ years experience</span></div>
            </div>
        @elseif ($page === 'skills')
            @forelse ($categories as $category)
                <div class="rounded-3xl border border-white/10 bg-white/[.03] p-7">
                    <h2 class="text-xl font-semibold text-white">{{ $category->name }}</h2>
                    <div class="mt-5 flex flex-wrap gap-2">
                        @foreach ($category->skills as $skill)
                            <span class="rounded-full bg-cyan-300/10 px-3 py-1.5 text-sm text-cyan-200">{{ $skill->name }}</span>
                        @endforeach
                    </div>
                </div>
            @empty
                <p class="text-slate-400">Skills will appear here soon.</p>
            @endforelse
        @elseif ($page === 'experience')
            @forelse ($experiences as $item)
                <article class="rounded-3xl border border-white/10 bg-white/[.03] p-7"><p class="font-mono text-sm text-cyan-300">{{ $item->start_date?->format('M Y') }} — {{ $item->is_current ? 'Present' : $item->end_date?->format('M Y') }}</p><h2 class="mt-3 text-2xl font-semibold text-white">{{ $item->position }}</h2><p class="mt-1 text-slate-400">{{ $item->company }} · {{ $item->location }}</p><p class="mt-5 leading-7 text-slate-400">{{ $item->description }}</p></article>
            @empty
                <p class="text-slate-400">Experience will appear here soon.</p>
            @endforelse
        @elseif ($page === 'education')
            @forelse ($educations as $item)
                <article class="rounded-3xl border border-white/10 bg-white/[.03] p-7"><p class="text-sm text-cyan-300">{{ $item->start_date?->format('Y') }} — {{ $item->end_date?->format('Y') ?? 'Present' }}</p><h2 class="mt-3 text-2xl font-semibold text-white">{{ $item->degree }}</h2><p class="mt-1 text-slate-400">{{ $item->school }} · {{ $item->major }}</p><p class="mt-5 leading-7 text-slate-400">{{ $item->description }}</p></article>
            @empty
                <p class="text-slate-400">Education will appear here soon.</p>
            @endforelse
        @else
            @forelse ($certificates as $item)
                <article class="rounded-3xl border border-white/10 bg-white/[.03] p-7">
                    <p class="text-sm text-cyan-300">{{ $item->issue_date?->format('M Y') }}</p>
                    <h2 class="mt-3 text-2xl font-semibold text-white">{{ $item->title }}</h2>
                    <p class="mt-1 text-slate-400">{{ $item->issuer }}</p>
                    @if ($item->url)
                        <a class="mt-5 inline-block text-cyan-300" href="{{ $item->url }}" target="_blank" rel="noreferrer">View credential ↗</a>
                    @endif
                </article>
            @empty
                <p class="text-slate-400">Certificates will appear here soon.</p>
            @endforelse
        @endif
    </div>
</section>
@endsection
