@props([
    'label' => null,
    'name',
    'type' => 'text',
    'value' => null,
    'placeholder' => null,
    'required' => false,
    'help' => null,
])

<div {{ $attributes->merge(['class' => 'space-y-1.5']) }}>
    @if ($label)
        <label for="{{ $name }}" class="block text-sm font-semibold text-brand-navy">
            {{ $label }}
            @if ($required)
                <span class="text-rose-500">*</span>
            @endif
        </label>
    @endif

    <div class="relative">
        <input
            type="{{ $type }}"
            id="{{ $name }}"
            name="{{ $name }}"
            value="{{ old($name, $value) }}"
            placeholder="{{ $placeholder }}"
            @if ($required) required @endif
            {{ $attributes->whereDoesntStartWith('class') }}
            class="block w-full rounded-xl border-slate-300 bg-white px-4 py-2.5 text-sm text-slate-800 placeholder-slate-400 shadow-sm transition-colors focus:border-brand-teal focus:ring-2 focus:ring-brand-teal/20 disabled:bg-slate-50 @error($name) border-rose-400 focus:border-rose-500 focus:ring-rose-200 @enderror"
        >
    </div>

    @if ($help)
        <p class="text-xs text-slate-500">{{ $help }}</p>
    @endif

    @error($name)
        <p class="text-xs font-medium text-rose-600 flex items-center gap-1 mt-1">
            <svg class="h-3.5 w-3.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0118 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
            </svg>
            {{ $message }}
        </p>
    @enderror
</div>
