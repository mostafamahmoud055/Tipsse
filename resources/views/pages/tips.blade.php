@extends('layouts.app')

@section('content')
    <x-common.page-breadcrumb pageTitle="Tip" />
        <div class="grid sm:grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-10 mb-5">
        @include('layouts.statistics.card-statistics', [
            'title' => 'Total Tips',
            'value' => 202,
            'icon' => 'images/icons/g3196.png',
            'iconBg' => 'bg-icon-purple',
            'percentage' => "+23%",
            'period' => null,
        ])
        @include('layouts.statistics.card-statistics', [
            'title' => 'Released Tips',
            'value' => 2356,
            'icon' => 'images/icons/tabler_check.png',
            'iconBg' => 'bg-icon-green',
            'percentage' => "+23%",
            'period' => null,
        ])
        @include('layouts.statistics.card-statistics', [
            'title' => 'Pending Tips',
            'value' => 2356,
            'icon' => 'images/icons/quill_info.png',
            'iconBg' => 'bg-icon-yellow',
            'percentage' => "+23%",
            'period' => null,
        ])
        @include('layouts.statistics.card-statistics', [
            'title' => 'Rejected Tips',
            'value' => 5992,
            'icon' => 'images/icons/material-symbols_close-rounded.png',
            'iconBg' => 'bg-icon-red',
            'percentage' => "+23%",
            'period' => null,
        ])

    </div>
    <div class="space-y-6">
        <x-common.component-card title="Tips List">
            <div x-data="{
                searchQuery: '',
                itemsPerPage: 10,
                currentPage: 1,
                tips: [
                    { id: 1, employee: 'Tianna Wilderman', merchant: 'Elmira Fadel', branch: 'Kenton Hickle', ratings: '★★★☆☆', tipsAmount: 150, status: 'Pending', date: '2024-11-Sun' },
                    { id: 2, employee: 'Glen Boehm MD', merchant: 'Kavon Boyer', branch: 'Hilma Dickinson', ratings: '★★☆☆☆', tipsAmount: 5, status: 'Pending', date: '2024-11-Sat' },
                    { id: 3, employee: 'Tianna Wilderman', merchant: 'Elmira Fadel', branch: 'Kenton Hickle', ratings: '★★★☆☆', tipsAmount: 15, status: 'Pending', date: '2024-11-Sat' },
                    { id: 4, employee: 'Tianna Wilderman', merchant: 'Elmira Fadel', branch: 'Kenton Hickle', ratings: '★★★☆☆', tipsAmount: 30, status: 'Pending', date: '2024-10-Thu' },
                    { id: 5, employee: 'Alana Deckow', merchant: 'Candida Thompson', branch: 'Lurline Littel', ratings: '★★★★★', tipsAmount: 697, status: 'Pending', date: '2024-10-Wed' },
                    { id: 6, employee: 'Alberta Marvin', merchant: 'Etha Senger', branch: 'Christy Beer', ratings: '★☆☆☆☆', tipsAmount: 81, status: 'Pending', date: '2024-10-Wed' },
                    { id: 7, employee: 'Alberta Marvin', merchant: 'Etha Senger', branch: 'Christy Beer', ratings: '★☆☆☆☆', tipsAmount: 899, status: 'Pending', date: '2024-10-Wed' },
                    { id: 8, employee: 'Aletha Douglas', merchant: 'Lexi Kris', branch: 'Haylie Kilback', ratings: '★☆☆☆☆', tipsAmount: 513, status: 'Released', date: '2024-10-Wed' },
                    { id: 9, employee: 'Brendon Cartwright DDS', merchant: 'Alfonso Roob I', branch: 'Angela Wunsch', ratings: '★★☆☆☆', tipsAmount: 138, status: 'Pending', date: '2024-10-Wed' },
                    { id: 10, employee: 'Carrie Mertz', merchant: 'Dr. Grayson Lowe III', branch: 'Adah Kulas PhD', ratings: '★★★★☆', tipsAmount: 656, status: 'Pending', date: '2024-10-Wed' },
                ],
                get filteredTips() {
                    if (!this.searchQuery.trim()) return this.tips;
                    return this.tips.filter(tip =>
                        tip.employee.toLowerCase().includes(this.searchQuery.toLowerCase()) ||
                        tip.merchant.toLowerCase().includes(this.searchQuery.toLowerCase()) ||
                        tip.branch.toLowerCase().includes(this.searchQuery.toLowerCase()) ||
                        tip.status.toLowerCase().includes(this.searchQuery.toLowerCase())
                    );
                },
                get paginatedTips() {
                    const start = (this.currentPage - 1) * this.itemsPerPage;
                    return this.filteredTips.slice(start, start + this.itemsPerPage);
                },
                get totalPages() {
                    return Math.ceil(this.filteredTips.length / this.itemsPerPage);
                },
                get startIndex() {
                    return (this.currentPage - 1) * this.itemsPerPage + 1;
                },
                get endIndex() {
                    return Math.min(this.currentPage * this.itemsPerPage, this.filteredTips.length);
                },
                goToPage(page) {
                    if (page >= 1 && page <= this.totalPages) {
                        this.currentPage = page;
                    }
                },
                getStatusClass(status) {
                    const classes = {
                        'Pending': 'bg-yellow-50 text-yellow-700 dark:bg-yellow-500/15 dark:text-yellow-500',
                        'Released': 'bg-green-50 text-green-700 dark:bg-green-500/15 dark:text-green-500',
                    };
                    return classes[status] || 'bg-gray-50 text-gray-700 dark:bg-gray-500/15 dark:text-gray-500';
                }
            }">

                <!-- Table -->
                <div class="overflow-x-auto rounded-xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
                    <table class="w-full">
                        <thead class="border-b border-gray-200 bg-gray-50 dark:border-gray-700 dark:bg-white/5">
                            <tr>
                                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900 dark:text-white">Employee</th>
                                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900 dark:text-white">Merchant</th>
                                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900 dark:text-white">Branch</th>
                                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900 dark:text-white">Ratings</th>
                                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900 dark:text-white">Tips</th>
                                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900 dark:text-white">Status</th>
                                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900 dark:text-white">Date</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                            <template x-for="tip in paginatedTips" :key="tip.id">
                                <tr class="hover:bg-gray-50 dark:hover:bg-white/5">
                                    <td class="px-6 py-4 text-sm font-medium text-gray-900 dark:text-white" x-text="tip.employee"></td>
                                    <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-400" x-text="tip.merchant"></td>
                                    <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-400" x-text="tip.branch"></td>
                                    <td class="px-6 py-4 text-sm text-yellow-600 dark:text-yellow-400" x-text="tip.ratings"></td>
                                    <td class="px-6 py-4 text-sm font-semibold text-gray-900 dark:text-white" x-text="tip.tipsAmount"></td>
                                    <td class="px-6 py-4 text-sm">
                                        <span :class="getStatusClass(tip.status)"
                                            class="inline-flex rounded-full px-3 py-1 text-xs font-semibold"
                                            x-text="tip.status"></span>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-400" x-text="tip.date"></td>
                                </tr>
                            </template>
                        </tbody>
                    </table>
                </div>

                <!-- Pagination Info and Controls -->
                <div class="mt-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                    <p class="text-sm text-gray-600 dark:text-gray-400">
                        Showing <span x-text="startIndex"></span> to <span x-text="endIndex"></span> of 
                        <span x-text="filteredTips.length"></span> entries
                    </p>
                    
                    <div class="flex flex-wrap gap-1">
                        <!-- First Button -->
                        <button @click="goToPage(1)" :disabled="currentPage === 1"
                            :class="{ 'opacity-50 cursor-not-allowed': currentPage === 1 }"
                            class="rounded border border-gray-300 px-3 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 disabled:hover:bg-white dark:border-gray-600 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700">
                            First
                        </button>

                        <!-- Previous Button -->
                        <button @click="goToPage(currentPage - 1)" :disabled="currentPage === 1"
                            :class="{ 'opacity-50 cursor-not-allowed': currentPage === 1 }"
                            class="rounded border border-gray-300 px-3 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 disabled:hover:bg-white dark:border-gray-600 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700">
                            Previous
                        </button>

                        <!-- Page Numbers -->
                        <template x-for="page in (() => {
                            const pages = [];
                            const maxVisible = 5;
                            const halfVisible = Math.floor(maxVisible / 2);
                            
                            let start = Math.max(1, currentPage - halfVisible);
                            let end = Math.min(totalPages, start + maxVisible - 1);
                            
                            if (end - start < maxVisible - 1) {
                                start = Math.max(1, end - maxVisible + 1);
                            }
                            
                            if (start > 1) {
                                pages.push(1);
                                if (start > 2) pages.push('...');
                            }
                            
                            for (let i = start; i <= end; i++) {
                                pages.push(i);
                            }
                            
                            if (end < totalPages) {
                                if (end < totalPages - 1) pages.push('...');
                                pages.push(totalPages);
                            }
                            
                            return pages;
                        })()" :key="page">
                            <template x-if="page === '...'">
                                <span class="px-2 py-2 text-sm text-gray-600 dark:text-gray-400">...</span>
                            </template>
                            <template x-if="page !== '...'">
                                <button @click="goToPage(page)"
                                    :class="{ 'bg-blue-600 text-white dark:bg-blue-500': currentPage === page, 'border-gray-300 text-gray-700 hover:bg-gray-50 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700': currentPage !== page }"
                                    class="rounded border px-3 py-2 text-sm font-medium"
                                    x-text="page">
                                </button>
                            </template>
                        </template>

                        <!-- Next Button -->
                        <button @click="goToPage(currentPage + 1)" :disabled="currentPage === totalPages"
                            :class="{ 'opacity-50 cursor-not-allowed': currentPage === totalPages }"
                            class="rounded border border-gray-300 px-3 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 disabled:hover:bg-white dark:border-gray-600 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700">
                            Next
                        </button>

                        <!-- Last Button -->
                        <button @click="goToPage(totalPages)" :disabled="currentPage === totalPages"
                            :class="{ 'opacity-50 cursor-not-allowed': currentPage === totalPages }"
                            class="rounded border border-gray-300 px-3 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 disabled:hover:bg-white dark:border-gray-600 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700">
                            Last
                        </button>
                    </div>
                </div>
            </div>
        </x-common.component-card>
    </div>
@endsection
