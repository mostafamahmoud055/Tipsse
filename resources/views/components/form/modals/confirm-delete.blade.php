{{-- resources/views/components/confirm-delete.blade.php --}}
@props([
    'action' => '#',
    'method' => 'POST',
    'title' => 'Confirm Deletion',
    'message' => 'Are you sure you want to delete this item? This action cannot be undone.',
    'buttonText' => 'Delete',
    'buttonClass' => 'bg-red-600 hover:bg-red-700',
])

<div x-data="{ isOpen: false }" class="inline-block">
    {{-- Trigger --}}
    <button @click="isOpen = true"
        {{ $attributes->merge(['class' => 'inline-flex items-center justify-center rounded bg-red-50 px-2.5 py-1.5 text-red-700 hover:bg-red-100 dark:bg-red-500/15 dark:text-red-400 dark:hover:bg-red-500/25']) }}>
        {!! $slot !!}
    </button>

    {{-- Modal --}}
    <div x-show="isOpen" x-cloak class="fixed inset-0 z-99999 flex items-center justify-center p-5 overflow-y-auto"
        style="display: none;">

        {{-- Overlay --}}
        <div class="fixed inset-0 h-full w-full bg-gray-400/50 backdrop-blur-[32px]" @click="isOpen = false"></div>

        {{-- Modal Content --}}
        <div @click.outside="isOpen = false" class="relative w-full max-w-md rounded-3xl bg-white p-6 dark:bg-gray-900">

            {{-- Close button --}}
            <button @click="isOpen = false"
                class="absolute right-3 top-3 flex h-9 w-9 items-center justify-center rounded-full bg-gray-100 text-gray-400 hover:bg-gray-200 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                <svg class="fill-current" width="24" height="24" viewBox="0 0 24 24">
                    <path d="M6 6L18 18M6 18L18 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" />
                </svg>
            </button>

            {{-- Content --}}
            <h4 class="font-semibold text-gray-800 dark:text-white/90 mb-4 text-lg">{{ $title }}</h4>
            <p class="text-sm text-gray-500 dark:text-gray-400">{{ $message }}</p>

            {{-- Actions --}}
            <div class="mt-6 flex justify-end gap-3">
                <button @click="isOpen = false"
                    class="rounded-lg border border-gray-300 px-4 py-2 text-sm text-gray-700 dark:border-gray-700 dark:text-gray-400">
                    Cancel
                </button>
                <form method="POST" action="{{ $action }}">
                    @csrf
                    @if (strtoupper($method) !== 'POST')
                        @method($method)
                    @endif
                    <button type="submit"
                        class="rounded-lg px-4 py-2 text-sm font-medium text-white {{ $buttonClass }}">
                        {{ $buttonText }}
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
