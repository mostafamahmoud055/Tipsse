@extends('layouts.app')

@section('content')
    <x-common.page-breadcrumb pageTitle="Branches" />
    @include('layouts.filter.filter-page')
    <div class="space-y-6">
        <x-common.component-card buttonName="Add Branch" title="Branches List">
            <div x-data="{
                searchQuery: '',
                itemsPerPage: 10,
                currentPage: 1,
                branches: [
                    { id: 1, name: 'Hilma Dickinson', merchant: 'Kavon Boyer', phone: '(727) 755-1640', employee: 3, status: '', date: '2024 Oct 23' },
                    { id: 2, name: 'Erling Dare', merchant: 'Dovie Stamm', phone: '+1-740-348-4436', employee: 3, status: '', date: '2024 Oct 23' },
                    { id: 3, name: 'Dayne Prosacco', merchant: 'Jimmy Nitzsche', phone: '+1 (657) 573-4931', employee: 1, status: '', date: '2024 Oct 23' },
                    { id: 4, name: 'Tia Kulas', merchant: 'Mr. Caleb Cruickshank', phone: '+16783364976', employee: 2, status: '', date: '2024 Oct 23' },
                    { id: 5, name: 'Margie Schaefer', merchant: 'Jailyn Legros', phone: '281-448-6546', employee: 4, status: '', date: '2024 Oct 23' },
                    { id: 6, name: 'Prof. Mireille Ebert DVM', merchant: 'Khalil Thompson', phone: '(513) 627-2653', employee: 5, status: '', date: '2024 Oct 23' },
                    { id: 7, name: 'Adah Kulas PhD', merchant: 'Dr. Grayson Lowe III', phone: '253-499-2205', employee: 3, status: '', date: '2024 Oct 23' },
                    { id: 8, name: 'Ms. Eldora Cremin MD', merchant: 'Mason Mann', phone: '+1 (414) 918-3335', employee: 3, status: '', date: '2024 Oct 23' },
                    { id: 9, name: 'Ruth Kassulke', merchant: 'Etha Ortiz', phone: '+1 (425) 862-6576', employee: 4, status: '', date: '2024 Oct 23' },
                    { id: 10, name: 'Dr. Beaulah Wunsch MD', merchant: 'Kallie Medhurst IV', phone: '+1-540-966-0889', employee: 1, status: '', date: '2024 Oct 23' },
                ],
                get filteredBranches() {
                    if (!this.searchQuery.trim()) return this.branches;
                    return this.branches.filter(branch =>
                        branch.name.toLowerCase().includes(this.searchQuery.toLowerCase()) ||
                        branch.merchant.toLowerCase().includes(this.searchQuery.toLowerCase()) ||
                        branch.phone.includes(this.searchQuery)
                    );
                },
                get paginatedBranches() {
                    const start = (this.currentPage - 1) * this.itemsPerPage;
                    return this.filteredBranches.slice(start, start + this.itemsPerPage);
                },
                get totalPages() {
                    return Math.ceil(this.filteredBranches.length / this.itemsPerPage);
                },
                get startIndex() {
                    return (this.currentPage - 1) * this.itemsPerPage + 1;
                },
                get endIndex() {
                    return Math.min(this.currentPage * this.itemsPerPage, this.filteredBranches.length);
                },
                goToPage(page) {
                    if (page >= 1 && page <= this.totalPages) {
                        this.currentPage = page;
                    }
                },
            }">

                <!-- Table -->
                <div
                    class="overflow-x-auto rounded-xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
                    <table class="w-full">
                        <thead class="border-b border-gray-200 bg-gray-50 dark:border-gray-700 dark:bg-white/5">
                            <tr>
                                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900 dark:text-white">Name
                                </th>
                                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900 dark:text-white">Merchant
                                </th>
                                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900 dark:text-white">Phone
                                </th>
                                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900 dark:text-white">Employee
                                </th>
                                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900 dark:text-white">Status
                                </th>
                                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900 dark:text-white">Date
                                </th>
                                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900 dark:text-white">Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                            <template x-for="branch in paginatedBranches" :key="branch.id">
                                <tr class="hover:bg-gray-50 dark:hover:bg-white/5">
                                    <td class="px-6 py-4 text-sm font-medium text-gray-900 dark:text-white"
                                        x-text="branch.name"></td>
                                    <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-400" x-text="branch.merchant">
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-400" x-text="branch.phone">
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-400" x-text="branch.employee">
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-400">
                                        <span x-text="branch.status || '-'"></span>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-400" x-text="branch.date">
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex gap-2">
                                            <button
                                                class="inline-flex rounded bg-blue-50 px-3 py-1.5 text-xs font-semibold text-blue-700 hover:bg-blue-100 dark:bg-blue-500/15 dark:text-blue-500 dark:hover:bg-blue-500/20">
                                                View
                                            </button>
                                            <button
                                                class="inline-flex rounded bg-yellow-50 px-3 py-1.5 text-xs font-semibold text-yellow-700 hover:bg-yellow-100 dark:bg-yellow-500/15 dark:text-yellow-500 dark:hover:bg-yellow-500/20">
                                                Edit
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            </template>
                        </tbody>
                    </table>
                </div>

                <!-- Pagination Info and Controls -->
                @include('layouts.paginate')
            </div>
        </x-common.component-card>
    </div>
@endsection
