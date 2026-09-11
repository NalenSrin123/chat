@extends('layouts.admin')

@section('content')
<main class="admin-profile p-5 lg:p-8">
    <p class="font-mono text-sm text-blue-600">ADMIN / PROFILE</p>
    <h1 class="mt-3 text-4xl font-bold text-slate-900">Profile management</h1>
    @if (session('success'))<div class="mt-6 rounded-xl border border-emerald-200 bg-emerald-50 p-4 text-emerald-700">{{ session('success') }}</div>@endif
    @if ($errors->any())<div class="mt-6 rounded-xl border border-red-200 bg-red-50 p-4 text-red-700">Please correct the highlighted fields.</div>@endif
    <form method="POST" action="{{ route('admin.profile.update') }}" enctype="multipart/form-data" class="mt-8 space-y-8">
        @csrf @method('PUT')
        <section class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm md:p-8">
            <h2 class="text-xl font-semibold text-slate-900">Identity</h2>
            <div class="mt-6 grid gap-5 md:grid-cols-2">
                @foreach ([['name','Full name','text'],['title','Professional title','text'],['location','Location','text'],['phone','Phone','text'],['contact_email','Contact email','email'],['website','Personal website','url'],['years_of_experience','Years of experience','number']] as [$name,$label,$type])
                    <label class="text-sm text-slate-500">{{ $label }}<input name="{{ $name }}" type="{{ $type }}" value="{{ old($name, $name === 'name' ? $profile->user?->name : $profile->{$name}) }}" class="mt-2 w-full rounded-xl border {{ $errors->has($name) ? 'border-red-400' : 'border-slate-200' }} bg-white px-4 py-3 text-slate-900 outline-none focus:border-blue-400 focus:ring-2 focus:ring-blue-100">@error($name)<span class="mt-1 block text-xs text-red-500">{{ $message }}</span>@enderror</label>
                @endforeach
            </div>
        </section>
        <section class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm md:p-8">
            <h2 class="text-xl font-semibold text-slate-900">Profile image</h2>
            <div class="mt-6 flex flex-wrap items-center gap-6"><div id="avatar-preview" class="h-24 w-24 overflow-hidden rounded-2xl bg-slate-100">@if($profile->avatar)<img src="{{ asset('storage/'.$profile->avatar) }}" class="h-full w-full object-cover" alt="Current profile image">@endif</div><label class="text-sm text-slate-500">Choose image<input id="avatar" name="avatar" type="file" accept="image/jpeg,image/png,image/webp" class="mt-2 block text-sm text-slate-500 file:mr-3 file:rounded-full file:border-0 file:bg-blue-50 file:px-4 file:py-2 file:text-blue-600 hover:file:bg-blue-100">@error('avatar')<span class="mt-1 block text-xs text-red-500">{{ $message }}</span>@enderror</label></div>
        </section>
        @foreach ([['bio','Short bio',3],['full_bio','Full biography',6],['career_goals','Career goals',4],['developer_journey','Developer journey',6],['languages','Languages',3],['interests','Interests',3]] as [$name,$label,$rows])
            <section class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm md:p-8"><label class="text-sm text-slate-500">{{ $label }}<textarea name="{{ $name }}" rows="{{ $rows }}" class="mt-2 w-full rounded-xl border {{ $errors->has($name) ? 'border-red-400' : 'border-slate-200' }} bg-white px-4 py-3 text-slate-900 outline-none focus:border-blue-400 focus:ring-2 focus:ring-blue-100">{{ old($name, $profile->{$name}) }}</textarea>@error($name)<span class="mt-1 block text-xs text-red-500">{{ $message }}</span>@enderror</label></section>
        @endforeach
        <button class="rounded-full bg-blue-600 px-6 py-3 font-semibold text-white hover:bg-blue-700">Save profile</button>
    </form>
    <script>document.getElementById('avatar')?.addEventListener('change', function (event) { const file = event.target.files[0]; if (!file) return; const reader = new FileReader(); reader.onload = function (e) { document.getElementById('avatar-preview').innerHTML = '<img src="' + e.target.result + '" class="h-full w-full object-cover" alt="Selected profile image">'; }; reader.readAsDataURL(file); });</script>
</main>
@endsection