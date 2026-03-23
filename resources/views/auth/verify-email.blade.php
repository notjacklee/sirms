@extends('layouts.guest')

@section('content')
    <div class="w-full max-w-lg">
        <div class="rounded-3xl border border-white/60 bg-white/90 backdrop-blur-xl shadow-2xl px-8 py-8">

            <div class="text-center mb-8">
                <div class="mx-auto mb-4 flex h-16 w-16 items-center justify-center rounded-2xl bg-white shadow-md ring-1 ring-slate-200 overflow-hidden">
                    <img src="{{ asset('images/sirms-logo.png') }}" alt="SIRMS Logo" class="h-10 w-10 object-contain">
                </div>

                <h2 class="text-3xl font-bold tracking-tight text-slate-900">Verify Your Email</h2>
                <p class="mt-2 text-sm text-slate-500">
                    Complete verification before accessing the SIRMS dashboard.
                </p>
            </div>

            <div class="mb-6 rounded-2xl border border-slate-200 bg-slate-50 px-5 py-4 text-sm leading-6 text-slate-600">
                Thanks for signing up! Before getting started, please verify your email address by clicking the link we just emailed to you.
                If you did not receive the email, we can send you another verification link.
            </div>

            @if (session('status') == 'verification-link-sent')
                <div class="mb-6 rounded-2xl border border-green-200 bg-green-50 px-5 py-4 text-sm font-medium text-green-700">
                    A new verification link has been sent to the email address you provided during registration.
                </div>
            @endif

            <div class="space-y-4">
                <form method="POST" action="{{ route('verification.send') }}">
                    @csrf

                    <button
                        type="submit"
                        class="inline-flex w-full justify-center rounded-2xl bg-blue-600 px-4 py-3.5 text-sm font-semibold text-white shadow-lg transition hover:bg-blue-700"
                    >
                        Resend Verification Email
                    </button>
                </form>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <button
                        type="submit"
                        class="inline-flex w-full justify-center rounded-2xl border border-slate-300 bg-white px-4 py-3.5 text-sm font-semibold text-slate-700 transition hover:bg-slate-50"
                    >
                        Log Out
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection