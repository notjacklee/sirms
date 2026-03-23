@extends('layouts.app')

@section('page-title', 'Incidents')

@section('content')

<div class="space-y-8">

    <!-- Header -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h1 class="text-3xl font-bold text-slate-900">
                {{ auth()->user()->role === 'admin' ? 'All Incidents' : 'My Reported Incidents' }}
            </h1>
            <p class="text-slate-500 mt-1">
                Total incidents: {{ $stats['total'] }}
            </p>
        </div>

        @if(auth()->user()->role === 'reporter')
            <a href="{{ route('incidents.create') }}"
               class="inline-flex items-center rounded-xl bg-blue-600 px-5 py-3 text-sm font-semibold text-white shadow-md hover:bg-blue-700 transition">
                + Report Incident
            </a>
        @endif
    </div>

    @if(session('success'))
        <div class="rounded-2xl border border-green-200 bg-green-50 px-5 py-4 text-sm font-medium text-green-700">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="rounded-2xl border border-red-200 bg-red-50 px-5 py-4 text-sm font-medium text-red-700">
            {{ session('error') }}
        </div>
    @endif

    <!-- Search + Filter -->
    <div class="rounded-2xl bg-white border border-slate-200 shadow-sm p-6">
        <form method="GET" action="{{ route('incidents.index') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div class="md:col-span-2">
                <label for="search" class="block text-sm font-semibold text-slate-700 mb-2">Search</label>
                <input
                    type="text"
                    id="search"
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="Search by title, category, or description"
                    class="w-full rounded-xl border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                >
            </div>

            <div>
                <label for="severity" class="block text-sm font-semibold text-slate-700 mb-2">Severity</label>
                <select
                    id="severity"
                    name="severity"
                    class="w-full rounded-xl border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                >
                    <option value="">All Severity</option>
                    <option value="High" {{ request('severity') == 'High' ? 'selected' : '' }}>High</option>
                    <option value="Medium" {{ request('severity') == 'Medium' ? 'selected' : '' }}>Medium</option>
                    <option value="Low" {{ request('severity') == 'Low' ? 'selected' : '' }}>Low</option>
                </select>
            </div>

            <div>
                <label for="status" class="block text-sm font-semibold text-slate-700 mb-2">Status</label>
                <select
                    id="status"
                    name="status"
                    class="w-full rounded-xl border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                >
                    <option value="">All Status</option>
                    @foreach($statuses as $status)
                        <option value="{{ $status->name }}" {{ request('status') == $status->name ? 'selected' : '' }}>
                            {{ $status->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="md:col-span-4 flex flex-wrap gap-3 pt-2">
                <button type="submit"
                        class="inline-flex justify-center rounded-xl bg-blue-600 px-5 py-3 text-sm font-semibold text-white hover:bg-blue-700 transition">
                    Search / Filter
                </button>

                <a href="{{ route('incidents.index') }}"
                   class="inline-flex justify-center rounded-xl bg-slate-200 px-5 py-3 text-sm font-semibold text-slate-700 hover:bg-slate-300 transition">
                    Clear Filters
                </a>
            </div>
        </form>
    </div>

    <!-- Summary Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-6">
        <div class="rounded-2xl bg-white border border-slate-200 shadow-sm p-6">
            <p class="text-sm font-medium uppercase tracking-wide text-slate-500">Total</p>
            <h3 class="mt-3 text-4xl font-bold text-blue-600">{{ $stats['total'] }}</h3>
            <p class="mt-2 text-sm text-slate-500">Incidents available in this view.</p>
        </div>

        <div class="rounded-2xl bg-white border border-slate-200 shadow-sm p-6">
            <p class="text-sm font-medium uppercase tracking-wide text-slate-500">High Severity</p>
            <h3 class="mt-3 text-4xl font-bold text-red-600">{{ $stats['high'] }}</h3>
            <p class="mt-2 text-sm text-slate-500">Urgent incidents requiring priority attention.</p>
        </div>

        <div class="rounded-2xl bg-white border border-slate-200 shadow-sm p-6">
            <p class="text-sm font-medium uppercase tracking-wide text-slate-500">Medium Severity</p>
            <h3 class="mt-3 text-4xl font-bold text-yellow-500">{{ $stats['medium'] }}</h3>
            <p class="mt-2 text-sm text-slate-500">Incidents that need timely follow-up.</p>
        </div>

        <div class="rounded-2xl bg-white border border-slate-200 shadow-sm p-6">
            <p class="text-sm font-medium uppercase tracking-wide text-slate-500">Low Severity</p>
            <h3 class="mt-3 text-4xl font-bold text-green-600">{{ $stats['low'] }}</h3>
            <p class="mt-2 text-sm text-slate-500">Lower-impact incidents for routine handling.</p>
        </div>
    </div>

    <!-- Incident Table -->
    <div class="rounded-2xl bg-white border border-slate-200 shadow-sm overflow-hidden">
        <div class="px-6 py-5 border-b border-slate-200">
            <h3 class="text-lg font-bold text-slate-900">Incident Records</h3>
            <p class="text-sm text-slate-500 mt-1">
                Review submitted incidents and monitor their current status.
            </p>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead class="bg-slate-50 border-b border-slate-200">
                    <tr class="text-left">
                        <th class="px-6 py-4 font-semibold text-slate-600">ID</th>
                        <th class="px-6 py-4 font-semibold text-slate-600">Title</th>
                        <th class="px-6 py-4 font-semibold text-slate-600">Severity</th>
                        <th class="px-6 py-4 font-semibold text-slate-600">Status</th>
                        <th class="px-6 py-4 font-semibold text-slate-600">Created</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-slate-200">
                    @forelse($incidents as $incident)
                        <tr class="hover:bg-slate-50 transition">
                            <td class="px-6 py-4 text-slate-700 font-medium">
                                #{{ $incident->id }}
                            </td>

                            <td class="px-6 py-4 min-w-[260px]">
                                <a href="{{ route('incidents.show', $incident->id) }}"
                                   class="font-semibold text-blue-600 hover:text-blue-700 hover:underline">
                                    {{ $incident->title }}
                                </a>
                                <p class="text-xs text-slate-500 mt-1">
                                    {{ $incident->category }}
                                </p>
                            </td>

                            <td class="px-6 py-4">
                                @if($incident->severity === 'High')
                                    <span class="inline-flex px-3 py-1 text-xs font-semibold bg-red-100 text-red-700 rounded-full">
                                        High
                                    </span>
                                @elseif($incident->severity === 'Medium')
                                    <span class="inline-flex px-3 py-1 text-xs font-semibold bg-yellow-100 text-yellow-700 rounded-full">
                                        Medium
                                    </span>
                                @else
                                    <span class="inline-flex px-3 py-1 text-xs font-semibold bg-green-100 text-green-700 rounded-full">
                                        Low
                                    </span>
                                @endif
                            </td>

                            <td class="px-6 py-4">
                                @php
                                    $statusName = $incident->status->name ?? 'Unknown';
                                @endphp

                                @if($statusName === 'New')
                                    <span class="inline-flex px-3 py-1 text-xs font-semibold bg-blue-100 text-blue-700 rounded-full">
                                        {{ $statusName }}
                                    </span>
                                @elseif($statusName === 'In Review')
                                    <span class="inline-flex px-3 py-1 text-xs font-semibold bg-purple-100 text-purple-700 rounded-full">
                                        {{ $statusName }}
                                    </span>
                                @elseif($statusName === 'Assigned')
                                    <span class="inline-flex px-3 py-1 text-xs font-semibold bg-indigo-100 text-indigo-700 rounded-full">
                                        {{ $statusName }}
                                    </span>
                                @elseif($statusName === 'Resolved')
                                    <span class="inline-flex px-3 py-1 text-xs font-semibold bg-green-100 text-green-700 rounded-full">
                                        {{ $statusName }}
                                    </span>
                                @elseif($statusName === 'Closed')
                                    <span class="inline-flex px-3 py-1 text-xs font-semibold bg-slate-200 text-slate-700 rounded-full">
                                        {{ $statusName }}
                                    </span>
                                @elseif($statusName === 'Invalid')
                                    <span class="inline-flex px-3 py-1 text-xs font-semibold bg-red-100 text-red-700 rounded-full">
                                        {{ $statusName }}
                                    </span>
                                @else
                                    <span class="inline-flex px-3 py-1 text-xs font-semibold bg-slate-100 text-slate-700 rounded-full">
                                        {{ $statusName }}
                                    </span>
                                @endif
                            </td>

                            <td class="px-6 py-4 text-slate-500 whitespace-nowrap">
                                {{ $incident->created_at->format('d M Y') }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-14 text-center text-slate-500">
                                <div class="flex flex-col items-center space-y-4">
                                    <div class="w-14 h-14 rounded-full bg-slate-100 flex items-center justify-center text-2xl">
                                        📄
                                    </div>

                                    <div>
                                        <p class="text-lg font-medium text-slate-700">No incidents found</p>
                                        <p class="text-sm text-slate-500 mt-1">
                                            Try changing your search or filter criteria.
                                        </p>
                                    </div>

                                    @if(auth()->user()->role === 'reporter')
                                        <a href="{{ route('incidents.create') }}"
                                           class="bg-blue-600 text-white px-5 py-2.5 rounded-lg font-semibold hover:bg-blue-700 transition">
                                            Create First Incident
                                        </a>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($incidents->hasPages())
            <div class="px-6 py-4 border-t border-slate-200">
                {{ $incidents->links() }}
            </div>
        @endif
    </div>

</div>

@endsection