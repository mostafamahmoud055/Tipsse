@extends('auth.main-layout')

@section('auth-content')
    <div class="flex w-full flex-1 flex-col lg:w-1/2">
        <div class="mx-auto flex w-full max-w-md flex-1 flex-col justify-center">
            <div>
                <div class="mb-5 sm:mb-8">
                    <h1 class="text-title-sm sm:text-title-md mb-2 font-semibold text-gray-800 dark:text-white/90">
                        Forgot Your Password ?
                    </h1>
                    <p class="text-sm text-gray-500 dark:text-gray-400">
                        Enter the email address linked to your account, and we’ll send you a link to reset your password.

                    </p>
                </div>
                @if (session('status'))
                    <div class="mb-4 rounded bg-green-50 p-3 text-sm text-green-700">
                        {{ session('status') }}
                    </div>
                @endif
                <div>
                    <form method="POST" action="{{ url('/forgot-password') }}">
                        @csrf
                        <div class="space-y-5">
                            <!-- Email -->
                            <div>
                                <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                                    Email<span class="text-error-500">*</span>
                                </label>
                                <input type="email" id="email" required name="email" placeholder="info@gmail.com"
                                    value="{{ old('email') }}"
                                    class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30" />
                                @error('email')
                                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Button -->
                            <div class="grid">
                                <button
                                    class="inline-flex items-center justify-center gap-3 rounded-lg bg-gray-100 text-gray-700 px-7 py-3 text-sm font-normal transition-colors hover:bg-gray-200 hover:text-gray-800 dark:bg-white/5 dark:text-white/90 dark:hover:bg-white/10">
                                    Send Reset Link
                                </button>
                            </div>
                        </div>
                    </form>
                    <div class="mt-5">
                        <p class="text-center text-sm font-normal text-gray-700 sm:text-start dark:text-gray-400">
                            Wait, I remember my password...
                            <a href="/login" class="text-brand-400">
                                Click here ?
                            </a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
