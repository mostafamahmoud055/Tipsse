<div
    {{ $attributes->merge(['class' => 'overflow-hidden rounded-2xl border border-gray-200 bg-white px-4 dark:border-gray-800 dark:bg-white/[0.03] sm:px-6']) }}>
    
    <div class="flex flex-col gap-2 my-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h3 class="text-lg font-semibold text-gray-800 dark:text-white/90">{{ $title }}</h3>
        </div>

        <div class="flex items-center gap-3">
            <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ current_month('M') }}</h3> 
         <img src="{{ asset("images/icons/calendar_223396 1.png") }}" alt="">
        </div>
    </div>
<hr>
    <div class="max-w-full overflow-x-auto custom-scrollbar p-6">
        <table class="min-w-full">
            <tbody>
                {{ $slot }}
            </tbody>
        </table>
    </div>

</div>
