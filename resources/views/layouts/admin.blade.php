<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'Dashboard' }} · Portfolio Admin</title>
    <style>.admin-profile.max-w-3xl{max-width:none!important;width:100%}.admin-profile>form.admin-card{width:100%}</style>
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot'))) @vite(['resources/css/app.css', 'resources/js/app.js']) @endif
</head>
<body class="admin-shell bg-[#f5f8fb] text-slate-700">
<div class="min-h-screen lg:flex">
<aside id="admin-sidebar" class="fixed inset-y-0 left-0 z-40 w-64 -translate-x-full border-r border-slate-800 bg-[#111827] text-slate-300 transition-transform lg:sticky lg:top-0 lg:h-screen lg:translate-x-0">
<div class="flex h-16 items-center border-b border-white/10 px-6"><a href="{{ route('admin.dashboard') }}" class="text-3xl font-extrabold tracking-tight text-white">Panda<span class="text-cyan-300">.</span></a></div>
<div class="border-b border-white/10 bg-white/[.04] px-5 py-4"><div class="flex items-center gap-3"><div class="grid h-10 w-10 place-items-center rounded-full bg-cyan-300 font-bold text-slate-900">{{ str($profile?->user?->name ?? auth()->user()->name)->substr(0, 1) }}</div><div class="min-w-0"><p class="truncate text-sm font-semibold text-white">{{ $profile?->user?->name ?? auth()->user()->name }}</p><p class="text-xs text-slate-400">Administrator</p></div></div></div>
<nav class="h-[calc(100vh-137px)] overflow-y-auto px-4 py-5 text-sm">
<p class="mb-3 px-2 text-[11px] font-bold uppercase tracking-wider text-slate-500">Workspace</p>
<a href="{{ route('admin.dashboard') }}" class="admin-nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">▦ <span>Dashboard</span></a>
<p class="mb-3 mt-7 px-2 text-[11px] font-bold uppercase tracking-wider text-slate-500">Portfolio management</p>
@foreach ([['profile.edit','Profile','♙'],['projects','Projects','▣'],['technologies','Technologies','◈'],['skill-categories','Skill categories','◇'],['skills','Skills','✦'],['experience','Experience','◷'],['education','Education','▤'],['certificates','Certificates','▧'],['blog','Blog posts','✎'],['testimonials','Testimonials','♡'],['messages','Contact messages','✉'],['social-links','Social links','◎'],['settings','Settings','⚙']] as [$slug,$label,$icon])
    @php
        if ($slug === 'profile.edit') {
            $href = route('admin.profile.edit');
        } elseif (in_array($slug, ['skills', 'social-links', 'technologies', 'skill-categories', 'experience', 'education', 'certificates', 'blog', 'blog-categories', 'testimonials'], true)) {
            $href = route('admin.'.$slug.'.index');
        } elseif ($slug === 'messages') {
            $href = route('admin.messages.index');
        } elseif ($slug === 'settings') {
            $href = route('admin.settings.edit');
        } elseif ($slug === 'resume') {
            $href = route('admin.resume.edit');
        } else {
            $href = route('admin.module', ['module' => $slug]);
        }
    @endphp
    <a href="{{ $href }}" class="admin-nav-item {{ request()->routeIs('admin.'.$slug) ? 'active' : '' }}"><span class="w-5 text-center text-slate-500">{{ $icon }}</span><span>{{ $label }}</span></a>
@endforeach
</nav>
</aside>
<div class="min-w-0 flex-1"><header class="sticky top-0 z-30 flex h-16 items-center justify-between border-b border-slate-200 bg-white/90 px-5 backdrop-blur lg:px-8"><div class="flex items-center gap-4"><button id="admin-menu" class="text-xl text-slate-500 lg:hidden">☰</button><div class="hidden items-center gap-2 rounded-lg bg-slate-50 px-3 py-2 text-sm text-slate-400 sm:flex">⌕ <input class="w-44 bg-transparent outline-none placeholder:text-slate-400" placeholder="Search"></div></div><div class="flex items-center gap-4 text-slate-400"><form method="GET" action="{{ url()->current() }}" class="hidden items-center gap-2 text-xs sm:flex"><label for="per_page">Rows</label><select id="per_page" name="per_page" onchange="this.form.submit()" class="rounded-lg border border-slate-200 bg-white px-2 py-1 text-slate-700"><option value="10" @selected(request('per_page',10)==10)>10</option><option value="20" @selected(request('per_page')==20)>20</option><option value="50" @selected(request('per_page')==50)>50</option></select></form><span>◐</span><span>♡</span><span>⚙</span><form method="POST" action="{{ route('admin.logout') }}">@csrf<button class="text-sm font-medium hover:text-slate-800">Log out</button></form></div></header>@yield('content')</div>
</div><div id="admin-confirm" class="fixed inset-0 z-[100] hidden items-center justify-center bg-slate-950/40 p-5"><div class="w-full max-w-md rounded-2xl bg-white p-6 shadow-2xl"><h2 class="text-xl font-bold text-slate-900">Confirm deletion</h2><p id="admin-confirm-message" class="mt-2 text-sm text-slate-600">Are you sure you want to delete this item?</p><div class="mt-6 flex justify-end gap-3"><button type="button" id="admin-confirm-cancel" class="rounded-lg border border-slate-200 px-4 py-2 text-sm font-semibold text-slate-700">Cancel</button><button type="button" id="admin-confirm-accept" class="rounded-lg bg-red-600 px-4 py-2 text-sm font-semibold text-white">Delete</button></div></div></div><script>document.getElementById('admin-menu')?.addEventListener('click',()=>document.getElementById('admin-sidebar').classList.toggle('-translate-x-full'));const modal=document.getElementById('admin-confirm');let pending=null;document.querySelectorAll('form[onsubmit]').forEach(form=>{const message=form.getAttribute('onsubmit').match(/confirm\('([^']+)/)?.[1]||'Are you sure you want to delete this item?';form.removeAttribute('onsubmit');form.addEventListener('submit',e=>{e.preventDefault();pending=form;document.getElementById('admin-confirm-message').textContent=message;modal.classList.remove('hidden');modal.classList.add('flex')})});document.getElementById('admin-confirm-cancel')?.addEventListener('click',()=>{pending=null;modal.classList.add('hidden');modal.classList.remove('flex')});document.getElementById('admin-confirm-accept')?.addEventListener('click',()=>{if(pending){const form=pending;pending=null;modal.classList.add('hidden');modal.classList.remove('flex');form.submit()}});</script></body></html>
