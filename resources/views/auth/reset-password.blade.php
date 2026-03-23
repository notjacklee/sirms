@extends('layouts.guest')

@section('content')
<div class="w-full max-w-md mx-auto bg-white shadow rounded-2xl p-8">
    <h1 class="text-2xl font-bold text-slate-900 mb-2">Reset Password</h1>
    <p class="text-sm text-slate-500 mb-6">
        Enter your email and new password below.
    </p>

    <form method="POST" action="{{ route('password.store') }}" class="space-y-5">
        @csrf

        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <div>
            <label for="email" class="block text-sm font-medium text-slate-700 mb-2">Email</label>
            <input id="email" type="email" name="email" value="{{ old('email', $request->email) }}" required
                   class="w-full rounded-xl border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
            @error('email')
                <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="password" class="block text-sm font-medium text-slate-700 mb-2">New Password</label>
            <input id="password" type="password" name="password" required
                   class="w-full rounded-xl border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
            @error('password')
                <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="password_confirmation" class="block text-sm font-medium text-slate-700 mb-2">Confirm Password</label>
            <input id="password_confirmation" type="password" name="password_confirmation" required
                   class="w-full rounded-xl border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
        </div>

        <button type="submit"
                class="w-full rounded-xl bg-blue-600 px-4 py-3 text-sm font-semibold text-white hover:bg-blue-700 transition">
            Reset Password
        </button>
    </form>
</div>
@endsection