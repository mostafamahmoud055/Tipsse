@props([
    'name' => null,
    'placeholder' => 'Select option',
    'options' => [],
    'value' => null,
])

@php
    $selectedValue = old($name, $value);
@endphp
<div>

    <div x-data="{ isOptionSelected: false }" class="relative z-20 bg-transparent">
        <select name="{{ $name }}" @change="isOptionSelected = true"
            class="dark:bg-dark-900 h-11 w-full appearance-none rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 pr-11 text-sm shadow-theme-xs focus:border-brand-300 focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90"
            :class="isOptionSelected && 'text-gray-800 dark:text-white/90'">

            <!-- Placeholder -->
            <option value="" {{ $selectedValue === null || $selectedValue === '' ? 'selected' : '' }}
                class="text-sm text-gray-500 dark:text-gray-400">
                {{ $placeholder }}
            </option>

            <!-- Options Loop -->
            @foreach ($options as $optionValue => $label)
                <option value="{{ $optionValue }}"
                    {{ (string) $selectedValue === (string) $optionValue ? 'selected' : '' }}
                    class="text-gray-700 dark:bg-gray-900 dark:text-gray-400">
                    {{ $label }}
                </option>
            @endforeach
        </select>
        <!-- Dropdown Arrow -->
        <span
            class="pointer-events-none absolute top-1/2 right-4 z-30 -translate-y-1/2 text-gray-700 dark:text-gray-400">
            <svg class="stroke-current" width="20" height="20" viewBox="0 0 20 20" fill="none"
                xmlns="http://www.w3.org/2000/svg">
                <path d="M4.79175 7.396L10.0001 12.6043L15.2084 7.396" stroke="" stroke-width="1.5"
                    stroke-linecap="round" stroke-linejoin="round" />
            </svg>
        </span>
    </div>
</div>