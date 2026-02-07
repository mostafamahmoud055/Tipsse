@extends('layouts.app')

@section('content')
    <x-common.page-breadcrumb pageTitle="Merchant Contracts" />
    @include('layouts.filter.filter-page')

    <div class="space-y-6">
        <x-common.component-card title="Merchant Contracts List">
            <div x-data="{
                searchQuery: '',
                itemsPerPage: 10,
                currentPage: 1,
                contracts: [
                    { id: 'M-20244597', name: 'Ibraheem Ahmed Alwoor', businessName: 'Test', email: 'ibraheem.alaoor@hotmail.com', phone: '0598298969', status: '', hasUpdatedPassword: false },
                    { id: 'M-20244585', name: 'Oulbaks', businessName: 'Fz Parfums', email: 'Fz@gmail.com', phone: '05578787822', status: '', hasUpdatedPassword: false },
                    { id: 'M-20245143', name: 'Noor Ali Hassan Orom', businessName: 'مطعم', email: 'noororam2002@gmail.com', phone: '0595569331', status: '', hasUpdatedPassword: false },
                    { id: 'M-20244027', name: 'Linda Martin', businessName: 'Lucas Delaney', email: 'repubi@mailinator.com', phone: '+1 (912) 736-8413', status: '', hasUpdatedPassword: false },
                    { id: 'M-20241184', name: 'Paula Ochoa', businessName: 'Anthony Barker', email: 'newe@mailinator.com', phone: '+1 (668) 819-7991', status: '', hasUpdatedPassword: false },
                    { id: 'M-20243216', name: 'Garth Riley', businessName: 'Laith Leonard', email: 'soronab@mailinator.com', phone: '+1 (157) 598-9673', status: '', hasUpdatedPassword: false },
                    { id: 'M-20246121', name: 'Nero Durham', businessName: 'Amelia Bowen', email: 'syvoqojete@mailinator.com', phone: '+1 (139) 195-1771', status: '', hasUpdatedPassword: false },
                ],
                get filteredContracts() {
                    if (!this.searchQuery.trim()) return this.contracts;
                    return this.contracts.filter(contract =>
                        contract.id.toLowerCase().includes(this.searchQuery.toLowerCase()) ||
                        contract.name.toLowerCase().includes(this.searchQuery.toLowerCase()) ||
                        contract.businessName.toLowerCase().includes(this.searchQuery.toLowerCase()) ||
                        contract.email.toLowerCase().includes(this.searchQuery.toLowerCase()) ||
                        contract.phone.includes(this.searchQuery)
                    );
                },
                get paginatedContracts() {
                    const start = (this.currentPage - 1) * this.itemsPerPage;
                    return this.filteredContracts.slice(start, start + this.itemsPerPage);
                },
                get totalPages() {
                    return Math.ceil(this.filteredContracts.length / this.itemsPerPage);
                },
                goToPage(page) {
                    if (page >= 1 && page <= this.totalPages) this.currentPage = page;
                }
            }">


                <!-- Table -->
                <div
                    class="overflow-x-auto rounded-xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
                    <table class="w-full">
                        <thead class="border-b border-gray-200 bg-gray-50 dark:border-gray-700 dark:bg-white/5">
                            <tr>
                                @foreach (['ID', 'Name', 'Business Name', 'Email', 'Phone', 'Status', 'Updated Password'] as $header)
                                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900 dark:text-white">
                                        {{ $header }}</th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                            <template x-for="contract in paginatedContracts" :key="contract.id">
                                <tr class="hover:bg-gray-50 dark:hover:bg-white/5">
                                    <td class="px-6 py-4 text-sm font-medium text-gray-900 dark:text-white"
                                        x-text="contract.id"></td>
                                    <td class="px-6 py-4 text-sm font-medium text-gray-900 dark:text-white"
                                        x-text="contract.name"></td>
                                    <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-400"
                                        x-text="contract.businessName"></td>
                                    <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-400" x-text="contract.email">
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-400" x-text="contract.phone">
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-400"
                                        x-text="contract.status || '-'"></td>
                                    <td class="px-6 py-4 text-sm">
                                        <span
                                            :class="contract.hasUpdatedPassword ? 'text-green-600 dark:text-green-500' :
                                                'text-red-600 dark:text-red-500'"
                                            class="text-lg">
                                            <template x-if="!contract.hasUpdatedPassword">❌</template>
                                            <template x-if="contract.hasUpdatedPassword">✅</template>
                                        </span>
                                    </td>
                                </tr>
                            </template>
                        </tbody>
                    </table>
                </div>

                @include('layouts.paginate')
            </div>
        </x-common.component-card>
    </div>
@endsection
