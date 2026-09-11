@extends('layouts.admin')

@section('content')
<main class="admin-profile p-5 lg:p-8">
    <p class="font-mono text-sm uppercase tracking-widest text-cyan-600">Admin / {{ str($module)->replace('-', ' ') }}</p>
    <h1 class="mt-3 text-4xl font-bold capitalize text-black">{{ str($module)->replace('-', ' ') }}</h1>
    <section class="mt-8 rounded-2xl border border-slate-200 bg-white p-8 shadow-sm">
        <h2 class="text-xl font-semibold text-black">{{ str($module)->replace('-', ' ') }} management</h2>
        <p class="mt-3 text-black">This protected module route is ready for its management tools.</p>
    </section>
</main>
@endsection
