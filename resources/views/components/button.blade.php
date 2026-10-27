@props([
    'variant' => 'primary',
    'type' => 'button',
    'size' => 'md',
    'href' => null,
])

@php
    $baseClasses = 'inline-flex items-center justify-center gap-2 rounded-xl font-medium transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 disabled:opacity-50 disabled:cursor-not-allowed';

    $sizeClasses = match($size) {
        'sm' => 'px-3 py-1.5 text-xs',
        'lg' => 'px-6 py-3 text-base',
        default => 'px-4 py-2.5 text-sm',
    };

    $variantClasses = match($variant) {
        'primary' => 'bg-brand-navy hover:bg-navy-900 text-white shadow-sm hover:shadow focus:ring-brand-navy',
        'teal' => 'bg-brand-teal hover:bg-teal-700 text-white shadow-sm hover:shadow focus:ring-brand-teal',
        'amber' => 'bg-brand-amber hover:bg-amber-600 text-slate-950 font-semibold shadow-sm hover:shadow-md focus:ring-brand-amber',
        'danger' => 'bg-rose-600 hover:bg-rose-700 text-white shadow-sm hover:shadow focus:ring-rose-500',
        'secondary' => 'bg-slate-100 hover:bg-slate-200 text-slate-700 border border-slate-300 focus:ring-slate-400',
        'outline' => 'border-2 border-brand-navy text-brand-navy hover:bg-brand-navy hover:text-white focus:ring-brand-navy',
        default => 'bg-brand-navy hover:bg-navy-900 text-white focus:ring-brand-navy',
    };

    $classes = "{$baseClasses} {$sizeClasses} {$variantClasses}";
@endphp

@if ($href)
    <a href="{{ $href }}" {{ $attributes->merge(['class' => $classes]) }}>
        {{ $slot }}
    </a>
@else
    <button type="{{ $type }}" {{ $attributes->merge(['class' => $classes]) }}>
        {{ $slot }}
    </button>
@endif
