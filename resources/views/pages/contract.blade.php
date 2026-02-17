@extends('layouts.app')

@section('content')
    <x-common.page-breadcrumb pageTitle="Merchant Contract" />

    <div class="space-y-6">
        <div class="space-y-6">
            <!-- Contract Header -->
            <div class="border-b border-gray-200 pb-6 dark:border-gray-700">
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Merchant Service Agreement</h1>
                <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">Contract Date: {{ date('F d, Y') }}</p>
            </div>
            @include('layouts.message')

            <!-- Contract Content -->
            <div class="space-y-4 text-gray-700 dark:text-gray-300">
                @can('merchant-only', 'merchant_owner')
                    <div class="flex justify-between">
                        <p class="text-lg font-semibold text-gray-900 dark:text-white">
                            Dear <span class="text-brand-600 dark:text-brand-400">{{ $user?->name }}</span>,
                        </p>
                        @php
                            $statusClasses = [
                                'approved' => 'bg-green-50 text-green-700 dark:bg-green-500/15 dark:text-green-500',
                                'pending' => 'bg-yellow-50 text-yellow-700 dark:bg-yellow-500/15 dark:text-yellow-400',
                                'rejected' => 'bg-red-50 text-red-700 dark:bg-red-500/15 dark:text-red-500',
                            ];
                        @endphp

                        <span
                            class="inline-flex rounded-full px-3 py-1 text-xs font-semibold {{ $statusClasses[$user?->application?->status] ?? 'bg-gray-50 text-gray-700 dark:bg-gray-500/15 dark:text-gray-500' }}">
                            {{ $user?->application?->status }}
                        </span>
                    </div>
                    <p class="leading-relaxed">
                        This contract is between our company and <strong>{{ $user?->business_type }}</strong>
                        located at <strong>{{ auth()?->user()?->email }}</strong>.
                    </p>

                    <div class="rounded-lg bg-gray-50 p-4 dark:bg-gray-800/50">
                        <p class="font-semibold text-gray-900 dark:text-white">Contact Information:</p>
                        <p class="mt-2">
                            <span class="font-medium">Phone:</span> {{ $user?->phone }}
                        </p>
                    </div>
                @endcan
                <div class="flex items-center justify-between">

                    <h2 class="mt-6 text-xl font-bold text-gray-900 dark:text-white">Contract Terms:</h2>
                    @can('role', 'super_admin')
                        <x-form.modals.condition-modal ButtonName="Add Condition" modalTitle="Add Condition" />
                    @endcan
                </div>

                <div class="space-y-4">
                    @foreach ($contractTerms as $index => $term)
                        <div class="rounded-lg border border-gray-200 p-4 dark:border-gray-700">
                            <div class="flex justify-between items-center gap-2 mt-3">
                                <div>

                                    <h3 class="font-semibold text-gray-900 dark:text-white">
                                        {{ $index + 1 }}. {{ $term['name'] }}
                                    </h3>
                                    <p class="mt-2 text-sm leading-relaxed">
                                        {{ $term['condition'] }}
                                    </p>
                                </div>
                                @can('role', 'super_admin')
                                    <div class="flex gap-2 mt-3">

                                        {{-- Edit --}}
                                        <x-form.modals.condition-modal modalTitle="Edit Condition" :term="$term" />

                                        {{-- Delete --}}
                                        <x-form.modals.confirm-delete action="{{ route('contract.delete', $term->id) }}"
                                            method="DELETE" title="Delete Condition"
                                            message="Are you sure you want to delete this Condition? This action cannot be undone.">
                                            {!! menu_icon('delete-icon') !!}
                                        </x-form.modals.confirm-delete>
                                    </div>
                                @endcan
                            </div>
                        </div>
                    @endforeach

                </div>

                <p class="mt-6 leading-relaxed">
                    By accepting this contract, the Merchant agrees to be bound by all the terms and conditions outlined
                    above.
                    If you have any questions regarding this agreement, please contact our support team.
                </p>
            </div>

            <!-- Contract Actions -->
            <div class="border-t border-gray-200 pt-6 dark:border-gray-700">
                <div class="flex flex-col gap-3 sm:flex-row sm:justify-end">
                    @if ($user?->application?->status == 'approved')
                        <button onclick="window.print()"
                            class="inline-flex items-center justify-center rounded bg-gray-200 px-6 py-2.5 text-sm font-semibold text-gray-900 hover:bg-gray-300 dark:bg-gray-700 dark:text-white dark:hover:bg-gray-600">
                            Print Contract
                        </button>
                        <a href="{{ route('contract.pdf') }}"
                            class="inline-flex items-center justify-center rounded bg-blue-600 px-6 py-2.5 text-sm font-semibold text-white hover:bg-blue-700 dark:bg-blue-500 dark:hover:bg-blue-600">
                            Download PDF
                        </a>
                    @endif
                    @if ($user?->application?->status == 'pending')
                        <form method="POST" action="{{ route('contract.update', $user->application->id) }}">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="status" value="rejected">

                            <button type="submit"
                                class="inline-flex items-center justify-center rounded bg-red-600 px-6 py-2.5 text-sm font-semibold text-white hover:bg-red-700 dark:bg-red-500 dark:hover:bg-red-600">
                                Reject Contract
                            </button>
                        </form>
                        <form method="POST" action="{{ route('contract.update', $user->application->id) }}">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="status" value="approved">

                            <button type="submit"
                                class="inline-flex items-center justify-center rounded bg-green-600 px-6 py-2.5 text-sm font-semibold text-white hover:bg-green-700 dark:bg-green-500 dark:hover:bg-green-600">
                                Accept Contract
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
