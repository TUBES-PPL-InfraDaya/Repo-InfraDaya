@props([
    'id',
    'title' => 'Konfirmasi Aksi',
    'message' => 'Apakah Anda yakin ingin melanjutkan aksi ini? Tindakan ini tidak dapat dibatalkan.',
    'confirmText' => 'Ya, Lanjutkan',
    'cancelText' => 'Batal',
    'confirmVariant' => 'danger',
    'action' => null,
    'method' => 'POST',
])

<div
    x-data="{ open: false }"
    x-show="open"
    x-on:open-modal.window="if ($event.detail === '{{ $id }}') open = true"
    x-on:close-modal.window="if ($event.detail === '{{ $id }}') open = false"
    x-on:keydown.escape.window="open = false"
    style="display: none;"
    class="fixed inset-0 z-50 overflow-y-auto"
    aria-labelledby="modal-title-{{ $id }}"
    role="dialog"
    aria-modal="true"
>
    <!-- Backdrop -->
    <div
        x-show="open"
        x-transition:enter="ease-out duration-200"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="ease-in duration-150"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm transition-opacity"
        @click="open = false"
    ></div>

    <!-- Modal Box -->
    <div class="flex min-h-screen items-center justify-center p-4 text-center sm:p-0">
        <div
            x-show="open"
            x-transition:enter="ease-out duration-200"
            x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
            x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
            x-transition:leave="ease-in duration-150"
            x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
            x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
            class="relative transform overflow-hidden rounded-2xl bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg border border-slate-200"
        >
            <form action="{{ $action }}" method="{{ strtolower($method) === 'get' ? 'GET' : 'POST' }}">
                @if (strtolower($method) !== 'get')
                    @csrf
                    @if (!in_array(strtoupper($method), ['POST']))
                        @method($method)
                    @endif
                @endif

                <div class="bg-white px-6 pb-4 pt-6">
                    <div class="sm:flex sm:items-start gap-4">
                        @if ($confirmVariant === 'danger')
                            <div class="mx-auto flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full bg-rose-100 sm:mx-0">
                                <svg class="h-6 w-6 text-rose-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                                </svg>
                            </div>
                        @else
                            <div class="mx-auto flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full bg-amber-100 sm:mx-0">
                                <svg class="h-6 w-6 text-amber-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                        @endif

                        <div class="mt-3 text-center sm:ml-2 sm:mt-0 sm:text-left flex-1">
                            <h3 class="text-lg font-semibold leading-6 text-brand-navy" id="modal-title-{{ $id }}">
                                {{ $title }}
                            </h3>
                            <div class="mt-2 text-sm text-slate-600">
                                <p>{{ $message }}</p>
                            </div>

                            @if ($slot->isNotEmpty())
                                <div class="mt-4">
                                    {{ $slot }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="bg-slate-50 px-6 py-4 sm:flex sm:flex-row-reverse sm:gap-3 border-t border-slate-100">
                    <x-button :variant="$confirmVariant" type="submit" class="w-full sm:w-auto">
                        {{ $confirmText }}
                    </x-button>
                    <x-button variant="secondary" type="button" @click="open = false" class="mt-2 sm:mt-0 w-full sm:w-auto">
                        {{ $cancelText }}
                    </x-button>
                </div>
            </form>
        </div>
    </div>
</div>
