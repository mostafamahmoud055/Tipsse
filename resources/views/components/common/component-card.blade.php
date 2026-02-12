@props(['title', 'desc' => '', 'ButtonName' => '', 'modalTitle' => ''])

<div
    {{ $attributes->merge(['class' => 'rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]']) }}>

    <!-- Card Header -->
    <div class="grid grid-cols-1 gap-4 px-6 py-5 md:grid-cols-2 ">
        <!-- Title & Description -->
        <div class="w-full">
            <h3 class="text-base font-medium text-gray-800 dark:text-white/90">
                {{ $title }}
            </h3>
            @if ($desc)
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                    {{ $desc }}
                </p>
            @endif
        </div>

        <!-- Filter & Button -->
        <div class="flex flex-col gap-3 w-full md:flex-row md:justify-end ">


            @if ($ButtonName)
                @if ($ButtonName == 'Add Merchant')
                    <x-form.modals.merchant-modal :ButtonName=$ButtonName :modalTitle=$modalTitle />
                @elseif($ButtonName == 'Add Business Type')
                    <x-form.modals.business-modal :ButtonName=$ButtonName :modalTitle=$modalTitle />
                @elseif($ButtonName == 'Add Branch')
                    <x-form.modals.branch-modal :ButtonName=$ButtonName :modalTitle=$modalTitle />
                @elseif($ButtonName == 'Add Employee')
                    <x-form.modals.employee-modal :ButtonName=$ButtonName :modalTitle=$modalTitle />
                @endif
            @endif
        </div>
    </div>
    <div class="flex flex-col gap-3 w-full md:flex-row md:justify-end px-6">
        @include('layouts.filter.filter-table')
    </div>


    <!-- Card Body -->
    <div class="p-4 border-t border-gray-100 dark:border-gray-800 sm:p-6">
        <div class="space-y-6">
            {{ $slot }}
        </div>
    </div>
</div>
