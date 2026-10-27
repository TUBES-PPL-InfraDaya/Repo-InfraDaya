@props([
    'title' => null,
    'subtitle' => null,
    'actions' => null,
    'footer' => null,
])

<div {{ $attributes->merge(['class' => 'rounded-2xl border border-slate-200/80 bg-white p-6 shadow-sm shadow-slate-200/50 transition-all']) }}>
    @if ($title || $actions)
        <div class="mb-5 flex flex-wrap items-center justify-between gap-3 border-b border-slate-100 pb-4">
            <div>
                @if ($title)
                    <h3 class="text-lg font-semibold text-brand-navy">{{ $title }}</h3>
                @endif
                @if ($subtitle)
                    <p class="mt-0.5 text-xs text-slate-500">{{ $subtitle }}</p>
                @endif
            </div>
            @if ($actions)
                <div class="flex items-center gap-2">
                    {{ $actions }}
                </div>
            @endif
        </div>
    @endif

    <div>
        {{ $slot }}
    </div>

    @if ($footer)
        <div class="mt-6 border-t border-slate-100 pt-4 text-sm text-slate-600">
            {{ $footer }}
        </div>
    @endif
</div>
