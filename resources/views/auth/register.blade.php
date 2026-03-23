@extends('layouts.guest')

@section('content')
    <div class="text-center mb-6">
        <h2 class="text-2xl font-bold text-slate-800">Create SIRMS Account</h2>
        <p class="text-sm text-slate-500 mt-1">Register to report security incidents</p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-5">
        @csrf

        <div>
            <label for="name" class="text-sm font-semibold text-slate-600">Full Name</label>
            <input
                id="name"
                type="text"
                name="name"
                value="{{ old('name') }}"
                class="mt-1 w-full rounded-xl border border-slate-300 px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition"
                required
                autofocus
                autocomplete="name"
            >
            @error('name')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="email" class="text-sm font-semibold text-slate-600">Email Address</label>
            <input
                id="email"
                type="email"
                name="email"
                value="{{ old('email') }}"
                class="mt-1 w-full rounded-xl border border-slate-300 px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition"
                required
                autocomplete="username"
            >
            @error('email')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="password" class="text-sm font-semibold text-slate-600">Password</label>
            <input
                id="password"
                type="password"
                name="password"
                class="mt-1 w-full rounded-xl border border-slate-300 px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition"
                required
                autocomplete="new-password"
            >
            @error('password')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="password_confirmation" class="text-sm font-semibold text-slate-600">Confirm Password</label>
            <input
                id="password_confirmation"
                type="password"
                name="password_confirmation"
                class="mt-1 w-full rounded-xl border border-slate-300 px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition"
                required
                autocomplete="new-password"
            >
        </div>

        <button
            type="submit"
            class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 rounded-xl shadow transition"
        >
            Register Account
        </button>

        <div class="mt-3">
            <a href="{{ route('login') }}"
               class="inline-flex w-full justify-center rounded-xl border border-slate-300 bg-white px-4 py-3 text-sm font-semibold text-slate-700 hover:bg-slate-50 transition">
                Sign In Instead
            </a>
        </div>
    </form>
@endsection