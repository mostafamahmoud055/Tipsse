@props(['name', 'options' => [], 'selected' => [], 'label' => 'Multiple Select Options'])

@php
    // Transform simple array to Alpine-friendly objects
    $alpineOptions = collect($options)
        ->map(
            fn($item) => [
                'id' => $item,
                'name' => ucfirst($item),
            ],
        )
        ->values();
@endphp

<div {{ $attributes->class([]) }}>
    <div x-data="{
        open: false,
        selected: @js($selected),
        options: @js($alpineOptions),
    
        toggleOption(id) {
            if (this.selected.includes(id)) {
                this.selected = this.selected.filter(i => i !== id);
            } else {
                this.selected.push(id);
            }
        },
    
        isSelected(id) {
            return this.selected.includes(id);
        }
    }" class="relative" @click.away="open = false">

        <!-- Hidden inputs (Laravel-friendly array) -->
        <template x-for="id in selected" :key="id">
            <input type="hidden" name="{{ $name ?? 'no name' }}[]" :value="id">
        </template>

        <!-- Select Input -->
        <div @click="open = !open"
            {{ $attributes->merge([
                'class' =>
                    'shadow-theme-xs flex min-h-11 cursor-pointer gap-2 rounded-lg border border-gray-300 bg-white px-3 py-2 transition dark:border-gray-700 dark:bg-gray-900',
            ]) }}>
            <!-- Selected Tags -->
            <div class="flex flex-1 flex-wrap items-center gap-2">
                <template x-for="id in selected" :key="id">
                    <div
                        class="group flex items-center rounded-full border border-transparent bg-gray-100 py-1 pr-2 pl-2.5 text-sm text-gray-800 hover:border-gray-200 dark:bg-gray-800 dark:text-white/90">
                        <span x-text="options.find(o => o.id === id)?.name"></span>

                        <button type="button" @click.stop="toggleOption(id)"
                            class="ml-1 text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-300">
                            ✕
                        </button>
                    </div>
                </template>

                <!-- Placeholder -->
                <span x-show="selected.length === 0" class="text-sm text-gray-500 dark:text-gray-400">
                    Select options...
                </span>
            </div>

            <!-- Arrow -->
            <div class="flex items-start pt-1.5">
                <svg class="h-5 w-5 shrink-0 text-gray-500 transition-transform dark:text-gray-400"
                    :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                </svg>
            </div>
        </div>

        <!-- Dropdown -->
        <div x-show="open" x-transition
            class="absolute z-50 mt-1 w-full overflow-hidden rounded-lg border border-gray-200 bg-white dark:border-gray-700 dark:bg-gray-900"
            style="max-height: 16rem">
            <div class="overflow-y-auto" style="max-height: 16rem">
                <template x-for="option in options" :key="option.id">
                    <div @click="toggleOption(option.id)"
                        class="cursor-pointer border-b border-gray-200 px-4 py-3 text-sm transition  hover:bg-gray-50 last:border-b-0 dark:border-gray-800 dark:hover:bg-gray-800"
                        :class="isSelected(option.id) ? 'font-semibold text-brand-400' : ''">
                        <span x-text="option.name"></span>
                    </div>
                </template>
            </div>
        </div>

    </div>
</div>
