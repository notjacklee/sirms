@extends('layouts.app')

@section('page-title', 'My Profile')

@section('content')
@php
    $user = auth()->user();

    $roleColors = [
        'admin' => 'bg-red-100 text-red-700',
        'officer' => 'bg-yellow-100 text-yellow-700',
        'reporter' => 'bg-blue-100 text-blue-700',
    ];

    $roleClass = $roleColors[$user->role] ?? 'bg-slate-100 text-slate-700';

    $totalReported = method_exists($user, 'reportedIncidents') ? $user->reportedIncidents()->count() : 0;
    $totalAssigned = method_exists($user, 'assignedIncidents') ? $user->assignedIncidents()->count() : 0;
    $totalComments = method_exists($user, 'comments') ? $user->comments()->count() : 0;
@endphp

<div class="max-w-6xl mx-auto space-y-8">

    <div>
        <h1 class="text-3xl font-bold text-slate-900">My Profile</h1>
        <p class="text-slate-500 mt-1">Manage your account information and security settings.</p>
    </div>

    @if (session('status'))
        <div class="rounded-2xl border border-green-200 bg-green-50 px-5 py-4 text-sm font-medium text-green-700">
            {{ session('status') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="rounded-2xl border border-red-200 bg-red-50 px-5 py-4 text-sm text-red-700">
            <ul class="list-disc list-inside space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="grid grid-cols-1 xl:grid-cols-3 gap-8">

        <!-- Left Column -->
        <div class="space-y-8">

            <!-- Profile Summary -->
            <div class="rounded-2xl bg-white border border-slate-200 shadow-sm overflow-hidden">
                <div class="px-6 py-6 text-center">
                    <div class="mx-auto flex h-24 w-24 items-center justify-center rounded-full bg-slate-100 text-3xl font-bold text-slate-700">
                        {{ strtoupper(substr($user->name, 0, 1)) }}
                    </div>

                    <h2 class="mt-4 text-xl font-bold text-slate-900">{{ $user->name }}</h2>
                    <p class="mt-1 text-slate-500">{{ $user->email }}</p>

                    <div class="mt-4 flex items-center justify-center gap-2">
                        <span class="inline-flex items-center rounded-full px-3 py-1 text-sm font-semibold {{ $roleClass }}">
                            {{ ucfirst($user->role) }}
                        </span>

                        @if($user->email_verified_at)
                            <span class="inline-flex items-center rounded-full bg-green-100 px-3 py-1 text-sm font-semibold text-green-700">
                                Verified
                            </span>
                        @else
                            <span class="inline-flex items-center rounded-full bg-yellow-100 px-3 py-1 text-sm font-semibold text-yellow-700">
                                Unverified
                            </span>
                        @endif
                    </div>
                </div>

                <div class="border-t border-slate-200 px-6 py-5 space-y-4 text-sm">
                    <div>
                        <p class="text-slate-500">Member Since</p>
                        <p class="font-semibold text-slate-800 mt-1">
                            {{ optional($user->created_at)->format('d M Y') ?? '-' }}
                        </p>
                    </div>

                    <div>
                        <p class="text-slate-500">Account Role</p>
                        <p class="font-semibold text-slate-800 mt-1">{{ ucfirst($user->role) }}</p>
                    </div>

                    <div>
                        <p class="text-slate-500">Email Status</p>
                        <p class="font-semibold text-slate-800 mt-1">
                            {{ $user->email_verified_at ? 'Verified' : 'Not Verified' }}
                        </p>
                    </div>
                </div>
            </div>

            <!-- Activity Summary -->
            <div class="rounded-2xl bg-white border border-slate-200 shadow-sm overflow-hidden">
                <div class="px-6 py-5 border-b border-slate-200">
                    <h3 class="text-lg font-bold text-slate-900">Activity Summary</h3>
                    <p class="text-sm text-slate-500 mt-1">Overview of your account activities.</p>
                </div>

                <div class="px-6 py-6 grid grid-cols-1 gap-4">
                    @if($user->role === 'reporter')
                        <div class="rounded-xl bg-blue-50 border border-blue-100 px-4 py-4">
                            <p class="text-sm text-blue-600">Incidents Submitted</p>
                            <p class="mt-2 text-2xl font-bold text-blue-800">{{ $totalReported }}</p>
                        </div>
                    @endif

                    @if($user->role === 'officer')
                        <div class="rounded-xl bg-yellow-50 border border-yellow-100 px-4 py-4">
                            <p class="text-sm text-yellow-600">Assigned Incidents</p>
                            <p class="mt-2 text-2xl font-bold text-yellow-800">{{ $totalAssigned }}</p>
                        </div>
                    @endif

                    @if($user->role === 'admin')
                        <div class="rounded-xl bg-red-50 border border-red-100 px-4 py-4">
                            <p class="text-sm text-red-600">Managed Incidents</p>
                            <p class="mt-2 text-2xl font-bold text-red-800">{{ \App\Models\Incident::count() }}</p>
                        </div>
                    @endif

                    <div class="rounded-xl bg-slate-50 border border-slate-200 px-4 py-4">
                        <p class="text-sm text-slate-500">Comments Made</p>
                        <p class="mt-2 text-2xl font-bold text-slate-800">{{ $totalComments }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Column -->
        <div class="xl:col-span-2 space-y-8">

            <!-- Edit Profile -->
            <div class="rounded-2xl bg-white border border-slate-200 shadow-sm overflow-hidden">
                <div class="px-6 py-5 border-b border-slate-200">
                    <h3 class="text-lg font-bold text-slate-900">Personal Information</h3>
                    <p class="text-sm text-slate-500 mt-1">Update your account details.</p>
                </div>

                <div class="px-6 py-6">
                    <form method="POST" action="{{ route('profile.update') }}" class="space-y-6">
                        @csrf
                        @method('PATCH')

                        <div>
                            <label for="name" class="block text-sm font-medium text-slate-700 mb-2">Full Name</label>
                            <input
                                id="name"
                                name="name"
                                type="text"
                                value="{{ old('name', $user->name) }}"
                                required
                                class="w-full rounded-xl border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                            >
                        </div>

                        <div>
                            <label for="email" class="block text-sm font-medium text-slate-700 mb-2">Email Address</label>
                            <input
                                id="email"
                                name="email"
                                type="email"
                                value="{{ old('email', $user->email) }}"
                                required
                                class="w-full rounded-xl border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                            >
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-2">Role</label>
                            <input
                                type="text"
                                value="{{ ucfirst($user->role) }}"
                                readonly
                                class="w-full rounded-xl border-slate-200 bg-slate-100 text-slate-600 shadow-sm"
                            >
                        </div>

                        <div class="flex justify-end">
                            <button type="submit"
                                    class="inline-flex rounded-xl bg-blue-600 px-5 py-3 text-sm font-semibold text-white shadow-sm hover:bg-blue-700 transition">
                                Save Changes
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Change Password -->
            <div class="rounded-2xl bg-white border border-slate-200 shadow-sm overflow-hidden">
                <div class="px-6 py-5 border-b border-slate-200">
                    <h3 class="text-lg font-bold text-slate-900">Change Password</h3>
                    <p class="text-sm text-slate-500 mt-1">Keep your account secure by using a strong password.</p>
                </div>

                <div class="px-6 py-6">
                    <form method="POST" action="{{ route('password.update') }}" class="space-y-6">
                        @csrf
                        @method('PUT')

                        <div>
                            <label for="current_password" class="block text-sm font-medium text-slate-700 mb-2">Current Password</label>
                            <input
                                id="current_password"
                                name="current_password"
                                type="password"
                                class="w-full rounded-xl border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                            >
                        </div>

                        <div>
                            <label for="password" class="block text-sm font-medium text-slate-700 mb-2">New Password</label>
                            <input
                                id="password"
                                name="password"
                                type="password"
                                class="w-full rounded-xl border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                            >
                        </div>

                        <div>
                            <label for="password_confirmation" class="block text-sm font-medium text-slate-700 mb-2">Confirm New Password</label>
                            <input
                                id="password_confirmation"
                                name="password_confirmation"
                                type="password"
                                class="w-full rounded-xl border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                            >
                        </div>

                        <div class="flex justify-end">
                            <button type="submit"
                                    class="inline-flex rounded-xl bg-slate-900 px-5 py-3 text-sm font-semibold text-white shadow-sm hover:bg-slate-800 transition">
                                Update Password
                            </button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection