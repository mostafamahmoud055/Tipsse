<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Payment Successful - TIPSSE</title>

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

                {{-- Success Icon --}}
                <div class="flex flex-col items-center mb-8">
                    <div
                        class="mb-6 flex items-center justify-center w-24 h-24 rounded-full bg-gradient-to-br from-green-100 to-green-50 dark:from-green-900/30 dark:to-green-800/20">
                        <svg class="w-12 h-12 text-green-600 dark:text-green-400" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M5 13l4 4L19 7"></path>
                        </svg>
                    </div>

                    <h1 class="text-3xl sm:text-4xl font-bold text-gray-900 dark:text-white mb-2">
                        Payment Successful!
                    </h1>

                    <p class="text-center text-gray-600 dark:text-gray-400 text-sm sm:text-base mb-6">
                        Your payment has been processed successfully. Thank you for your contribution.
                    </p>
                </div>

                {{-- Transaction Details --}}
                <div class="space-y-4 mb-8 p-4 rounded-lg bg-gray-50 dark:bg-white/[0.02] border border-gray-200 dark:border-gray-700">
                    <div class="flex justify-between items-center">
                        <span class="text-sm font-medium text-gray-600 dark:text-gray-400">Transaction ID</span>
                        <span class="text-sm font-mono text-gray-900 dark:text-white break-all">
                            {{ $paymentIntentId ?? 'N/A' }}
                        </span>
                    </div>

                    <div class="flex justify-between items-center">
                        <span class="text-sm font-medium text-gray-600 dark:text-gray-400">Status</span>
                        <span
                            class="px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400">
                            Completed
                        </span>
                    </div>

                    <div class="flex justify-between items-center">
                        <span class="text-sm font-medium text-gray-600 dark:text-gray-400">Date & Time</span>
                        <span class="text-sm text-gray-900 dark:text-white">
                            {{ now()->format('M d, Y H:i A') }}
                        </span>
                    </div>
                </div>

                {{-- Confirmation Message --}}
                <div class="p-4 rounded-lg bg-blue-50 dark:bg-blue-900/10 border border-blue-200 dark:border-blue-800 mb-8">
                    <p class="text-sm text-blue-800 dark:text-blue-300">
                        A confirmation email has been sent to your registered email address. You can use your Transaction
                        ID to track your payment.
                    </p>
                </div>

                {{-- Action Buttons --}}
                <div class="space-y-3">
                    <a href="{{ route('dashboard') }}"
                        class="w-full inline-flex items-center justify-center px-6 py-3 rounded-lg font-semibold text-white transition-all duration-200
                        bg-gradient-to-r from-green-600 to-green-700 hover:from-green-700 hover:to-green-800 shadow-lg hover:shadow-xl
                        dark:from-green-700 dark:to-green-800">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-3m0 0l7-4 7 4M5 9v10a1 1 0 001 1h12a1 1 0 001-1V9m-9 11l4-4m0 0l4-4"></path>
                        </svg>
                        Back to Dashboard
                    </a>

                    <button onclick="window.print()"
                        class="w-full inline-flex items-center justify-center px-6 py-3 rounded-lg font-semibold transition-all duration-200
                        text-gray-700 bg-gray-100 hover:bg-gray-200
                        dark:text-gray-300 dark:bg-gray-800 dark:hover:bg-gray-700">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4H7a2 2 0 00-2 2v2a2 2 0 002 2h10a2 2 0 002-2v-2a2 2 0 00-2-2h-2.5"></path>
                        </svg>
                        Print Receipt
                    </button>
                </div>

                {{-- Auto Redirect Message --}}
                <p class="text-center text-xs text-gray-500 dark:text-gray-500 mt-6">
                    Redirecting to dashboard in <span id="countdown">5</span> seconds...
                </p>
            </div>
        </div>
    </div>

    <script>
        // Auto redirect after 5 seconds
        let countdown = 10;
        const countdownElement = document.getElementById('countdown');

        const interval = setInterval(() => {
            countdown--;
            countdownElement.textContent = countdown;

            if (countdown <= 0) {
                clearInterval(interval);
                window.location.href = "{{ route('dashboard') }}";
            }
        }, 1000);
    </script>
</body>

</html>
