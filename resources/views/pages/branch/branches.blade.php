@extends('layouts.app')

@section('content')
    <x-common.page-breadcrumb pageTitle="Branches" />
    @include('layouts.filter.filter-page')
    @include('layouts.message')

    <div class="space-y-6">
        <x-common.component-card ButtonName="Add Branch" title="Branches List" modalTitle='Add Branch'>

            <div
                class="overflow-x-auto rounded-xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
                <table class="w-full">
                    <thead class="border-b border-gray-200 bg-gray-50 dark:border-gray-700 dark:bg-white/5">
                        <tr>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900 dark:text-white">ID</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900 dark:text-white"></th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900 dark:text-white">Name</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900 dark:text-white">Merchant
                            </th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900 dark:text-white">Employee
                            </th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900 dark:text-white">Phone</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900 dark:text-white">Date</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900 dark:text-white">Status</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900 dark:text-white">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                        @foreach ($branches as $branch)
                            <tr class="hover:bg-gray-50 dark:hover:bg-white/5">
                                <td class="px-6 py-4 text-sm font-medium text-gray-900 dark:text-white">
                                    B - {{ $branch->id }}
                                </td>
                                <td class="px-0 py-0 text-sm font-medium text-gray-900 dark:text-white">
                                    @if ($branch->image)
                                        <img src="{{ route('image.show', ['path' => $branch->image]) }}"
                                            class="h-12 w-12 rounded-full object-cover" alt="Merchant Logo">
                                    @endif
                                </td>

                                <td class="  px-6 py-4 text-sm font-medium text-gray-900 dark:text-white">

                                    {{ $branch->name }}

                                </td>
                                <td class="px-6 py-4 text-sm font-medium text-gray-900 dark:text-white">
                                    {{ $branch->merchant->name }}
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-400">
                                    -
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-400">
                                    {{ $branch->merchant->phone ?? '-' }}
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-400">
                                    {{ $branch->created_at->format('Y M d') }}
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
                                        class="inline-flex rounded-full px-3 py-1 text-xs font-semibold {{ $statusClasses[$branch->is_active] ?? 'bg-gray-50 text-gray-700 dark:bg-gray-500/15 dark:text-gray-500' }}">
                                        {{ ucfirst($branch->is_active) }}
                                    </span>
                                </td>

                                <td class="px-6 py-4">
                                    <div class="flex gap-2">
                                        <div class="flex gap-2">
                                            {{-- View --}}
                                            <a href="{{ route('branches.show', ['branch' => $branch->id]) }}"
                                                class="inline-flex items-center justify-center rounded bg-blue-50 px-2.5 py-1.5 text-blue-700 hover:bg-blue-100 dark:bg-blue-500/15 dark:text-blue-400 dark:hover:bg-blue-500/25">
                                                {!! menu_icon('view-icon') !!}
                                            </a>


                                            <x-form.modals.branch-modal modalTitle="Edit Branch" :branch="$branch" />


                                            {{-- Delete --}}
                                            <x-form.modals.confirm-delete
                                                action="{{ route('branches.delete', $branch->id) }}" method="DELETE"
                                                title="Delete Branch"
                                                message="Are you sure you want to delete the branch '{{ $branch->name }}'? This action cannot be undone.">
                                                {!! menu_icon('delete-icon') !!}
                                            </x-form.modals.confirm-delete>

                                        </div>

                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

               <div class="m-4 flex justify-center">
                    {{ $branches->links() }}
                </div>
            </div>
        </x-common.component-card>
    </div>
@endsection
