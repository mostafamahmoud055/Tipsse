<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Payment Cancelled - TIPSSE</title>

    <link rel="icon" href="{{ asset('images/logo/auth-logo.png') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body
    class="h-full bg-gradient-to-br from-gray-50 via-white to-gray-100 dark:from-gray-950 dark:via-gray-900 dark:to-gray-800">

    <div class="flex justify-center items-center min-h-screen py-6 sm:py-10 px-3 sm:px-4">
        <div class="w-full max-w-lg">

            <div
                class="rounded-2xl border border-gray-200 bg-white p-8 sm:p-10 shadow-xl
                    dark:border-gray-800 dark:bg-white/[0.03] transition-all duration-300">

                {{-- Error Icon --}}
                <div class="flex flex-col items-center mb-8">
                    <div
                        class="mb-6 flex items-center justify-center w-24 h-24 rounded-full bg-gradient-to-br from-red-100 to-red-50 dark:from-red-900/30 dark:to-red-800/20">
                        <svg class="w-12 h-12 text-red-600 dark:text-red-400" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                            </path>
                        </svg>
                    </div>

                    <h1 class="text-3xl sm:text-4xl font-bold text-gray-900 dark:text-white mb-2">
                        Payment Cancelled
                    </h1>

                    <p class="text-center text-gray-600 dark:text-gray-400 text-sm sm:text-base mb-6">
                        Your payment was not completed. No charges have been made to your account.
                    </p>
                </div>

                {{-- Issue Message --}}
                <div class="p-4 rounded-lg bg-yellow-50 dark:bg-yellow-900/10 border border-yellow-200 dark:border-yellow-800 mb-8">
                    <div class="flex items-start gap-3">
                        <svg class="w-5 h-5 text-yellow-600 dark:text-yellow-400 mt-0.5 flex-shrink-0" fill="currentColor"
                            viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z"
                                clip-rule="evenodd" />
                        </svg>
                        <div>
                            <h3 class="font-semibold text-yellow-900 dark:text-yellow-300 mb-1">What happened?</h3>
                            <p class="text-sm text-yellow-800 dark:text-yellow-200">
                                You cancelled the payment process. You can retry at any time without any penalties.
                            </p>
                        </div>
                    </div>
                </div>

                {{-- Action Buttons --}}
                <div class="space-y-3">
                    <a href="{{ request()->header('Referer', route('dashboard')) }}"
                        class="w-full inline-flex items-center justify-center px-6 py-3 rounded-lg font-semibold text-white transition-all duration-200
                        bg-gradient-to-r from-green-600 to-green-700 hover:from-green-700 hover:to-green-800 shadow-lg hover:shadow-xl
                        dark:from-green-700 dark:to-green-800">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 19l-7-7 7-7"></path>
                        </svg>
                        Try Again
                    </a>

                    <a href="{{ route('dashboard') }}"
                        class="w-full inline-flex items-center justify-center px-6 py-3 rounded-lg font-semibold transition-all duration-200
                        text-gray-700 bg-gray-100 hover:bg-gray-200
                        dark:text-gray-300 dark:bg-gray-800 dark:hover:bg-gray-700">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 12l2-3m0 0l7-4 7 4M5 9v10a1 1 0 001 1h12a1 1 0 001-1V9m-9 11l4-4m0 0l4-4"></path>
                        </svg>
                        Back to Dashboard
                    </a>
                </div>

                {{-- Help Section --}}
                <div class="mt-8 pt-8 border-t border-gray-200 dark:border-gray-700">
                    <h3 class="font-semibold text-gray-900 dark:text-white mb-3">Need Help?</h3>
                    <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">
                        If you're experiencing issues with your payment, please contact our support team.
                    </p>
                    <a href="mailto:support@tipsse.com"
                        class="inline-flex items-center text-green-600 dark:text-green-400 hover:underline text-sm font-medium">
                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"></path>
                            <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"></path>
                        </svg>
                        Contact Support
                    </a>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
