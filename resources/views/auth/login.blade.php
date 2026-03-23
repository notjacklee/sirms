@extends('layouts.guest')

@section('content')

    <!-- Back To Home -->
    <div class="mb-4">
        <a href="{{ url('/') }}"
           class="inline-flex items-center gap-2 text-sm font-semibold text-slate-500 hover:text-blue-600 transition">
            ← Back to Home
        </a>
    </div>

    @if(session('success'))
        <div class="mb-4 rounded-xl border border-green-200 bg-green-50 px-4 py-3 text-sm font-medium text-green-700">
            {{ session('success') }}
        </div>
    @endif

    @if (session('status'))
        <div class="mb-4 rounded-xl border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-700">
            {{ session('status') }}
        </div>
    @endif

    <div class="text-center mb-6">
        <h2 class="text-3xl font-bold text-slate-900">Welcome Back</h2>
        <p class="text-sm text-slate-500 mt-1">Sign in to continue using SIRMS</p>
    </div>

    <form method="POST" action="{{ route('login') }}" class="space-y-5">
        @csrf

        <div>
            <label for="email" class="text-sm font-semibold text-slate-600">Email Address</label>
            <input
                id="email"
                type="email"
                name="email"
                value="{{ old('email') }}"
                class="mt-1 w-full rounded-xl border border-slate-300 px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition"
                required
                autofocus
                autocomplete="username"
            >
            @error('email')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <div class="flex items-center justify-between">
                <label for="password" class="text-sm font-semibold text-slate-600">Password</label>

                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}"
                       class="text-sm text-blue-600 hover:underline">
                        Forgot password?
                    </a>
                @endif
            </div>

            <input
                id="password"
                type="password"
                name="password"
                class="mt-1 w-full rounded-xl border border-slate-300 px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition"
                required
                autocomplete="current-password"
            >
            @error('password')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex items-center">
            <label class="flex items-center text-sm text-slate-600">
                <input
                    id="remember_me"
                    type="checkbox"
                    name="remember"
                    class="rounded border-slate-300 text-blue-600 focus:ring-blue-500 mr-2"
                >
                Remember me
            </label>
        </div>

        <button
            type="submit"
            class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 rounded-xl shadow transition"
        >
            Sign In
        </button>

        <div class="pt-2">
            <a href="{{ route('register') }}"
               class="inline-flex w-full justify-center rounded-xl border border-slate-300 bg-white px-4 py-3 text-sm font-semibold text-slate-700 hover:bg-slate-50 transition">
                Create New Account
            </a>
        </div>
    </form>

@endsection