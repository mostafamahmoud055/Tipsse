@extends('layouts.app')

@section('content')
    <x-common.page-breadcrumb pageTitle="Settings" />
    
    <div class="space-y-6">
        <x-common.component-card title="Merchant Contract">
            <div class="space-y-6">
                <!-- Contract Header -->
                <div class="border-b border-gray-200 pb-6 dark:border-gray-700">
                    <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Merchant Service Agreement</h1>
                    <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">Contract Date: {{ date('F d, Y') }}</p>
                </div>

                <!-- Contract Content -->
                <div class="space-y-4 text-gray-700 dark:text-gray-300">
                    <p class="text-lg font-semibold text-gray-900 dark:text-white">
                        Dear <span class="text-brand-600 dark:text-brand-400">{{ $merchant_name ?? '{merchant_name}' }}</span>,
                    </p>

                    <p class="leading-relaxed">
                        This contract is between our company and <strong>{{ $business_name ?? '{business_name}' }}</strong> 
                        located at <strong>{{ $merchant_email ?? '{merchant_email}' }}</strong>.
                    </p>

                    <div class="rounded-lg bg-gray-50 p-4 dark:bg-gray-800/50">
                        <p class="font-semibold text-gray-900 dark:text-white">Contact Information:</p>
                        <p class="mt-2">
                            <span class="font-medium">Phone:</span> {{ $merchant_phone ?? '{merchant_phone}' }}
                        </p>
                    </div>

                    <h2 class="mt-6 text-xl font-bold text-gray-900 dark:text-white">Contract Terms:</h2>
                    
                    <div class="space-y-4">
                        <div class="rounded-lg border border-gray-200 p-4 dark:border-gray-700">
                            <h3 class="font-semibold text-gray-900 dark:text-white">1. Service Agreement</h3>
                            <p class="mt-2 text-sm leading-relaxed">
                                The parties agree to enter into a merchant services relationship whereby the Service Provider 
                                agrees to provide payment processing services to the Merchant in accordance with the terms and 
                                conditions set forth in this agreement.
                            </p>
                        </div>

                        <div class="rounded-lg border border-gray-200 p-4 dark:border-gray-700">
                            <h3 class="font-semibold text-gray-900 dark:text-white">2. Payment Processing</h3>
                            <p class="mt-2 text-sm leading-relaxed">
                                The Service Provider shall process all transactions submitted by the Merchant in accordance with 
                                applicable payment network rules and regulations. The Merchant is responsible for ensuring 
                                compliance with all applicable laws and regulations.
                            </p>
                        </div>

                        <div class="rounded-lg border border-gray-200 p-4 dark:border-gray-700">
                            <h3 class="font-semibold text-gray-900 dark:text-white">3. Fees and Charges</h3>
                            <p class="mt-2 text-sm leading-relaxed">
                                The Merchant agrees to pay all applicable fees and charges as outlined in the fee schedule. 
                                Fees may include but are not limited to processing fees, monthly minimums, gateway fees, 
                                and chargeback fees.
                            </p>
                        </div>

                        <div class="rounded-lg border border-gray-200 p-4 dark:border-gray-700">
                            <h3 class="font-semibold text-gray-900 dark:text-white">4. Term and Termination</h3>
                            <p class="mt-2 text-sm leading-relaxed">
                                This agreement shall commence on the date of execution and shall continue for a period of one (1) year, 
                                unless earlier terminated. Either party may terminate this agreement upon thirty (30) days written notice 
                                to the other party.
                            </p>
                        </div>

                        <div class="rounded-lg border border-gray-200 p-4 dark:border-gray-700">
                            <h3 class="font-semibold text-gray-900 dark:text-white">5. Limitation of Liability</h3>
                            <p class="mt-2 text-sm leading-relaxed">
                                In no event shall either party be liable for any indirect, incidental, special, consequential, or 
                                punitive damages, regardless of the cause of action or the theory of liability.
                            </p>
                        </div>

                        <div class="rounded-lg border border-gray-200 p-4 dark:border-gray-700">
                            <h3 class="font-semibold text-gray-900 dark:text-white">6. Confidentiality</h3>
                            <p class="mt-2 text-sm leading-relaxed">
                                Both parties agree to maintain the confidentiality of all proprietary and sensitive information 
                                shared in the course of this business relationship.
                            </p>
                        </div>
                    </div>

                    <p class="mt-6 leading-relaxed">
                        By accepting this contract, the Merchant agrees to be bound by all the terms and conditions outlined above. 
                        If you have any questions regarding this agreement, please contact our support team.
                    </p>
                </div>

                <!-- Contract Actions -->
                <div class="border-t border-gray-200 pt-6 dark:border-gray-700">
                    <div class="flex flex-col gap-3 sm:flex-row sm:justify-end">
                        <button
                            class="inline-flex items-center justify-center rounded bg-gray-200 px-6 py-2.5 text-sm font-semibold text-gray-900 hover:bg-gray-300 dark:bg-gray-700 dark:text-white dark:hover:bg-gray-600">
                            Print Contract
                        </button>
                        <button
                            class="inline-flex items-center justify-center rounded bg-blue-600 px-6 py-2.5 text-sm font-semibold text-white hover:bg-blue-700 dark:bg-blue-500 dark:hover:bg-blue-600">
                            Download PDF
                        </button>
                        <button
                            class="inline-flex items-center justify-center rounded bg-green-600 px-6 py-2.5 text-sm font-semibold text-white hover:bg-green-700 dark:bg-green-500 dark:hover:bg-green-600">
                            Accept Contract
                        </button>
                    </div>
                </div>
            </div>
        </x-common.component-card>
    </div>
@endsection
