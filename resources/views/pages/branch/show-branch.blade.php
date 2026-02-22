@extends('layouts.app')

@section('content')
    <x-common.page-breadcrumb pageTitle="Branch Details" />

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
        {{-- Left Column: Branch Profile & Employee List --}}
        <div class="lg:col-span-8 space-y-6">
            {{-- Branch Profile Card --}}
            <div class="rounded-2xl border border-gray-200 bg-white p-6 dark:border-gray-800 dark:bg-white/[0.03]">
                <div class="relative flex flex-col items-center">
                    <button class="absolute right-0 top-0 flex items-center gap-1 text-sm text-gray-400 hover:text-gray-600">
                        {!! menu_icon('edit-icon') !!} <span>Edit</span>
                    </button>

                    <div class="mb-4 h-24 w-24 overflow-hidden rounded-full ring-4 ring-gray-50 dark:ring-gray-800">
                        @if ($branch->image)
                            <img src="{{ route('image.show', ['path' => $branch->image]) }}"
                                class="h-full w-full object-cover" alt="Merchant Logo">
                        @endif
                        </td>
                    </div>

                    <div class="mb-6 flex w-full items-center justify-between">
                        <div class="flex items-center gap-2">
                            <span class="text-sm font-bold text-green-600">B 1</span>
                            <h3 class="text-lg font-bold text-gray-900 dark:text-white">Branch {{ $branch->name }}</h3>
                        </div>
                        <span
                            class="rounded-lg bg-green-50 px-4 py-1 text-xs font-bold text-green-600 dark:bg-green-500/10">Active</span>
                    </div>

                    <div class="w-full space-y-4">
                        <div class="flex items-center gap-4">
                            <div
                                class="flex h-10 w-10 items-center justify-center rounded-full bg-green-50 text-green-600 dark:bg-green-500/10">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z" />
                                    <polyline points="9 22 9 12 15 12 15 22" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500 dark:text-gray-400">Merchant :</p>
                                <p class="text-sm font-semibold text-gray-900 dark:text-white">{{ $branch->user->name }}</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-4">
                            <div
                                class="flex h-10 w-10 items-center justify-center rounded-full bg-green-50 text-green-600 dark:bg-green-500/10">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z" />
                                    <polyline points="22,6 12,13 2,6" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500 dark:text-gray-400">Merchant E-mail :</p>
                                <p class="text-sm font-semibold text-gray-900 dark:text-white">{{ $branch->user->email }}</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-4">
                            <div
                                class="flex h-10 w-10 items-center justify-center rounded-full bg-green-50 text-green-600 dark:bg-green-500/10">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path
                                        d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500 dark:text-gray-400">Phone :</p>
                                <p class="text-sm font-semibold text-gray-900 dark:text-white">{{ $branch->user->phone }}</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-4">
                            <div
                                class="flex h-10 w-10 items-center justify-center rounded-full bg-yellow-50 text-yellow-500 dark:bg-yellow-500/10">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor" stroke="none">
                                    <path
                                        d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500 dark:text-gray-400">Employee Ratings :</p>
                                <p class="text-sm font-semibold text-gray-900 dark:text-white">5.0 Rating</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Employee List --}}
            <div class="rounded-2xl border border-gray-200 bg-white p-6 dark:border-gray-800 dark:bg-white/[0.03]">
                <div class="mb-6 flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white">All Employees</h3>
                    </div>
                </div>

                <div class="space-y-4">
                    @forelse ($branch->employees as $employee)
                        <div
                            class="flex items-center justify-between rounded-xl border border-gray-100 p-4 dark:border-gray-800">
                            <div class="flex items-center gap-4">
                                <img src="images/avatar-placeholder.png" class="h-12 w-12 rounded-lg object-cover"
                                    alt="User">
                                <div>
                                    <h4 class="text-sm font-bold text-gray-900 dark:text-white">{{ $employee->name }}</h4>
                                    <p class="text-xs text-gray-500">{{ $employee->branch->name }} #1 <span
                                            class="mx-1">•</span>
                                        {{ $employee->phone }} <span class="mx-1">•</span> {{ $employee->email }}</p>
                                </div>
                            </div>
                            <a href="{{ route('employees.show', ['employee' => $employee->id]) }}"
                                class="inline-flex items-center justify-center rounded bg-blue-50 px-2.5 py-1.5 text-blue-700 hover:bg-blue-100 dark:bg-blue-500/15 dark:text-blue-400 dark:hover:bg-blue-500/25">
                                {!! menu_icon('view-icon') !!}
                            </a>
                        </div>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center py-6 font-medium text-gray-600 dark:text-white/40">
                                No employee found
                            </td>
                        </tr>
                    @endforelse
                </div>
            </div>
        </div>

        {{-- Right Column: Statistics & Tips --}}
        <div class="lg:col-span-4 space-y-6">
            {{-- Statistics Card --}}
            <div class="rounded-2xl border border-gray-200 bg-white p-6 dark:border-gray-800 dark:bg-white/[0.03]">
                <h3 class="mb-4 text-lg font-bold text-gray-900 dark:text-white">Statistics</h3>
                <div class="flex items-center justify-center py-4">
                    {{-- Placeholder for Pie Chart --}}
                    <div class="relative h-48 w-48">
                        <svg viewBox="0 0 36 36" class="h-full w-full rotate-[-90deg]">
                            <circle cx="18" cy="18" r="16" fill="none" stroke="#E5E7EB"
                                stroke-width="4" class="dark:stroke-gray-800"></circle>
                            <circle cx="18" cy="18" r="16" fill="none" stroke="#6366F1"
                                stroke-width="4" stroke-dasharray="70, 100" class="opacity-80"></circle>
                            <circle cx="18" cy="18" r="16" fill="none" stroke="#10B981"
                                stroke-width="4" stroke-dasharray="30, 100" stroke-dashoffset="-70"></circle>
                        </svg>
                        <div
                            class="absolute inset-0 flex flex-col items-center justify-center text-xs font-bold text-gray-600 dark:text-gray-400">
                            <div class="flex items-center gap-1"><span class="h-2 w-2 rounded-full bg-indigo-500"></span>
                                Employees 70</div>
                            <div class="flex items-center gap-1"><span class="h-2 w-2 rounded-full bg-green-500"></span>
                                Total Tips 30</div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Tips Card --}}
            <div class="rounded-2xl border border-gray-200 bg-white p-6 dark:border-gray-800 dark:bg-white/[0.03]">
                <div class="mb-2 flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white">Recent Tips</h3>
                    </div>
                </div>
                <p class="mb-6 text-xs text-gray-500">Recent tips for employees at this branch</p>

                <div class="space-y-4">
                    @forelse($branch->payments as $payment)
                        <div class="rounded-xl border border-gray-100 p-4 dark:border-gray-800 hover:shadow-sm transition-shadow">
                            <div class="flex items-center justify-between mb-2">
                                <h4 class="text-sm font-bold text-gray-900 dark:text-white">{{ $payment->employee->name ?? 'Unknown' }}</h4>
                                <span
                                    class="rounded px-2 py-0.5 text-[10px] font-bold
                                    @if($payment->status === 'successful') bg-green-50 text-green-600
                                    @elseif($payment->status === 'pending') bg-yellow-50 text-yellow-600
                                    @else bg-red-50 text-red-600 @endif
                                    ">{{ ucfirst($payment->status) }}</span>
                                <span class="text-lg font-bold 
                                    @if($payment->status === 'successful') text-green-600
                                    @elseif($payment->status === 'pending') text-yellow-600
                                    @else text-red-600 @endif
                                    ">${{ number_format($payment->amount, 0) }}</span>
                            </div>
                            <div class="flex items-center justify-between">
                                <div class="flex text-yellow-400 gap-1">
                                    @if($payment->rating)
                                        @for($i = 1; $i <= 5; $i++)
                                            <svg class="w-3 h-3 {{ $i <= $payment->rating ? 'fill-current' : 'text-gray-300 dark:text-gray-600' }}" 
                                                viewBox="0 0 20 20">
                                                <path
                                                    d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                            </svg>
                                        @endfor
                                    @else
                                        <span class="text-xs text-gray-500">Not rated</span>
                                    @endif
                                </div>
                            </div>
                            <p class="mt-2 text-[10px] text-gray-400">{{ $payment->created_at->format('m/d/Y') }}</p>
                        </div>
                    @empty
                        <div class="text-center py-8">
                            <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="1.5" class="mx-auto text-gray-300 dark:text-gray-600 mb-3">
                                <line x1="12" y1="1" x2="12" y2="23"></line>
                                <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path>
                            </svg>
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">No tips received yet</p>
                        </div>
                    @endforelse
                </div>

                @if($branch->payments->count() > 0)
                    <div class="mt-4 flex justify-end">
                        <a href="{{ route('tips') }}" class="text-xs font-bold text-green-600 hover:text-green-700 transition-colors">
                            View All Tips →
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
