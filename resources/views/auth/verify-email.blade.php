@extends('auth.main-layout')

@section('auth-content')
    <div class="flex w-full flex-1 flex-col lg:w-1/2">
        <div class="mx-auto flex w-full max-w-md flex-1 flex-col justify-center">
            <div>
                <div class="mb-5 sm:mb-8">
                    <h1 class="text-title-sm sm:text-title-md mb-2 font-semibold text-gray-800 dark:text-white/90">
                        Verify your email </h1>

                    @if (session('status') == 'verification-link-sent')
                        <div class="alert alert-success">
                            A new verification link has been sent to your email.
                        </div>
                    @endif
                    <p class="text-sm text-gray-500 dark:text-gray-400">
                        Please check your email and click the verification link.

                    </p>
                </div>
                <div>
                    <form method="POST" action="{{ route('verification.send') }}">
                        @csrf
                        <div class="space-y-5">

                            <!-- Button -->
                            <div class="grid">
                                <button
                                    class="inline-flex items-center justify-center gap-3 rounded-lg bg-gray-100 text-gray-700 px-7 py-3 text-sm font-normal transition-colors hover:bg-gray-200 hover:text-gray-800 dark:bg-white/5 dark:text-white/90 dark:hover:bg-white/10">
                                    Resend Verification Email
                                </button>
                            </div>
                        </div>
                    </form>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit">Logout</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
