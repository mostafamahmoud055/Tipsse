@extends('layouts.app')

@section('content')
    <x-common.page-breadcrumb pageTitle="Business Types" />
    @include('layouts.message')

    <div class="space-y-6">

        <x-common.component-card ButtonName="Add Business Type" title="Business Types List" modalTitle='Add Business Type'>
            <div
                class="overflow-x-auto rounded-xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
                <table class="w-full">
                    <thead class="border-b border-gray-200 bg-gray-50 dark:border-gray-700 dark:bg-white/5">
                        <tr>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900 dark:text-white">Name</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900 dark:text-white">Date</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900 dark:text-white">Actions</th>


                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                        @foreach ($types as $type)
                            <tr class="hover:bg-gray-50 dark:hover:bg-white/5">
                                <td class="px-6 py-4 text-sm font-medium text-gray-900 dark:text-white">
                                    {{ $type->name }}
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-400">
                                    {{ $type->created_at->format('Y M d') }}
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex gap-2">
                                        <div class="flex gap-2">

                                            {{-- Edit --}}

                                            <x-form.modals.business-modal modalTitle="Edit Business Type"
                                                :type="$type" />


                                            {{-- Delete --}}
                                            <x-form.modals.confirm-delete
                                                action="{{ route('business_types.delete', $type->id) }}" method="DELETE"
                                                title="Delete Business Type"
                                                message="Are you sure you want to delete this business type? This action cannot be undone.">
                                                {!! menu_icon('delete-icon') !!}
                                                </x-confirm-delete>

                                        </div>

                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

               <div class="m-4 flex justify-center">
                    {{ $types->links() }}
                </div>
            </div>
        </x-common.component-card>
    </div>
@endsection
