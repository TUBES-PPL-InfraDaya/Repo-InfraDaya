@props([
    'title' => 'Belum Ada Data',
    'description' => 'Data yang Anda cari tidak ditemukan atau belum tersedia saat ini.',
    'actionText' => null,
    'actionUrl' => null,
])

<div {{ $attributes->merge(['class' => 'flex flex-col items-center justify-center rounded-2xl border-2 border-dashed border-slate-200 bg-white/60 p-12 text-center']) }}>
    <div class="flex h-16 w-16 items-center justify-center rounded-2xl bg-brand-bg text-brand-navy">
        <svg class="h-8 w-8 text-brand-teal" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
        </svg>
    </div>

    <h3 class="mt-4 text-base font-semibold text-brand-navy">{{ $title }}</h3>
    <p class="mt-1.5 max-w-sm text-sm text-slate-500">{{ $description }}</p>

    @if ($actionText && $actionUrl)
        <div class="mt-6">
            <x-button variant="primary" :href="$actionUrl">
                {{ $actionText }}
            </x-button>
        </div>
    @endif

    {{ $slot }}
</div>
