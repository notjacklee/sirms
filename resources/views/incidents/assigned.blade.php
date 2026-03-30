@extends('layouts.app')

@section('page-title', 'Assigned Incidents')

@section('content')

<div class="space-y-8">

    <!-- Page Header -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h1 class="text-3xl font-bold text-slate-900">Assigned Incidents</h1>
            <p class="text-slate-500 mt-1">
                Review incidents assigned to you and open the case details page to perform investigation and update status.
            </p>
        </div>
    </div>

    <!-- Success Message -->
    @if(session('success'))
        <div class="rounded-2xl border border-green-200 bg-green-50 px-5 py-4 text-sm font-medium text-green-700">
            {{ session('success') }}
        </div>
    @endif

    <!-- Error Message -->
    @if(session('error'))
        <div class="rounded-2xl border border-red-200 bg-red-50 px-5 py-4 text-sm font-medium text-red-700">
            {{ session('error') }}
        </div>
    @endif

    <!-- Summary Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-6">
        <div class="rounded-2xl bg-white border border-slate-200 shadow-sm p-6">
            <p class="text-sm font-medium uppercase tracking-wide text-slate-500">Total Assigned</p>
            <h3 class="mt-3 text-4xl font-bold text-blue-600">{{ $incidents->count() }}</h3>
            <p class="mt-2 text-sm text-slate-500">Incidents currently assigned to you.</p>
        </div>

        <div class="rounded-2xl bg-white border border-slate-200 shadow-sm p-6">
            <p class="text-sm font-medium uppercase tracking-wide text-slate-500">High Severity</p>
            <h3 class="mt-3 text-4xl font-bold text-red-600">{{ $incidents->where('severity', 'High')->count() }}</h3>
            <p class="mt-2 text-sm text-slate-500">Urgent incidents needing priority action.</p>
        </div>

        <div class="rounded-2xl bg-white border border-slate-200 shadow-sm p-6">
            <p class="text-sm font-medium uppercase tracking-wide text-slate-500">Resolved</p>
            <h3 class="mt-3 text-4xl font-bold text-yellow-500">
                {{ $incidents->filter(fn($incident) => ($incident->status->name ?? '') === 'Resolved')->count() }}
            </h3>
            <p class="mt-2 text-sm text-slate-500">Cases that have been resolved and are awaiting closure.</p>
        </div>

        <div class="rounded-2xl bg-white border border-slate-200 shadow-sm p-6">
            <p class="text-sm font-medium uppercase tracking-wide text-slate-500">Closed</p>
            <h3 class="mt-3 text-4xl font-bold text-green-600">
                {{ $incidents->filter(fn($incident) => ($incident->status->name ?? '') === 'Closed')->count() }}
            </h3>
            <p class="mt-2 text-sm text-slate-500">Incidents already completed.</p>
        </div>
    </div>

    <!-- Assigned Incident Table -->
    <div class="rounded-2xl bg-white border border-slate-200 shadow-sm overflow-hidden">
        <div class="px-6 py-5 border-b border-slate-200">
            <h3 class="text-lg font-bold text-slate-900">Assigned Incident Records</h3>
            <p class="text-sm text-slate-500 mt-1">
                Open the case details page to perform investigation, record findings, and update incident status.
            </p>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead class="bg-slate-50 border-b border-slate-200">
                    <tr class="text-left">
                        <th class="px-4 py-4 font-semibold text-slate-600">ID</th>
                        <th class="px-4 py-4 font-semibold text-slate-600">Title</th>
                        <th class="px-4 py-4 font-semibold text-slate-600">Reporter</th>
                        <th class="px-4 py-4 font-semibold text-slate-600">Severity</th>
                        <th class="px-4 py-4 font-semibold text-slate-600">Current Status</th>
                        <th class="px-4 py-4 font-semibold text-slate-600">Action</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-slate-200">
                    @forelse($incidents as $incident)
                        @php
                            $statusName = trim($incident->status->name ?? 'Unknown');
                        @endphp

                        <tr class="hover:bg-slate-50 transition">
                            <td class="px-4 py-4 text-slate-700 font-medium">
                                #{{ $incident->id }}
                            </td>

                            <td class="px-4 py-4 min-w-[220px]">
                                <a href="{{ route('incidents.show', $incident) }}"
                                   class="font-semibold text-blue-600 hover:text-blue-700 hover:underline">
                                    {{ $incident->title }}
                                </a>
                            </td>

                            <td class="px-4 py-4 text-slate-700">
                                {{ $incident->reporter->name ?? '-' }}
                            </td>

                            <td class="px-4 py-4">
                                @if($incident->severity === 'High')
                                    <span class="inline-flex rounded-full bg-red-100 px-3 py-1 text-xs font-semibold text-red-700">
                                        High
                                    </span>
                                @elseif($incident->severity === 'Medium')
                                    <span class="inline-flex rounded-full bg-yellow-100 px-3 py-1 text-xs font-semibold text-yellow-700">
                                        Medium
                                    </span>
                                @else
                                    <span class="inline-flex rounded-full bg-green-100 px-3 py-1 text-xs font-semibold text-green-700">
                                        Low
                                    </span>
                                @endif
                            </td>

                            <td class="px-4 py-4">
                                @if($statusName === 'New')
                                    <span class="inline-flex rounded-full bg-blue-100 px-3 py-1 text-xs font-semibold text-blue-700">
                                        New
                                    </span>
                                @elseif($statusName === 'Assigned')
                                    <span class="inline-flex rounded-full bg-purple-100 px-3 py-1 text-xs font-semibold text-purple-700">
                                        Assigned
                                    </span>
                                @elseif($statusName === 'In Review')
                                    <span class="inline-flex rounded-full bg-purple-200 px-3 py-1 text-xs font-semibold text-purple-800">
                                        In Review
                                    </span>
                                @elseif($statusName === 'Rejected')
                                    <span class="inline-flex rounded-full bg-red-100 px-3 py-1 text-xs font-semibold text-red-700">
                                        Rejected
                                    </span>
                                @elseif($statusName === 'Resolved')
                                    <span class="inline-flex rounded-full bg-yellow-100 px-3 py-1 text-xs font-semibold text-yellow-700">
                                        Resolved
                                    </span>
                                @elseif($statusName === 'Closed')
                                    <span class="inline-flex rounded-full bg-green-100 px-3 py-1 text-xs font-semibold text-green-700">
                                        Closed
                                    </span>
                                @else
                                    <span class="inline-flex rounded-full bg-slate-100 px-3 py-1 text-xs font-semibold text-slate-700">
                                        {{ $statusName }}
                                    </span>
                                @endif
                            </td>

                            <td class="px-4 py-4">
                                <a href="{{ route('incidents.show', $incident) }}"
                                   class="inline-flex rounded-lg bg-slate-800 px-3 py-2 text-xs font-semibold text-white hover:bg-slate-900 transition">
                                    View Details
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-14 text-center text-slate-500">
                                <div class="flex flex-col items-center space-y-4">
                                    <div class="w-14 h-14 rounded-full bg-slate-100 flex items-center justify-center text-2xl">
                                        📋
                                    </div>

                                    <div>
                                        <p class="text-lg font-medium text-slate-700">No assigned incidents</p>
                                        <p class="text-sm text-slate-500 mt-1">
                                            Once an administrator assigns incidents to you, they will appear here.
                                        </p>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>

@endsection