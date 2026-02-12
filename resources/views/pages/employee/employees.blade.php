@extends('layouts.app')

@section('content')
    <x-common.page-breadcrumb pageTitle="Employees" />
    @include('layouts.filter.filter-page')

    @include('layouts.message')

    <div class="space-y-6">

        <x-common.component-card ButtonName="Add Employee" title="Employees List" modalTitle='Add Employee'>
            <div
                class="overflow-x-auto rounded-xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
                <table class="w-full">
                    <thead class="border-b border-gray-200 bg-gray-50 dark:border-gray-700 dark:bg-white/5">
                        <tr>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900 dark:text-white">ID</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900 dark:text-white">Name</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900 dark:text-white">Email</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900 dark:text-white">Mobile</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900 dark:text-white">National ID
                            </th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900 dark:text-white">Merchant
                            </th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900 dark:text-white">Branch</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900 dark:text-white">Status</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900 dark:text-white">Date</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900 dark:text-white">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                        @foreach ($employees as $employee)
                            <tr class="hover:bg-gray-50 dark:hover:bg-white/5">
                                <td class="px-6 py-4 text-sm font-medium text-gray-900 dark:text-white">E -
                                    {{ $employee->id }}</td>
                                <td class="px-6 py-4 text-sm font-medium text-gray-900 dark:text-white">
                                    {{ $employee->name }}</td>
                                <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-400">{{ $employee->email }}</td>
                                <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-400">{{ $employee->phone ?? '-' }}
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-400">
                                    {{ $employee->national_id ?? '-' }}</td>
                                <td class="px-6 py-4 text-sm font-medium text-gray-900 dark:text-white">
                                    {{ $employee->merchant?->name ?? '-' }}</td>
                                <td class="px-6 py-4 text-sm font-medium text-gray-900 dark:text-white">
                                    {{ $employee->branch?->name ?? '-' }}</td>
                                <td class="px-6 py-4 text-sm">
                                    @php
                                        $statusClasses = [
                                            1 => 'bg-green-50 text-green-700 dark:bg-green-500/15 dark:text-green-500',
                                            0 => 'bg-yellow-50 text-yellow-700 dark:bg-yellow-500/15 dark:text-yellow-400',
                                        ];
                                    @endphp
                                    <span
                                        class="inline-flex rounded-full px-3 py-1 text-xs font-semibold {{ $statusClasses[$employee->is_active] ?? 'bg-gray-50 text-gray-700 dark:bg-gray-500/15 dark:text-gray-500' }}">
                                        {{ $employee->is_active ? 'Active' : 'Inactive' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-400">
                                    {{ $employee->created_at->format('Y M d') }}</td>
                                <td class="px-6 py-4">
                                    <div class="flex gap-2">
                                        <a href="{{ route('employees.show', $employee->id) }}"
                                            class="inline-flex items-center justify-center rounded bg-blue-50 px-2.5 py-1.5 text-blue-700 hover:bg-blue-100 dark:bg-blue-500/15 dark:text-blue-400 dark:hover:bg-blue-500/25">
                                            {!! menu_icon('view-icon') !!}
                                        </a>

                                        <x-form.modals.employee-modal modalTitle='Edit Employee' :employee="$employee" />

                                        <x-form.modals.confirm-delete
                                            action="{{ route('employees.delete', $employee->id) }}" method="DELETE"
                                            title="Delete Employee"
                                            message="Are you sure you want to delete the employee '{{ $employee->name }}'? This action cannot be undone.">
                                            {!! menu_icon('delete-icon') !!}
                                        </x-form.modals.confirm-delete>

                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                {{-- Pagination --}}
                <div class="mt-4">
                    {{ $employees->links() }}
                </div>
            </div>

    </div>
    </x-common.component-card>
    </div>
@endsection
