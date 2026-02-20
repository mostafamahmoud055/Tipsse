<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Pay Tip</title>

    <link rel="icon" href="{{ asset('images/logo/auth-logo.png') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body
    class="h-full bg-gradient-to-br from-gray-50 via-white to-gray-100 dark:from-gray-950 dark:via-gray-900 dark:to-gray-800">

    <div class="flex justify-center items-center min-h-screen py-6 sm:py-10 px-3 sm:px-4">
        <div class="w-full max-w-lg">

            <div
                class="rounded-2xl border border-gray-200 bg-white p-6 sm:p-8 shadow-lg
                    dark:border-gray-800 dark:bg-white/[0.03] transition-all duration-300">

                {{-- Logo --}}
                <div class="flex flex-col items-center mb-6 sm:mb-8">
                    <div class="mb-3 sm:mb-4 relative">
                        <div
                            class="absolute inset-0 bg-gradient-to-r from-green-400 to-blue-400 rounded-full blur opacity-20">
                        </div>
                        <img src="{{ asset('images/logo/auth-logo.png') }}"
                            class="relative h-12 sm:h-16 w-12 sm:w-16 object-contain" />
                    </div>
                    <h1
                        class="text-2xl sm:text-3xl font-bold bg-gradient-to-r from-green-600 to-blue-600 bg-clip-text text-transparent">
                        TIPSSE
                    </h1>

                    <p class="text-xs sm:text-sm text-gray-600 text-center dark:text-gray-400 mt-2 leading-relaxed">
                        <span class="font-semibold">Branch:</span> {{ $employee->branch->name ?? 'N/A' }}
                        <br>
                        <span class="font-semibold">Merchant:</span> {{ $employee->user->name ?? 'N/A' }}
                    </p>
                </div>

                <div class="flex justify-center my-5 h-40 w-full ">
                    @if ($employee->image)
                        <img src="{{ route('image.show', ['path' => $employee->image]) }}"
                            class="mb-4 overflow-hidden rounded-full ring-4 ring-gray-50 dark:ring-gray-800object-cover" alt="Employee Image">
                    @endif
                    </td>
                </div>

                {{-- Employee --}}
                <div
                    class="text-center mb-8 py-3 sm:py-4 rounded-lg bg-gradient-to-r from-gray-50 to-gray-100 dark:from-gray-900 dark:to-gray-800">
                    <h2 class="text-xl sm:text-2xl font-bold text-gray-900 dark:text-white px-2">
                        {{ $employee->name }}
                    </h2>
                </div>

                <form method="POST" action="" id="paymentForm">
                    @csrf

                    <input type="hidden" name="employee_id" value="{{ $employee->id }}">
                    <input type="hidden" name="amount" id="finalAmount">

                    {{-- Amount --}}
                    <div class="mb-6">
                        <p class="text-xs sm:text-sm font-semibold text-gray-900 dark:text-gray-100 mb-4">
                            Select Amount to Tip
                        </p>

                        <div class="grid grid-cols-2 md:grid-cols-4 gap-2 md:gap-3 mb-4 sm:mb-5">
                            @foreach ([5, 10, 15, 20] as $amount)
                                <button type="button" data-amount="{{ $amount }}"
                                    class="amount-btn h-fit w-full rounded-lg px-3 sm:px-4 py-3 sm:py-3 text-xs sm:text-sm font-semibold 
                            border-2 border-gray-200 bg-white text-gray-900
                            dark:border-gray-700 dark:bg-gray-800 dark:text-white
                            hover:border-green-500 dark:hover:border-green-400 hover:shadow-md
                            transition-all duration-200 cursor-pointer
                            active:scale-95">
                                    ${{ $amount }}
                                </button>
                            @endforeach

                            <button type="button" id="customBtn"
                                class="col-span-2 md:col-span-1 rounded-lg border-2 border-gray-300 bg-white text-gray-900 
                        dark:border-gray-600 dark:bg-gray-800 dark:text-white 
                        py-3 sm:py-3 px-3 sm:px-4 font-semibold text-xs sm:text-sm
                        hover:border-blue-500 dark:hover:border-blue-400 hover:shadow-md
                        transition-all duration-200 cursor-pointer
                        active:scale-95">
                                Custom
                            </button>
                        </div>

                        <input id="customAmount" type="number" min="1" placeholder="Enter custom amount..."
                            class="hidden w-full rounded-lg border-2 border-gray-300 dark:border-gray-600
                    bg-white dark:bg-gray-800 text-gray-900 dark:text-white
                    px-3 sm:px-4 py-3 text-xs sm:text-sm font-medium
                    focus:outline-none focus:border-green-500 dark:focus:border-green-400 focus:ring-2 focus:ring-green-100 dark:focus:ring-green-900
                    transition-all duration-200">
                    </div>

                    {{-- Payment --}}
                    <div class="mb-7 sm:mb-8">
                        <label
                            class="block text-xs sm:text-sm font-semibold text-gray-900 dark:text-gray-100 mb-2 sm:mb-3">
                            Payment Method
                        </label>
                        <select name="payment_method"
                            class="w-full rounded-lg border-2 border-gray-300 dark:border-gray-600
                        bg-white dark:bg-gray-800 text-gray-900 dark:text-white
                        px-3 sm:px-4 py-3 text-xs sm:text-sm font-medium
                        focus:outline-none focus:border-green-500 dark:focus:border-green-400 focus:ring-2 focus:ring-green-100 dark:focus:ring-green-900
                        transition-all duration-200 cursor-pointer
                        appearance-none bg-no-repeat bg-right pr-10"
                            style="background-image: url('data:image/svg+xml;charset=UTF-8,<svg xmlns=\"http://www.w3.org/2000/svg\" viewBox=\"0 0 24 24\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2\"><polyline points=\"6 9 12 15 18 9\"></polyline></svg>');
                        background-position: right 10px center;
                        background-size: 20px;
                        padding-right: 40px;">
                            <option value="paypal">PayPal</option>
                            <option value="stripe">Stripe</option>
                            <option value="card">Credit Card</option>
                        </select>
                    </div>

                    <button type="submit"
                        class="w-full rounded-lg bg-gradient-to-r from-green-600 to-green-500
                    hover:from-green-700 hover:to-green-600
                    text-white py-4 sm:py-3 px-4 font-bold text-base sm:text-base
                    shadow-md hover:shadow-lg
                    transition-all duration-200 transform hover:scale-[1.02]
                    active:scale-95
                    focus:outline-none focus:ring-2 focus:ring-green-300 dark:focus:ring-green-800 focus:ring-offset-2 dark:focus:ring-offset-gray-900">
                        Pay Now
                    </button>

                </form>

            </div>
        </div>
    </div>

    <script>
        let selectedAmount = null;

        const amountBtns = document.querySelectorAll('.amount-btn');
        const customBtn = document.getElementById('customBtn');
        const customInput = document.getElementById('customAmount');
        const finalAmount = document.getElementById('finalAmount');
        const form = document.getElementById('paymentForm');

        amountBtns.forEach(btn => {
            btn.addEventListener('click', () => {
                amountBtns.forEach(b => {
                    b.classList.remove('ring-2', 'ring-green-500', 'dark:ring-green-400',
                        'border-green-500', 'dark:border-green-400', 'bg-green-50',
                        'dark:bg-green-900/20');
                });
                btn.classList.add('ring-2', 'ring-green-500', 'dark:ring-green-400', 'border-green-500',
                    'dark:border-green-400', 'bg-green-50', 'dark:bg-green-900/20');

                selectedAmount = btn.dataset.amount;
                finalAmount.value = selectedAmount;

                customInput.classList.add('hidden');
                customInput.value = '';
            });
        });

        customBtn.addEventListener('click', () => {
            amountBtns.forEach(b => {
                b.classList.remove('ring-2', 'ring-green-500', 'dark:ring-green-400', 'border-green-500',
                    'dark:border-green-400', 'bg-green-50', 'dark:bg-green-900/20');
            });
            customInput.classList.remove('hidden');
            customInput.focus();
            selectedAmount = null;
            finalAmount.value = '';
        });

        customInput.addEventListener('input', () => {
            finalAmount.value = customInput.value;
        });

        form.addEventListener('submit', (e) => {
            if (!finalAmount.value || finalAmount.value <= 0) {
                e.preventDefault();
                alert('Please select or enter a valid amount');
            }
        });
    </script>

</body>

</html>
