@extends('layouts.chat')
@section('content')
<style>
    .chat-page { background: #f0f2f5 !important; color: #172033; }
    .chat-page main { background: #f0f2f5 !important; }
    .chat-page section { max-width: none !important; padding: 0 !important; }
    .chat-page section > div { height: calc(100vh - 32px) !important; min-height: 0 !important; border: 0 !important; border-radius: 0 !important; box-shadow: none !important; }
    .chat-page aside { background: #fff; }
    .chat-page main { background: #fff !important; }
</style>
<section class="mx-auto max-w-7xl px-4 py-10">
<div class="grid h-[700px] overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm lg:grid-cols-[360px_1fr]">

<aside class="flex flex-col border-r border-slate-200 bg-white">
    <div class="flex items-center justify-between px-5 py-4">
        <h1 class="text-xl font-bold text-slate-900">Chats</h1>
        <button onclick="document.getElementById('new-chat').classList.remove('hidden')" class="grid h-9 w-9 place-items-center rounded-full bg-slate-100 text-slate-600 transition hover:bg-slate-200" aria-label="New chat">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M12 5v14M5 12h14"/></svg>
        </button>
    </div>

    <div class="px-5 pb-3">
        <div class="flex items-center gap-2 rounded-full bg-slate-100 px-4 py-2.5">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 shrink-0 text-slate-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><circle cx="11" cy="11" r="7"/><path d="m21 21-4.3-4.3"/></svg>
            <input type="text" placeholder="Search Messenger" class="w-full bg-transparent text-sm text-slate-700 placeholder:text-slate-400 focus:outline-none">
        </div>
    </div>

    <div class="flex-1 space-y-0.5 overflow-y-auto px-2 pb-4">
        @forelse($conversations as $item)
            @php($other = $item->participants->where('id', '!=', auth()->id())->first())
            <a href="{{ route('chat.index', ['conversation' => $item->id]) }}"
               class="flex items-center gap-3 rounded-xl px-3 py-2.5 transition hover:bg-slate-100 {{ $conversation?->id === $item->id ? 'bg-blue-50 hover:bg-blue-50' : '' }}">
                <div class="relative shrink-0">
                    <div class="grid h-14 w-14 place-items-center rounded-full bg-gradient-to-br from-indigo-400 to-blue-500 text-lg font-semibold text-white">
                        {{ str($other?->name ?? 'C')->substr(0, 1)->upper() }}
                    </div>
                    <span class="absolute bottom-0 right-0 h-3.5 w-3.5 rounded-full border-2 border-white bg-emerald-500"></span>
                </div>
                <div class="min-w-0 flex-1">
                    <div class="flex items-center justify-between gap-2">
                        <span class="truncate {{ $item->unread_count ? 'font-semibold text-slate-900' : 'font-medium text-slate-700' }}">
                            {{ $other?->name ?? 'Conversation' }}
                        </span>
                        @if($item->lastMessage)
                            <span class="shrink-0 text-xs text-slate-400">{{ $item->lastMessage->created_at->format('H:i') }}</span>
                        @endif
                    </div>
                    <div class="flex items-center justify-between gap-2">
                        <p class="truncate text-sm {{ $item->unread_count ? 'font-medium text-slate-900' : 'text-slate-500' }}">
                            {{ $item->lastMessage?->message ?? 'No messages yet' }}
                        </p>
                        @if($item->unread_count)
                            <span class="grid h-5 min-w-5 shrink-0 place-items-center rounded-full bg-blue-500 px-1.5 text-[11px] font-semibold text-white">{{ $item->unread_count }}</span>
                        @endif
                    </div>
                </div>
            </a>
        @empty
            <div class="flex h-full flex-col items-center justify-center gap-2 px-6 py-16 text-center">
                <p class="text-sm font-medium text-slate-500">No conversations yet</p>
                <p class="text-xs text-slate-400">Start a new chat to say hello.</p>
            </div>
        @endforelse
    </div>
</aside>

<main class="flex h-[700px] flex-col bg-white">
@if($conversation)
    @php($otherParticipant = $conversation->participants->where('id', '!=', auth()->id())->first())

    <header class="flex items-center justify-between border-b border-slate-200 px-6 py-3.5">
        <div class="flex items-center gap-3">
            <div class="grid h-10 w-10 place-items-center rounded-full bg-gradient-to-br from-indigo-400 to-blue-500 text-sm font-semibold text-white">
                {{ str($otherParticipant?->name ?? 'C')->substr(0, 1)->upper() }}
            </div>
            <div>
                <h2 class="font-semibold leading-tight text-slate-900">{{ $otherParticipant?->name ?? 'Chat' }}</h2>
                <p class="text-xs font-medium text-emerald-500">Active now</p>
            </div>
        </div>
        <div class="flex items-center gap-1 text-slate-400">
            <button class="grid h-9 w-9 place-items-center rounded-full transition hover:bg-slate-100 hover:text-blue-500" aria-label="Voice call">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
            </button>
            <button class="grid h-9 w-9 place-items-center rounded-full transition hover:bg-slate-100 hover:text-blue-500" aria-label="Conversation info">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="M12 16v-4M12 8h.01"/></svg>
            </button>
        </div>
    </header>

    <div id="messages" class="flex-1 space-y-2 overflow-y-auto px-6 py-5">
        @foreach($messages->reverse() as $message)
            @php($own = $message->sender_id === auth()->id())
            <div data-message-id="{{ $message->id }}" class="flex items-end gap-2 {{ $own ? 'justify-end' : '' }}">
                @unless($own)
                    <div class="grid h-7 w-7 shrink-0 place-items-center rounded-full bg-slate-200 text-[11px] font-semibold text-slate-600">
                        {{ str($message->sender?->name ?? 'U')->substr(0, 1)->upper() }}
                    </div>
                @endunless
                <div class="group max-w-[68%]">
                    <div class="rounded-[20px] px-4 py-2 {{ $own ? 'rounded-br-md bg-blue-500 text-white' : 'rounded-bl-md bg-slate-100 text-slate-900' }}">
                        @if($message->type === 'image' && $message->file_path)<img src="{{ asset('storage/'.$message->file_path) }}" alt="Shared image" class="mb-2 max-h-72 rounded-xl object-cover">@endif
                        @if($message->message)<p class="whitespace-pre-wrap text-[15px] leading-snug">{{ $message->message }}</p>@endif
                    </div>
                    <time class="mt-1 block px-1 text-[11px] text-slate-400 opacity-0 transition group-hover:opacity-100 {{ $own ? 'text-right' : '' }}">
                        {{ $message->created_at->format('H:i') }}@if($own) · Sent ✓@endif
                    </time>
                </div>
            </div>
        @endforeach
    </div>

    <form id="send-form" method="POST" enctype="multipart/form-data" action="{{ route('chat.messages.send', $conversation) }}" class="flex items-end gap-2 border-t border-slate-200 px-4 py-3">
        @csrf
        <label class="grid h-10 w-10 shrink-0 cursor-pointer place-items-center rounded-full text-blue-500 transition hover:bg-slate-100" aria-label="Attach"><input id="attachment" type="file" name="attachment" accept="image/png,image/jpeg,image/gif,image/webp" class="hidden">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="18" rx="4"/><circle cx="8.5" cy="8.5" r="1.5"/><path d="M21 15l-5-5L5 21"/></svg>
        </label><button type="button" id="emoji-button" class="grid h-10 w-10 shrink-0 place-items-center rounded-full text-xl text-blue-500 transition hover:bg-slate-100" aria-label="Emoji">☺</button>
        <div class="flex flex-1 items-end rounded-3xl bg-slate-100 px-4 py-2">
            <textarea name="message" rows="1" class="max-h-32 min-w-0 flex-1 resize-none bg-transparent py-1 text-[15px] text-slate-900 placeholder:text-slate-400 focus:outline-none" placeholder="Aa"></textarea>
        </div>
        <button type="submit" class="grid h-10 w-10 shrink-0 place-items-center rounded-full text-blue-500 transition hover:bg-slate-100" aria-label="Send">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" viewBox="0 0 24 24" fill="currentColor"><path d="M2.01 21 23 12 2.01 3 2 10l15 2-15 2z"/></svg>
        </button>
    </form><div id="emoji-picker" class="absolute bottom-20 right-20 hidden w-64 rounded-2xl border border-slate-200 bg-white p-3 shadow-xl"><div class="grid grid-cols-8 gap-2 text-xl">@foreach(['😀','😂','😍','😊','😎','🤔','😭','😡','👍','❤️','🔥','🎉','🙏','👏','💯','✅'] as $emoji)<button type="button" class="emoji-option rounded p-1 hover:bg-slate-100">{{ $emoji }}</button>@endforeach</div></div>
@else
    <div class="grid flex-1 place-items-center px-6 text-center">
        <div>
            <div class="mx-auto mb-4 grid h-16 w-16 place-items-center rounded-full bg-slate-100 text-slate-400">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
            </div>
            <p class="font-medium text-slate-600">Select a conversation</p>
            <p class="mt-1 text-sm text-slate-400">Or start a new chat to get talking.</p>
        </div>
    </div>
@endif
</main>
</div>
</section>

@if($conversation)
<script>
document.addEventListener('DOMContentLoaded', function () {
    var box = document.getElementById('messages'), form = document.getElementById('send-form'),
        input = form?.querySelector('textarea'), uid = {{ auth()->id() }};

    function esc(v) {
        return String(v).replace(/[&<>]/g, function (c) { return { '&': '&amp;', '<': '&lt;', '>': '&gt;' }[c] });
    }

    function add(m) {
        var own = Number(m.sender_id) === uid;
        if (box?.querySelector('[data-message-id="' + m.id + '"]')) return;
        var content = (m.type === 'image' && m.file_path ? '<img src="/storage/' + encodeURIComponent(m.file_path).replace(/%2F/g, '/') + '" alt="Shared image" class="mb-2 max-h-72 rounded-xl object-cover">' : '') + (m.message ? '<p class="whitespace-pre-wrap text-[15px] leading-snug">' + esc(m.message) + '</p>' : '');
        box.insertAdjacentHTML('beforeend',
            '<div data-message-id="' + m.id + '" class="flex items-end gap-2 ' + (own ? 'justify-end' : '') + '">' +
                '<div class="max-w-[68%]">' +
                    '<div class="rounded-[20px] px-4 py-2 ' + (own ? 'rounded-br-md bg-blue-500 text-white' : 'rounded-bl-md bg-slate-100 text-slate-900') + '">' +
                        content +
                    '</div>' +
                    '<time class="mt-1 block px-1 text-[11px] text-slate-400 ' + (own ? 'text-right' : '') + '">now' + (own ? ' · Sent ✓' : '') + '</time>' +
                '</div>' +
            '</div>');
        box.scrollTo({ top: box.scrollHeight, behavior: 'smooth' });
    }

    function connect() {
        if (window.Echo) window.Echo.private('conversation.{{ $conversation->id }}').listen('.message.sent', e => add(e.message));
        else setTimeout(connect, 250);
    }
    connect();

    input?.addEventListener('keydown', function (e) {
        if (e.key === 'Enter' && !e.shiftKey) { e.preventDefault(); form.requestSubmit(); }
    });

    form?.addEventListener('submit', async function (e) {
        e.preventDefault();
        if (!input.value.trim() && !document.getElementById('attachment')?.files.length) return;
        var r = await fetch(form.action, {
            method: 'POST',
            body: new FormData(form),
            headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json', 'X-Socket-ID': window.Echo?.socketId() || '' }
        });
        if (!r.ok) return;
        var d = await r.json();
        add(d.message);
        input.value = '';
        document.getElementById('attachment').value = '';
        input.style.height = 'auto';
    });
});
</script>
@endif

<div id="new-chat" class="fixed inset-0 z-[60] hidden bg-black/40 p-6">
    <div class="mx-auto mt-24 max-w-lg rounded-2xl bg-white p-6 shadow-xl">
        <div class="flex items-center justify-between">
            <h2 class="text-lg font-bold text-slate-900">New message</h2>
            <button type="button" onclick="document.getElementById('new-chat').classList.add('hidden')" class="grid h-8 w-8 place-items-center rounded-full text-slate-400 transition hover:bg-slate-100" aria-label="Close">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M18 6 6 18M6 6l12 12"/></svg>
            </button>
        </div>
        <div class="mt-5 flex items-center gap-2 rounded-full bg-slate-100 px-4 py-2.5">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 shrink-0 text-slate-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><circle cx="11" cy="11" r="7"/><path d="m21 21-4.3-4.3"/></svg>
            <input id="user-search" placeholder="Search people" class="w-full bg-transparent text-sm text-slate-700 placeholder:text-slate-400 focus:outline-none">
        </div>
        <div id="user-results" class="mt-2 max-h-80 divide-y divide-slate-100 overflow-y-auto"></div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    var search = document.getElementById('user-search'), results = document.getElementById('user-results');
    search?.addEventListener('input', async function () {
        if (!search.value.trim()) { results.innerHTML = ''; return; }
        var response = await fetch('{{ route('chat.users') }}?q=' + encodeURIComponent(search.value), {
            headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' }
        });
        if (!response.ok) return;
        var users = await response.json();
        results.innerHTML = users.map(function (user) {
            return '<form method="POST" action="{{ route('chat.start') }}" class="flex items-center justify-between gap-3 py-3">' +
                '@csrf' +
                '<input type="hidden" name="user_id" value="' + user.id + '">' +
                '<div class="flex items-center gap-3">' +
                    '<div class="grid h-10 w-10 place-items-center rounded-full bg-gradient-to-br from-indigo-400 to-blue-500 text-sm font-semibold text-white">' + (user.name || 'U').charAt(0).toUpperCase() + '</div>' +
                    '<span class="text-slate-900">' + user.name + ' <small class="text-slate-400">@' + (user.username || '') + '</small></span>' +
                '</div>' +
                '<button class="rounded-full bg-blue-500 px-4 py-1.5 text-xs font-semibold text-white transition hover:bg-blue-600">Chat</button>' +
            '</form>';
        }).join('') || '<p class="py-6 text-center text-sm text-slate-400">No users found.</p>';
    });
});
</script>
<script>
document.addEventListener('DOMContentLoaded',function(){var aside=document.querySelector('aside');if(!aside)return;var list=aside.querySelector('.divide-y');if(!list)return;var input=document.createElement('input');input.type='search';input.placeholder='Search chats by username';input.className='mx-4 my-4 w-[calc(100%-2rem)] rounded-xl border-0 bg-white/5 px-4 py-3 text-sm text-white outline-none placeholder:text-white/40';list.parentNode.insertBefore(input,list);input.addEventListener('input',function(){var q=input.value.toLowerCase().trim();list.querySelectorAll('a').forEach(function(item){item.classList.toggle('hidden',q!==''&&!item.textContent.toLowerCase().includes(q))})})});
</script>
<script>
document.addEventListener('DOMContentLoaded',function(){var aside=document.querySelector('aside'),input=aside?.querySelector('input[placeholder="Search Messenger"]'),list=aside?.querySelector('.flex-1');if(!input||!list)return;input.addEventListener('input',function(){var query=input.value.toLowerCase().trim();list.querySelectorAll('a').forEach(function(chat){chat.classList.toggle('hidden',query!==''&&!chat.textContent.toLowerCase().includes(query))})})});
</script>
<script>
document.addEventListener('DOMContentLoaded',function(){var input=document.querySelector('#send-form textarea'),picker=document.getElementById('emoji-picker'),button=document.getElementById('emoji-button');button?.addEventListener('click',function(){picker.classList.toggle('hidden')});document.querySelectorAll('.emoji-option').forEach(function(option){option.addEventListener('click',function(){input.value+=option.textContent;input.focus();picker.classList.add('hidden')})});document.getElementById('attachment')?.addEventListener('change',function(){if(this.files[0])this.closest('form').querySelector('button[type="submit"]').title=this.files[0].name})});
</script>
@endsection
