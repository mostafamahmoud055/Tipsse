{{-- Success --}}
@if (session('success'))
    <div x-data="{ show: true }" x-show="show"
        x-init="setTimeout(() => show = false, 5000)"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 translate-y-2"
        x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="transition ease-in duration-500"
        x-transition:leave-start="opacity-100 translate-y-0"
        x-transition:leave-end="opacity-0 -translate-y-2"
        class="mb-5 rounded-lg border border-green-300 bg-green-50 p-4 text-sm text-green-700 dark:border-green-700 dark:bg-green-900/30 dark:text-green-400">
        {{ session('success') }}
    </div>
@endif


{{-- Warning --}}
@if (session('warning'))
    <div x-data="{ show: true }" x-show="show"
        x-init="setTimeout(() => show = false, 5000)"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 translate-y-2"
        x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="transition ease-in duration-500"
        x-transition:leave-start="opacity-100 translate-y-0"
        x-transition:leave-end="opacity-0 -translate-y-2"
        class="mb-5 rounded-lg border border-yellow-300 bg-yellow-50 p-4 text-sm text-yellow-700 dark:border-yellow-700 dark:bg-yellow-900/30 dark:text-yellow-400">
        {{ session('warning') }}
    </div>
@endif


{{-- Errors --}}
@if ($errors->any())
    <div x-data="{ show: true }" x-show="show"
        x-init="setTimeout(() => show = false, 5000)"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 translate-y-2"
        x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="transition ease-in duration-500"
        x-transition:leave-start="opacity-100 translate-y-0"
        x-transition:leave-end="opacity-0 -translate-y-2"
        class="mb-5 rounded-lg border border-red-300 bg-red-50 p-4 text-sm text-red-700 dark:border-red-700 dark:bg-red-900/30 dark:text-red-400">
        <ul class="list-disc list-inside space-y-1">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
