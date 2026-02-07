@extends('layouts.app')

@section('content')
    <x-common.page-breadcrumb pageTitle="Employee" />
    @include('layouts.filter.filter-page')
    <div class="space-y-6">
        <x-common.component-card title="Employee List" buttonName="Add Employee">

            <div x-data="{
                searchQuery: '',
                itemsPerPage: 10,
                currentPage: 1,
                employees: [
                    { id: 1, name: 'Tianna Wilderman', email: 'bernadine.blick@example.org', mobile: '+1-680-352-3801', nationalId: '6', merchant: 'Elmira Fadel', branch: 'Kenton Hickle', status: '', date: '2024 Oct 23' },
                    { id: 2, name: 'Leora Jast', email: 'kub.polly@example.org', mobile: '530-437-8029', nationalId: '341900999', merchant: 'Dillan Wiegand', branch: 'Dr. Emil Gorczany', status: '', date: '2024 Oct 23' },
                    { id: 3, name: 'Alberta Marvin', email: 'hansen.rosie@example.org', mobile: '985-275-9996', nationalId: '9988', merchant: 'Etha Senger', branch: 'Christy Beer', status: '', date: '2024 Oct 23' },
                    { id: 4, name: 'Ms. Danielle Larson DVM', email: 'reinhold.murray@example.com', mobile: '325-287-1770', nationalId: '8076279', merchant: 'Jailyn Legros', branch: 'Margie Schaefer', status: '', date: '2024 Oct 23' },
                    { id: 5, name: 'Prof. Lucio Kshlerin MD', email: 'jacklyn03@example.org', mobile: '+1-475-795-9901', nationalId: '1809', merchant: 'Julius Friesen', branch: 'Alta Rosenbaum', status: '', date: '2024 Oct 23' },
                    { id: 6, name: 'Terry Kunze', email: 'white.mathilde@example.com', mobile: '208.348.6380', nationalId: '94814054', merchant: 'Enid Gibson', branch: 'Mathilde Muller', status: '', date: '2024 Oct 23' },
                    { id: 7, name: 'Tevin Macejkovic', email: 'dangelo.schumm@example.net', mobile: '(480) 208-2802', nationalId: '330', merchant: 'Enid Gibson', branch: 'Mathilde Muller', status: '', date: '2024 Oct 23' },
                    { id: 8, name: 'Brandyn Dibbert', email: 'schaden.derick@example.net', mobile: '(636) 240-8155', nationalId: '2', merchant: 'Kavon Labadie I', branch: 'Heber Hintz', status: '', date: '2024 Oct 23' },
                    { id: 9, name: 'Dorian Kris I', email: 'annamae00@example.org', mobile: '+1 (650) 716-0845', nationalId: '84', merchant: 'Prof. Freddy Wehner DDS', branch: 'Prof. Vivien Mitchell Jr.', status: '', date: '2024 Oct 23' },
                    { id: 10, name: 'Janet Steuber', email: 'nledner@example.com', mobile: '+1-830-528-0902', nationalId: '17068', merchant: 'Ms. Kira Shanahan I', branch: 'Nikita Nitzsche V', status: '', date: '2024 Oct 23' },
                ],
                get filteredEmployees() {
                    if (!this.searchQuery.trim()) return this.employees;
                    return this.employees.filter(employee =>
                        employee.name.toLowerCase().includes(this.searchQuery.toLowerCase()) ||
                        employee.email.toLowerCase().includes(this.searchQuery.toLowerCase()) ||
                        employee.mobile.includes(this.searchQuery) ||
                        employee.nationalId.includes(this.searchQuery) ||
                        employee.merchant.toLowerCase().includes(this.searchQuery.toLowerCase()) ||
                        employee.branch.toLowerCase().includes(this.searchQuery.toLowerCase())
                    );
                },
                get paginatedEmployees() {
                    const start = (this.currentPage - 1) * this.itemsPerPage;
                    return this.filteredEmployees.slice(start, start + this.itemsPerPage);
                },
                get totalPages() {
                    return Math.ceil(this.filteredEmployees.length / this.itemsPerPage);
                },
                get startIndex() {
                    return (this.currentPage - 1) * this.itemsPerPage + 1;
                },
                get endIndex() {
                    return Math.min(this.currentPage * this.itemsPerPage, this.filteredEmployees.length);
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
                                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900 dark:text-white">Name</th>
                                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900 dark:text-white">Email
                                </th>
                                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900 dark:text-white">Mobile
                                </th>
                                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900 dark:text-white">National
                                    ID</th>
                                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900 dark:text-white">Merchant
                                </th>
                                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900 dark:text-white">Branch
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
                            <template x-for="employee in paginatedEmployees" :key="employee.id">
                                <tr class="hover:bg-gray-50 dark:hover:bg-white/5">
                                    <td class="px-6 py-4 text-sm font-medium text-gray-900 dark:text-white"
                                        x-text="employee.name"></td>
                                    <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-400" x-text="employee.email">
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-400" x-text="employee.mobile">
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-400"
                                        x-text="employee.nationalId"></td>
                                    <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-400"
                                        x-text="employee.merchant"></td>
                                    <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-400" x-text="employee.branch">
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-400">
                                        <span x-text="employee.status || '-'"></span>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-400" x-text="employee.date">
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
