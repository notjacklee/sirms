@extends('layouts.guest')

@section('content')
<div class="w-full max-w-md mx-auto bg-white shadow rounded-2xl p-8">
    <div class="text-center mb-6">
        <h1 class="text-2xl font-bold text-slate-900">Forgot Password</h1>
        <p class="text-sm text-slate-500 mt-2">
            Enter your email address and we will send you a password reset link.
        </p>
    </div>

    @if (session('status'))
        <div class="mb-4 rounded-xl border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-700">
            {{ session('status') }}
        </div>
    @endif

    <form id="forgotPasswordForm" method="POST" action="{{ route('password.email') }}" class="space-y-5">
        @csrf

        <div>
            <label for="email" class="block text-sm font-medium text-slate-700 mb-2">Email Address</label>
            <input
                id="email"
                type="email"
                name="email"
                value="{{ old('email') }}"
                required
                autofocus
                class="w-full rounded-xl border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                placeholder="Enter your registered email"
            >
            @error('email')
                <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
            @enderror
        </div>

        <p class="text-xs text-slate-400">
            A reset link will be sent to your registered email account.
        </p>

        <button
            id="submitBtn"
            type="submit"
            class="w-full rounded-xl bg-blue-600 px-4 py-3 text-sm font-semibold text-white hover:bg-blue-700 transition"
        >
            Send Reset Link
        </button>
    </form>

    <div class="mt-4">
    <a href="{{ route('login') }}"
       class="inline-flex w-full justify-center rounded-xl border border-slate-300 bg-white px-4 py-3 text-sm font-semibold text-slate-700 hover:bg-slate-50 transition">
        Back to Login
    </a>
</div>
</div>

<script>
document.getElementById('forgotPasswordForm').addEventListener('submit', function () {
    const btn = document.getElementById('submitBtn');
    btn.innerHTML = 'Sending...';
    btn.disabled = true;
});
</script>
@endsection