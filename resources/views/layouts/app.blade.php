<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIRMS - Security Incident Management</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-100 text-slate-800 antialiased">

    @php
        $notifications = auth()->check() ? auth()->user()->unreadNotifications : collect();
    @endphp

    <div class="min-h-screen flex">

        <!-- Sidebar -->
        <aside class="hidden md:flex md:w-72 md:flex-col bg-slate-900 text-white shadow-2xl">
            <div class="px-6 py-6 border-b border-slate-800">
                <div class="flex items-center gap-3">
                    <img src="{{ asset('images/sirms-logo.png') }}"
                         alt="SIRMS Logo"
                         class="w-11 h-11 rounded-xl object-cover shadow-lg">
                    <div>
                        <h1 class="text-xl font-bold leading-tight">SIRMS</h1>
                        <p class="text-xs text-slate-400">Incident Management System</p>
                    </div>
                </div>
            </div>

            <nav class="flex-1 px-4 py-6 space-y-2">
                @auth

                    @if(Auth::user()->role === 'admin')
                        <a href="{{ route('admin.index') }}"
                           class="{{ request()->routeIs('admin.index') ? 'bg-slate-800 text-white' : 'text-slate-200 hover:bg-slate-800 hover:text-white' }} block px-4 py-3 rounded-xl text-sm font-medium transition">
                            Dashboard
                        </a>

                        <a href="{{ route('incidents.index') }}"
                           class="{{ request()->routeIs('incidents.index', 'incidents.show') ? 'bg-slate-800 text-white' : 'text-slate-200 hover:bg-slate-800 hover:text-white' }} block px-4 py-3 rounded-xl text-sm font-medium transition">
                            All Incidents
                        </a>

                        <a href="{{ route('admin.audit-logs') }}"
                           class="{{ request()->routeIs('admin.audit-logs') ? 'bg-slate-800 text-white' : 'text-slate-200 hover:bg-slate-800 hover:text-white' }} block px-4 py-3 rounded-xl text-sm font-medium transition">
                            Audit Logs
                        </a>

                    @elseif(Auth::user()->role === 'reporter')
                        <a href="{{ route('incidents.index') }}"
                           class="{{ request()->routeIs('incidents.index', 'incidents.show') ? 'bg-slate-800 text-white' : 'text-slate-200 hover:bg-slate-800 hover:text-white' }} block px-4 py-3 rounded-xl text-sm font-medium transition">
                            My Incidents
                        </a>

                        <a href="{{ route('incidents.create') }}"
                           class="{{ request()->routeIs('incidents.create') ? 'bg-slate-800 text-white' : 'text-slate-200 hover:bg-slate-800 hover:text-white' }} block px-4 py-3 rounded-xl text-sm font-medium transition">
                            Report Incident
                        </a>

                    @elseif(Auth::user()->role === 'officer')
                        <a href="{{ route('incidents.assigned') }}"
                           class="{{ request()->routeIs('incidents.assigned', 'incidents.show') ? 'bg-slate-800 text-white' : 'text-slate-200 hover:bg-slate-800 hover:text-white' }} block px-4 py-3 rounded-xl text-sm font-medium transition">
                            Assigned Incidents
                        </a>
                    @endif

                    <a href="{{ route('profile.edit') }}"
                       class="{{ request()->routeIs('profile.edit') ? 'bg-slate-800 text-white' : 'text-slate-200 hover:bg-slate-800 hover:text-white' }} block px-4 py-3 rounded-xl text-sm font-medium transition">
                        Profile
                    </a>
                @endauth
            </nav>

            <div class="px-4 py-4 border-t border-slate-800">
                @auth
                    <div class="mb-3 px-2">
                        <p class="text-sm font-semibold text-white">{{ Auth::user()->name }}</p>
                        <p class="text-xs text-slate-400">{{ Auth::user()->email }}</p>
                    </div>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                                class="w-full rounded-xl bg-red-500 px-4 py-2.5 text-sm font-semibold text-white hover:bg-red-600 transition">
                            Logout
                        </button>
                    </form>
                @endauth
            </div>
        </aside>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col min-w-0">

            <!-- Topbar -->
            <header class="bg-white border-b border-slate-200 shadow-sm">
                <div class="px-6 py-4 flex items-center justify-between">
                    <div>
                        <h2 class="text-2xl font-bold text-slate-900">
                            @yield('page-title', 'Dashboard')
                        </h2>
                        <p class="text-sm text-slate-500">
                            Security Incident Response Management System
                        </p>
                    </div>

                    @auth
                        <div class="hidden sm:flex items-center gap-4">
                            <!-- Notification Bell -->
                            <div class="relative">
                                <button id="notifBtn"
                                        type="button"
                                        class="relative flex h-10 w-10 items-center justify-center rounded-full bg-slate-100 text-slate-700 hover:bg-slate-200 transition">
                                    🔔
                                    @if($notifications->count() > 0)
                                        <span class="absolute -top-1 -right-1 min-w-[20px] h-5 px-1 rounded-full bg-red-500 text-white text-[11px] font-bold flex items-center justify-center">
                                            {{ $notifications->count() }}
                                        </span>
                                    @endif
                                </button>

                                <div id="notifDropdown"
                                     class="hidden absolute right-0 mt-3 w-80 rounded-2xl border border-slate-200 bg-white shadow-xl z-50 overflow-hidden">
                                    <div class="px-4 py-3 border-b border-slate-200 bg-slate-50">
                                        <h3 class="text-sm font-semibold text-slate-800">Notifications</h3>
                                    </div>

                                    @if($notifications->count() > 0)
                                        <div class="px-4 py-2 border-b border-slate-200 bg-white text-right">
                                            <form method="POST" action="{{ route('notifications.readAll') }}">
                                                @csrf
                                                <button type="submit"
                                                        class="text-xs font-medium text-blue-600 hover:text-blue-700">
                                                    Mark all as read
                                                </button>
                                            </form>
                                        </div>
                                    @endif

                                    <div class="max-h-80 overflow-y-auto">
                                        @forelse($notifications as $notification)
                                            <form method="POST" action="{{ route('notifications.read', $notification->id) }}">
                                                @csrf
                                                <button type="submit"
                                                        class="block w-full text-left px-4 py-3 border-b border-slate-100 hover:bg-slate-50 transition">
                                                    <p class="text-sm font-medium text-slate-800">
                                                        {{ $notification->data['message'] ?? 'New notification' }}
                                                    </p>

                                                    @if(isset($notification->data['title']))
                                                        <p class="text-xs text-slate-500 mt-1">
                                                            Incident: {{ $notification->data['title'] }}
                                                        </p>
                                                    @endif

                                                    @if(isset($notification->data['status']))
                                                        <p class="text-xs text-slate-500 mt-1">
                                                            Status: {{ $notification->data['status'] }}
                                                        </p>
                                                    @endif

                                                    <p class="text-[11px] text-slate-400 mt-2">
                                                        {{ $notification->created_at->diffForHumans() }}
                                                    </p>
                                                </button>
                                            </form>
                                        @empty
                                            <div class="px-4 py-6 text-center text-sm text-slate-500">
                                                No new notifications
                                            </div>
                                        @endforelse
                                    </div>
                                </div>
                            </div>

                            <div class="text-right">
                                <p class="text-sm font-semibold text-slate-800">{{ Auth::user()->name }}</p>
                                <p class="text-xs text-slate-500 capitalize">{{ Auth::user()->role }}</p>
                            </div>
                            <div class="w-10 h-10 rounded-full bg-blue-100 text-blue-700 flex items-center justify-center font-bold">
                                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                            </div>
                        </div>
                    @endauth
                </div>
            </header>

            <!-- Page Content -->
            <main class="flex-1 p-6 lg:p-8">
                @yield('content')
            </main>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const notifBtn = document.getElementById('notifBtn');
            const notifDropdown = document.getElementById('notifDropdown');

            if (notifBtn && notifDropdown) {
                notifBtn.addEventListener('click', function (e) {
                    e.stopPropagation();
                    notifDropdown.classList.toggle('hidden');
                });

                document.addEventListener('click', function (e) {
                    if (!notifDropdown.contains(e.target) && !notifBtn.contains(e.target)) {
                        notifDropdown.classList.add('hidden');
                    }
                });
            }
        });
    </script>

    @stack('scripts')
</body>
</html>