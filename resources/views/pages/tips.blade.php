@extends('layouts.app')

@section('content')
    <x-common.page-breadcrumb pageTitle="Tip" />

    <div class="grid sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
        @include('layouts.statistics.card-statistics', [
            'title' => 'Total Tips',
            'value' => $payments->stats['total_tips'],
            'icon' => 'images/icons/g3196.png',
            'iconBg' => 'bg-icon-purple',
            'period' => null,
        ])
        @include('layouts.statistics.card-statistics', [
            'title' => 'Released Tips',
            'value' => $payments->stats['released_tips'],
            'icon' => 'images/icons/tabler_check.png',
            'iconBg' => 'bg-icon-green',    
            'period' => null,
        ])
        @include('layouts.statistics.card-statistics', [
            'title' => 'Pending Tips',
            'value' => $payments->stats['pending_tips'],
            'icon' => 'images/icons/quill_info.png',
            'iconBg' => 'bg-icon-yellow',
            'period' => null,
        ])
        @include('layouts.statistics.card-statistics', [
            'title' => 'Rejected Tips',
            'value' => $payments->stats['rejected_tips'],
            'icon' => 'images/icons/material-symbols_close-rounded.png',
            'iconBg' => 'bg-icon-red',
            'period' => null,
        ])
    </div>

    <div class="space-y-6">
        <x-common.component-card title="Tips List">
            <!-- Filters -->


            <!-- Table -->
            <div
                class="overflow-x-auto rounded-xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
                <table class="w-full">
                    <thead class="border-b border-gray-200 bg-gray-50 dark:border-gray-700 dark:bg-white/5">
                        <tr>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900 dark:text-white">Employee</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900 dark:text-white">Merchant</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900 dark:text-white">Branch</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900 dark:text-white">Rating</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900 dark:text-white">Amount</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900 dark:text-white">Status</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900 dark:text-white">Date</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                        @forelse($payments as $payment)
                            <tr class="hover:bg-gray-50 dark:hover:bg-white/5 transition-colors duration-150">
                                <td class="px-6 py-4 text-sm font-medium text-gray-900 dark:text-white">
                                    {{ $payment->employee->name ?? 'N/A' }}
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-400">
                                    {{ $payment->employee->user->name ?? 'N/A' }}
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-400">
                                    {{ $payment->employee->branch->name ?? 'N/A' }}
                                </td>
                                <td class="px-6 py-4 text-sm">
                                    @if ($payment->rating)
                                        <div class="flex items-center gap-1">
                                            @for ($i = 1; $i <= 5; $i++)
                                                <svg class="w-4 h-4 {{ $i <= $payment->rating ? 'text-yellow-400' : 'text-gray-300 dark:text-gray-600' }}"
                                                    fill="currentColor" viewBox="0 0 24 24">
                                                    <path
                                                        d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z" />
                                                </svg>
                                            @endfor
                                        </div>
                                    @else
                                        <span class="text-xs text-gray-500 dark:text-gray-400">Not rated</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-sm font-semibold text-gray-900 dark:text-white">
                                    ${{ number_format($payment->amount, 2) }}
                                </td>
                                <td class="px-6 py-4 text-sm">
                                    <span
                                        class="inline-flex rounded-full px-3 py-1 text-xs font-semibold
                                        @if ($payment->status === 'successful') bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-300
                                        @elseif($payment->status === 'pending')
                                            bg-yellow-100 dark:bg-yellow-900/30 text-yellow-800 dark:text-yellow-300
                                        @else
                                            bg-red-100 dark:bg-red-900/30 text-red-800 dark:text-red-300 @endif
                                    ">
                                        {{ ucfirst($payment->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-400">
                                    {{ $payment->created_at->format('M d, Y H:i') }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="px-6 py-8 text-center text-sm text-gray-500 dark:text-gray-400">
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="mt-6 flex justify-center">
                {{ $payments->links() }}
            </div>
        </x-common.component-card>
    </div>
@endsection
