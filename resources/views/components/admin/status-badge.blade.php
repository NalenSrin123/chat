@props(['status'])
<span class="inline-flex rounded-full px-3 py-1 text-xs font-semibold {{ in_array($status,['published','completed','replied','read']) ? 'bg-emerald-50 text-emerald-700' : ($status === 'new' ? 'bg-sky-50 text-sky-700' : 'bg-amber-50 text-amber-700') }}">{{ ucfirst(str_replace('_',' ',$status)) }}</span>
