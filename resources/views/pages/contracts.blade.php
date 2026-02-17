@extends('layouts.app')

@section('content')
    <x-common.page-breadcrumb pageTitle="Merchant Contracts" />
    @include('layouts.filter.filter-page')
    @include('layouts.message')

    <div class="space-y-6">
        <x-common.component-card title="Merchant Contracts List">
            <div
                class="overflow-x-auto rounded-xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
                <table class="w-full">
                    <thead class="border-b border-gray-200 bg-gray-50 dark:border-gray-700 dark:bg-white/5">
                        <tr>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900 dark:text-white">ID</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900 dark:text-white">Merchant Name</th>
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
                                    M - {{ $app->user->id }}
                                </td>
                                <td class="px-6 py-4 text-sm font-medium text-gray-900 dark:text-white">
                                    {{ $app->user->name }}
                                </td>
                                <td class="px-6 py-4 text-sm font-medium text-gray-900 dark:text-white">
                                    {{ $app->user->business_type }}
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-400">
                                    {{ $app->user->email }}
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-400">
                                    {{ $app->user->phone ?? '-' }}
                                </td>
                                <td class="px-6 py-4 text-sm">
                                    @php
                                        $statusClasses = [
                                            'approved' =>
                                                'bg-green-50 text-green-700 dark:bg-green-500/15 dark:text-green-500',
                                            'pending' =>
                                                'bg-yellow-50 text-yellow-700 dark:bg-yellow-500/15 dark:text-yellow-400',
                                            'rejected' => 'bg-red-50 text-red-700 dark:bg-red-500/15 dark:text-red-500',
                                        ];
                                    @endphp

                                    <span
                                        class="inline-flex rounded-full px-3 py-1 text-xs font-semibold {{ $statusClasses[$app->status] ?? 'bg-gray-50 text-gray-700 dark:bg-gray-500/15 dark:text-gray-500' }}">
                                        {{ $app->status }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-400">
                                    {{ $app->created_at->format('Y M d') }}
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex gap-2">
                                        <div class="flex gap-2">
 

                                            {{-- Edit --}}
                                            <x-form.modals.contract-modal modalTitle='Edit Contract' :application=$app  />

                                        </div>

                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

               <div class="m-4 flex justify-center">
                    {{ $applications->links() }}
                </div>
            </div>
        </x-common.component-card>
    </div>
@endsection
