@extends('layouts.app')

@section('content')
    <x-common.page-breadcrumb pageTitle="Merchants" />
    @include('layouts.filter.filter-page')
    <div class="grid sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10 mb-5">

        @include('layouts.statistics.card-statistics', [
            'title' => 'Total Merchants',
            'value' => 202,
            'icon' => 'images/icons/Vector.png',
            'iconBg' => 'bg-icon-green',
            'percentage' => '+23',
            'period' => 'since last month',
        ])
        @include('layouts.statistics.card-statistics', [
            'title' => 'Active Branches',
            'value' => 563,
            'icon' => 'images/icons/tabler_check.png',
            'iconBg' => 'bg-icon-green',
            'percentage' => '+23',
            'period' => 'since last month',
        ])
        @include('layouts.statistics.card-statistics', [
            'title' => 'Not Active Branches',
            'value' => 563,
            'icon' => 'images/icons/material-symbols_close-rounded.png',
            'iconBg' => 'bg-icon-red',
            'percentage' => '+23',
            'period' => 'since last month',
        ])
    </div>
    @include('layouts.message')

    <div class="space-y-6">

        <x-common.component-card ButtonName="Add Merchant" title="Merchants List" modalTitle='Add Merchant'>
            <div
                class="overflow-x-auto rounded-xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
                <table class="w-full">
                    <thead class="border-b border-gray-200 bg-gray-50 dark:border-gray-700 dark:bg-white/5">
                        <tr>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900 dark:text-white">ID</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900 dark:text-white">Name</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900 dark:text-white">Busssness
                                Type</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900 dark:text-white">Email</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900 dark:text-white">Phone</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900 dark:text-white">Status</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900 dark:text-white">Date</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900 dark:text-white">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                        @foreach ($applications as $app)
                            <tr class="hover:bg-gray-50 dark:hover:bg-white/5">
                                <td class="px-6 py-4 text-sm font-medium text-gray-900 dark:text-white">
                                    M - {{ $app->merchant->id }}
                                </td>
                                <td class="px-6 py-4 text-sm font-medium text-gray-900 dark:text-white">
                                    {{ $app->user->name }}
                                </td>
                                <td class="px-6 py-4 text-sm font-medium text-gray-900 dark:text-white">
                                    {{ $app->merchant->business_type }}
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-400">
                                    {{ $app->user->email }}
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-400">
                                    {{ $app->merchant->phone ?? '-' }}
                                </td>
                                <td class="px-6 py-4 text-sm">
                                    @php
                                        $statusClasses = [
                                            'Active' =>
                                                'bg-green-50 text-green-700 dark:bg-green-500/15 dark:text-green-500',
                                            'Inactive' =>
                                                'bg-yellow-50 text-yellow-700 dark:bg-yellow-500/15 dark:text-yellow-400',
                                            'rejected' => 'bg-red-50 text-red-700 dark:bg-red-500/15 dark:text-red-500',
                                        ];
                                    @endphp
                                    <span
                                        class="inline-flex rounded-full px-3 py-1 text-xs font-semibold {{ $statusClasses[$app->merchant->is_active ] ?? 'bg-gray-50 text-gray-700 dark:bg-gray-500/15 dark:text-gray-500' }}">
                                        {{ ucfirst($app->merchant->is_active) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-400">
                                    {{ $app->created_at->format('Y M d') }}
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex gap-2">
                                        <div class="flex gap-2">
                                            {{-- View --}}
                                            <a href="{{ route('merchants.show', $app->id) }}"
                                                class="inline-flex items-center justify-center rounded bg-blue-50 px-2.5 py-1.5 text-blue-700 hover:bg-blue-100 dark:bg-blue-500/15 dark:text-blue-400 dark:hover:bg-blue-500/25">
                                                {!! menu_icon('view-icon') !!}
                                            </a>

                                            {{-- Edit --}}
                                            <x-form.modals.merchant-modal modalTitle='Edit Merchant' :application=$app />


                                            {{-- Delete --}}
                                            <form method="POST" action="{{ route('merchants.delete', $app->id) }}"
                                                onsubmit="return confirm('Are you sure?')" class="inline-flex">
                                                @csrf
                                                @method('DELETE')

                                                <button type="submit"
                                                    class="inline-flex items-center justify-center rounded
                       bg-red-50 px-2.5 py-1.5
                       text-red-700 hover:bg-red-100
                       dark:bg-red-500/15 dark:text-red-400 dark:hover:bg-red-500/25">
                                                    {!! menu_icon('delete-icon') !!}
                                                </button>
                                            </form>
                                        </div>

                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                {{-- Pagination Links --}}
                <div class="mt-4">
                    {{ $applications->links() }}
                </div>
            </div>

            <!-- Pagination Info and Controls -->
            @include('layouts.paginate')
    </div>
    </x-common.component-card>
    </div>
@endsection
