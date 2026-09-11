@props(['name','label','type'=>'text','value'=>null])
<label class="block text-sm text-slate-700">{{ $label }}<input name="{{ $name }}" type="{{ $type }}" value="{{ old($name,$value) }}" {{ $attributes->merge(['class'=>'mt-2 w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3']) }}>@error($name)<span class="mt-1 block text-xs text-red-600">{{ $message }}</span>@enderror</label>
