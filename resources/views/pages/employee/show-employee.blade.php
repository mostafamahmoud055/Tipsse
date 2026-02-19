@extends('layouts.app')

@section('content')
    <x-common.page-breadcrumb pageTitle="Employee Details" />

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
        {{-- Left Column: Employee Profile & Performance History --}}
        <div class="lg:col-span-8 space-y-6">
            {{-- Employee Profile Card --}}
            <div class="rounded-2xl border border-gray-200 bg-white p-6 dark:border-gray-800 dark:bg-white/[0.03]">
                <div class="relative flex flex-col items-center">
                    <button
                        class="absolute right-0 top-0 flex items-center gap-1 text-sm font-medium text-gray-400 hover:text-gray-600 transition-colors">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7" />
                            <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z" />
                        </svg>
                        <span>Edit</span>
                    </button>

                    <div class="mb-4 h-28 w-28 overflow-hidden rounded-full ring-4 ring-gray-50 dark:ring-gray-800">
                        @if ($employee->image)
                            <img src="{{ route('image.show', ['path' => $employee->image]) }}"
                                class="h-full w-full object-cover" alt="Employee Photo">
                        @else
                            <img src="{{ asset('/images/user/default-avatar.avif') }}" class="h-full w-full object-cover"
                                alt="Default Avatar">
                        @endif
                    </div>

                    <div class="mb-6 flex w-full items-center justify-between">
                        <div class="flex items-center gap-2">
                            <span class="text-sm font-bold text-green-600">EID-{{ $employee->id }}</span>
                            <h3 class="text-xl font-bold text-gray-900 dark:text-white">{{ $employee->name }}</h3>
                        </div>
                        <span
                            class="rounded-lg bg-green-50 px-4 py-1 text-xs font-bold text-green-600 dark:bg-green-500/10">Active</span>
                    </div>

                    <div class="w-full space-y-5">
                        <div class="flex items-center gap-4">
                            <div
                                class="flex h-11 w-11 items-center justify-center rounded-full bg-green-50 text-green-600 dark:bg-green-500/10">
                                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z" />
                                    <polyline points="9 22 9 12 15 12 15 22" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-xs font-medium text-gray-500 dark:text-gray-400">Assigned Branch :</p>
                                <p class="text-sm font-bold text-gray-900 dark:text-white">{{ $employee->branch->name }}</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-4">
                            <div
                                class="flex h-11 w-11 items-center justify-center rounded-full bg-green-50 text-green-600 dark:bg-green-500/10">
                                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z" />
                                    <polyline points="22,6 12,13 2,6" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-xs font-medium text-gray-500 dark:text-gray-400">Email Address :</p>
                                <p class="text-sm font-bold text-gray-900 dark:text-white">{{ $employee->email }}</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-4">
                            <div
                                class="flex h-11 w-11 items-center justify-center rounded-full bg-green-50 text-green-600 dark:bg-green-500/10">
                                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path
                                        d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-xs font-medium text-gray-500 dark:text-gray-400">Phone Number :</p>
                                <p class="text-sm font-bold text-gray-900 dark:text-white">{{ $employee->phone ?? 'N/A' }}
                                </p>
                            </div>
                        </div>
                        <div class="flex items-center gap-4">
                            <div
                                class="flex h-11 w-11 items-center justify-center rounded-full bg-yellow-50 text-yellow-500 dark:bg-yellow-500/10">
                                <svg width="22" height="22" viewBox="0 0 24 24" fill="currentColor" stroke="none">
                                    <path
                                        d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-xs font-medium text-gray-500 dark:text-gray-400">Personal Rating :</p>
                                <p class="text-sm font-bold text-gray-900 dark:text-white">{{ $employee->rating ?? '5.0' }}
                                    Rating</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Tip History List --}}
            <div class="rounded-2xl border border-gray-200 bg-white p-6 dark:border-gray-800 dark:bg-white/[0.03]">
                <div class="mb-6 flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white">Recent Transactions</h3>
                        <span class="text-sm font-bold text-green-600">Total 452</span>
                    </div>
                    <div class="relative">
                        <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2">
                                <circle cx="11" cy="11" r="8" />
                                <line x1="21" y1="21" x2="16.65" y2="16.65" />
                            </svg>
                        </span>
                        <input type="text" placeholder="Search Tips"
                            class="placeholder:text-gray-400 rounded-lg border border-gray-200 bg-gray-50 py-2 pl-10 pr-4 text-sm focus:ring-2 focus:ring-green-500/20 focus:outline-none dark:border-gray-700 dark:bg-white/5">
                    </div>
                </div>

                <div class="space-y-4">
                    @foreach (range(1, 4) as $index)
                        <div
                            class="flex items-center justify-between rounded-2xl border border-gray-100 p-5 transition-shadow hover:shadow-sm dark:border-gray-800">
                            <div class="flex items-center gap-4">
                                <div
                                    class="flex h-12 w-12 items-center justify-center rounded-xl bg-green-50 text-green-600 dark:bg-green-500/10">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                        stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round">
                                        <line x1="12" y1="1" x2="12" y2="23"></line>
                                        <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h4 class="text-base font-bold text-gray-900 dark:text-white">Tip Received</h4>
                                    <div class="flex items-center gap-2 text-xs font-medium text-gray-500">
                                        <span>From Customer #{{ rand(100, 999) }}</span>
                                        <span class="h-1 w-1 rounded-full bg-gray-300"></span>
                                        <span>May 12, 2025</span>
                                    </div>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="text-base font-bold text-green-600">+ SAR 150.00</p>
                                <span class="text-[10px] font-bold uppercase text-gray-400">Completed</span>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="mt-8 flex items-center justify-between border-t border-gray-100 pt-6 dark:border-gray-800">
                    <p class="text-xs font-medium text-gray-500">Showing data 1 to 8 of 452 entries</p>
                    <div class="flex items-center gap-2">
                        <button
                            class="flex h-8 w-8 items-center justify-center rounded-lg border border-gray-200 text-gray-500 hover:bg-gray-50 dark:border-gray-700 dark:hover:bg-white/5">‹</button>
                        <button
                            class="flex h-8 w-8 items-center justify-center rounded-lg bg-green-600 text-xs font-bold text-white shadow-lg shadow-green-600/20">1</button>
                        <button
                            class="flex h-8 w-8 items-center justify-center rounded-lg border border-gray-200 text-xs font-bold text-gray-600 hover:bg-gray-50 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-white/5">2</button>
                        <button
                            class="flex h-8 w-8 items-center justify-center rounded-lg border border-gray-200 text-gray-500 hover:bg-gray-50 dark:border-gray-700 dark:hover:bg-white/5">›</button>
                    </div>
                </div>
            </div>
        </div>

        {{-- Right Column: Earnings & QR Code --}}
        <div class="lg:col-span-4 space-y-6">
            {{-- Earnings Statistics --}}
            <div class="rounded-2xl border border-gray-200 bg-white p-6 dark:border-gray-800 dark:bg-white/[0.03]">
                <h3 class="mb-6 text-xl font-bold text-gray-900 dark:text-white">Earnings Distribution</h3>
                <div class="flex flex-col items-center justify-center py-6">
                    <div class="relative h-56 w-56">
                        <svg viewBox="0 0 36 36" class="h-full w-full rotate-[-90deg]">
                            <circle cx="18" cy="18" r="16" fill="none" stroke="#E5E7EB"
                                stroke-width="4.5" class="dark:stroke-gray-800"></circle>
                            <circle cx="18" cy="18" r="16" fill="none" stroke="#6366F1"
                                stroke-width="4.5" stroke-dasharray="80, 100" class="opacity-90"></circle>
                            <circle cx="18" cy="18" r="16" fill="none" stroke="#F59E0B"
                                stroke-width="4.5" stroke-dasharray="20, 100" stroke-dashoffset="-80"></circle>
                        </svg>
                        <div class="absolute inset-0 flex flex-col items-center justify-center space-y-2">
                            <div class="flex items-center gap-2 text-xs font-bold text-gray-700 dark:text-gray-300">
                                <span class="h-2.5 w-2.5 rounded-full bg-indigo-500"></span>
                                <span>Tips 80%</span>
                            </div>
                            <div class="flex items-center gap-2 text-xs font-bold text-gray-700 dark:text-gray-300">
                                <span class="h-2.5 w-2.5 rounded-full bg-yellow-500"></span>
                                <span>Bonus 20%</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- QR Code / Tip Me Card --}}
            <div class="rounded-2xl border border-gray-200 bg-white p-6 dark:border-gray-800 dark:bg-white/[0.03]">
                <div class="mb-2 flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white">Employee QR</h3>
                                            <button class="text-green-600 hover:text-green-700">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg>
                    </button>
                    </div>
                </div>
                <p class="mb-6 text-xs font-medium text-gray-500 uppercase tracking-wider">Scan this code to tip
                    {{ $employee->name }}</p>

                <div class="flex flex-col items-center space-y-4">
                    <div class="rounded-2xl border-2 border-dashed border-gray-100 p-4 dark:border-gray-800">
                        {{-- Replace with actual QR Generator --}}
                        <div class="h-40 w-40 bg-gray-100 dark:bg-gray-800 rounded-lg flex items-center justify-center">
                            <div class=" p-3 rounded-lg w-64 h-64">
                                {!! $qrCodeSvg !!}
                            </div>
                        </div>
                    </div>

                    <div class="w-full space-y-3">
                        <div class="flex items-center justify-between p-3 rounded-xl bg-gray-50 dark:bg-white/5">
                            <span class="text-xs font-bold text-gray-500">Monthly Target</span>
                            <span class="text-xs font-bold text-gray-900 dark:text-white">85%</span>
                        </div>
                        <div class="h-2 w-full bg-gray-100 dark:bg-gray-800 rounded-full overflow-hidden">
                            <div class="h-full bg-green-500" style="width: 85%"></div>
                        </div>
                    </div>
                </div>

                <div class="mt-8 flex items-center justify-between border-t border-gray-100 pt-6 dark:border-gray-800">
                    <p class="text-[10px] font-bold text-gray-400 uppercase">Joined On</p>
                    <p class="text-[10px] font-bold text-gray-900 dark:text-white">Jan 12, 2024</p>
                </div>
            </div>
        </div>
    </div>
@endsection
