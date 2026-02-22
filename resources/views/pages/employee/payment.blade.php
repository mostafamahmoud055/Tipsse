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
            @include('layouts.message')

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

                @if ($employee->image)
                    <div class="flex justify-center my-5 h-40 w-full ">
                        <img src="{{ route('image.show', ['path' => $employee->image]) }}"
                            class="mb-4 overflow-hidden rounded-full ring-4 ring-gray-50 dark:ring-gray-800object-cover"
                            alt="Employee Image">
                    </div>
                @endif

                {{-- Employee --}}
                <div
                    class="text-center mb-8 py-3 sm:py-4 rounded-lg bg-gradient-to-r from-gray-50 to-gray-100 dark:from-gray-900 dark:to-gray-800">
                    <h2 class="text-xl sm:text-2xl font-bold text-gray-900 dark:text-white px-2">
                        {{ $employee->name }}
                    </h2>
                </div>

                <form method="POST" action="{{ route('payments.process') }}" id="paymentForm">
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
                        hover:border-green-500 dark:hover:border-green-400 hover:shadow-md
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

                    {{-- Rating --}}
                    <div class="mb-6">
                        <p class="text-center text-xs sm:text-sm font-semibold text-gray-900 dark:text-gray-100 mb-4">
                            Rate Your Experience
                        </p>

                        <div class="flex justify-center items-center gap-2 sm:gap-3 mb-2">
                            @for ($i = 1; $i <= 5; $i++)
                                <button type="button" class="star-rating-btn" data-rating="{{ $i }}"
                                    aria-label="Rate {{ $i }} stars">
                                    <svg class="star-icon w-8 sm:w-10 h-8 sm:h-10 transition-all duration-200 cursor-pointer"
                                        viewBox="0 0 24 24" fill="currentColor">
                                        <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z" />
                                    </svg>
                                </button>
                            @endfor
                        </div>

                        <p id="ratingText" class="text-xs sm:text-sm text-gray-500 dark:text-gray-400 text-center">
                            Click to rate
                        </p>

                        <input type="hidden" name="rating" id="ratingInput" value="">
                    </div>

                    {{-- Payment --}}
                    {{--  <div class="mb-7 sm:mb-8">
                        <label
                            class="block text-xs sm:text-sm font-semibold text-gray-900 dark:text-gray-100 mb-2 sm:mb-3">
                            Payment Method
                        </label>

                        <div class="relative">
                            <button type="button" id="paymentToggle"
                                class="w-full rounded-lg border-2 border-gray-300 dark:border-gray-600
                                bg-white dark:bg-gray-800 text-gray-900 dark:text-white
                                px-3 sm:px-4 py-3 text-xs sm:text-sm font-medium text-left
                                focus:outline-none focus:border-green-500 dark:focus:border-green-400 focus:ring-2 focus:ring-green-100 dark:focus:ring-green-900
                                transition-all duration-200 cursor-pointer flex items-center justify-between">
                                <div class="flex items-center gap-2">
                                    <img id="selectedImage" src="" alt="Payment" class="w-8 h-5 hidden">
                                    <span id="selectedPayment">Select Payment Method</span>
                                </div>
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <polyline points="6 9 12 15 18 9"></polyline>
                                </svg>
                            </button>

                            <div id="paymentDropdown"
                                class="hidden absolute top-full left-0 right-0 mt-1 rounded-lg border-2 border-gray-300 dark:border-gray-600
                                bg-white dark:bg-gray-800 shadow-lg z-10">

                                <button type="button"
                                    class="payment-option w-full px-3 sm:px-4 py-3 text-left hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors flex items-center gap-2 border-b border-gray-200 dark:border-gray-700"
                                    data-value="stripe" data-label="Visa / Master Card"
                                    data-image="{{ asset('images/icons/cc.jpeg') }}">
                                    <img src="{{ asset('images/icons/cc.jpeg') }}" alt="Visa / Master Card"
                                        class="w-9 h-5">
                                    <span class="text-xs sm:text-sm">Visa / Master Card</span>
                                </button>
                                <button type="button"
                                    class="payment-option w-full px-3 sm:px-4 py-3 text-left hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors flex items-center gap-2 border-b border-gray-200 dark:border-gray-700"
                                    data-value="paypal" data-label="Apple Pay"
                                    data-image="{{ asset('images/icons/apay.png') }}">
                                    <img src="{{ asset('images/icons/apay.png') }}" alt="Apple Pay" class="w-9 h-5">
                                    <span class="text-xs sm:text-sm">Apple Pay</span>
                                </button>


                                <button type="button"
                                    class="payment-option w-full px-3 sm:px-4 py-3 text-left hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors flex items-center gap-2"
                                    data-value="samsung" data-label="Samsung Pay"
                                    data-image="{{ asset('images/icons/sp.jpg') }}">
                                    <img src="{{ asset('images/icons/sp.jpg') }}" alt="Samsung Pay" class="w-9 h-5">
                                    <span class="text-xs sm:text-sm">Samsung Pay</span>
                                </button>
                            </div>
                        </div>

                        <input type="hidden" name="payment_method" id="paymentMethod" value="">
                    </div>  --}}

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

    <style>
        .star-rating-btn {
            background: none;
            border: none;
            padding: 0;
            cursor: pointer;
        }

        .star-icon {
            color: #d1d5db;
            transition: all 0.2s ease;
        }

        .dark .star-icon {
            color: #4b5563;
        }

        .star-rating-btn:hover .star-icon,
        .star-rating-btn:hover ~ .amount-btn .star-icon {
            color: #fbbf24;
        }

        .star-rating-btn.active .star-icon {
            color: #f59e0b;
        }
    </style>

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

        // Star Rating
        const starRatingBtns = document.querySelectorAll('.star-rating-btn');
        const ratingInput = document.getElementById('ratingInput');
        const ratingText = document.getElementById('ratingText');
        const ratingLabels = ['Terrible', 'Poor', 'Average', 'Good', 'Excellent'];

        starRatingBtns.forEach(btn => {
            btn.addEventListener('click', (e) => {
                e.preventDefault();
                const rating = btn.dataset.rating;
                ratingInput.value = rating;

                // Update star visual states
                starRatingBtns.forEach((b, index) => {
                    if (index < rating) {
                        b.classList.add('active');
                    } else {
                        b.classList.remove('active');
                    }
                });

                // Update text
                ratingText.textContent = ratingLabels[rating - 1];
                ratingText.classList.remove('text-gray-500', 'dark:text-gray-400');
                ratingText.classList.add('text-gray-900', 'dark:text-gray-100', 'font-medium');
            });

            // Hover effect
            btn.addEventListener('mouseenter', () => {
                const rating = btn.dataset.rating;
                starRatingBtns.forEach((b, index) => {
                    if (index < rating) {
                        b.querySelector('.star-icon').style.color = '#fbbf24';
                    } else {
                        b.querySelector('.star-icon').style.color = '#d1d5db';
                    }
                });
            });
        });

        // Reset hover effect when leaving stars
        const ratingContainer = document.querySelector('.flex.justify-center.items-center.gap-2');
        if (ratingContainer) {
            ratingContainer.addEventListener('mouseleave', () => {
                starRatingBtns.forEach(btn => {
                    btn.querySelector('.star-icon').style.color = '';
                });
            });
        }

        // Payment method dropdown
        const paymentToggle = document.getElementById('paymentToggle');
        const paymentDropdown = document.getElementById('paymentDropdown');
        const paymentOptions = document.querySelectorAll('.payment-option');
        const paymentMethodInput = document.getElementById('paymentMethod');
        const selectedPaymentSpan = document.getElementById('selectedPayment');
        const selectedImage = document.getElementById('selectedImage');

        paymentToggle.addEventListener('click', (e) => {
            e.preventDefault();
            paymentDropdown.classList.toggle('hidden');
        });

        paymentOptions.forEach(option => {
            option.addEventListener('click', (e) => {
                e.preventDefault();
                const value = option.dataset.value;
                const label = option.dataset.label;
                const image = option.dataset.image;

                paymentMethodInput.value = value;
                selectedPaymentSpan.textContent = label;
                selectedImage.src = image;
                selectedImage.classList.remove('hidden');
                paymentDropdown.classList.add('hidden');
            });
        });

        // Close dropdown when clicking outside
        document.addEventListener('click', (e) => {
            if (!e.target.closest('.relative')) {
                paymentDropdown.classList.add('hidden');
            }
        });

        form.addEventListener('submit', (e) => {
            if (!finalAmount.value || finalAmount.value <= 0) {
                e.preventDefault();
                alert('Please select or enter a valid amount');
            }
            if (!paymentMethodInput.value) {
                e.preventDefault();
                alert('Please select a payment method');
            }
        });
    </script>

</body>

</html>
