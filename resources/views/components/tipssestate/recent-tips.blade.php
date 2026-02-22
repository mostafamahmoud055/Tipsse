@props(['tips' => []])

@php
    $defaultTips = [];
@endphp

<div
    class="overflow-hidden rounded-2xl border border-gray-200 bg-white px-4 dark:border-gray-800 dark:bg-white/[0.03] sm:px-6">
    <div class="flex flex-col gap-2 my-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h3 class="text-lg font-semibold text-gray-800 dark:text-white/90">Recent Tips</h3>
        </div>

        <div class="flex items-center gap-3">
            <a href="{{ route('tips') }}" style="cursor: pointer;"
                class="text-brand-400 inline-flex items-center py-2.5 font-medium">
                <span class="whitespace-nowrap">See More</span>
                {!! menu_icon('narrow-right-arrow') !!}
            </a>
        </div>
    </div>

    <div class="max-w-full overflow-x-auto custom-scrollbar">
        <table class="min-w-full">
            <tbody>
                @forelse ($tips as $tip)
                    <tr class="border-t border-gray-100 dark:border-gray-800">
                        <td class="py-3 whitespace-nowrap">
                            <div class="flex items-center gap-3">
                                <div
                                    class="h-[50px] w-[50px] overflow-hidden rounded-md flex items-center justify-center 
                                    @if ($tip->status === 'successful') bg-green-50
                                    @elseif($tip->status === 'pending') bg-yellow-50
                                    @else bg-red-50 @endif
                                    ">
                                    @if ($tip->status === 'successful')
                                        <img src="{{ asset('images/icons/g3196.png') }}" alt="">
                                    @elseif($tip->status === 'pending')
                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                            stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                            stroke-linejoin="round" class="text-yellow-600">
                                            <circle cx="12" cy="12" r="10"></circle>
                                            <polyline points="12 6 12 12 16 14"></polyline>
                                        </svg>
                                    @else
                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                            stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                            stroke-linejoin="round" class="text-red-600">
                                            <circle cx="12" cy="12" r="10"></circle>
                                            <line x1="15" y1="9" x2="9" y2="15"></line>
                                            <line x1="9" y1="9" x2="15" y2="15"></line>
                                        </svg>
                                    @endif
                                </div>
                                <div>
                                    <p class="font-medium text-gray-800 text-theme-sm dark:text-white/90">
                                        {{ $tip->employee->name ?? 'Unknown' }}
                                    </p>
                                    <span
                                        class="text-gray-500 text-theme-sm dark:text-gray-400">{{ $tip->employee->branch->name ?? 'N/A' }}
                                    </span>
                                </div>
                            </div>
                        </td>

                        <td class="py-3 whitespace-nowrap">
                            <span class="font-medium text-gray-800 text-theme-sm dark:text-white/90">
                                $ {{ number_format($tip->amount, 2) }}
                            </span>
                        </td>
                        <td class="py-3 whitespace-nowrap">
                            <span
                                class="rounded-full px-2 py-0.5 text-theme-xs font-medium
                                @if ($tip->status === 'successful') bg-success-50 text-success-600 dark:bg-success-500/15 dark:text-success-500
                                @elseif($tip->status === 'pending') bg-warning-50 text-warning-600 dark:bg-warning-500/15 dark:text-orange-400
                                @else bg-error-50 text-error-600 dark:bg-error-500/15 dark:text-error-500 @endif
                            ">
                                {{ ucfirst($tip->status) }}
                            </span>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="py-8 text-center">
                            <p class="text-gray-500 dark:text-gray-400">No tips yet</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
