@extends('layouts.app')

@section('page-title', 'Admin Dashboard')

@section('content')

<div class="space-y-8">

    <!-- Page Heading -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h1 class="text-3xl font-bold text-slate-900">Admin Dashboard</h1>
            <p class="text-slate-500 mt-1">
                Monitor incident activity, assign officers, and track response progress.
            </p>
        </div>

        <div class="flex flex-wrap gap-3">
            <a href="{{ route('incidents.index') }}"
               class="inline-flex items-center rounded-xl border border-slate-300 bg-white px-5 py-3 text-sm font-semibold text-slate-700 shadow-sm hover:bg-slate-50 transition">
                View All Incidents
            </a>

            <a href="{{ route('admin.reports.csv') }}"
               class="inline-flex items-center rounded-xl bg-green-600 px-5 py-3 text-sm font-semibold text-white shadow-sm hover:bg-green-700 transition">
                Export CSV
            </a>

            <a href="{{ route('admin.reports.pdf') }}"
               class="inline-flex items-center rounded-xl bg-red-600 px-5 py-3 text-sm font-semibold text-white shadow-sm hover:bg-red-700 transition">
                Export PDF
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="rounded-2xl border border-green-200 bg-green-50 px-5 py-4 text-sm font-medium text-green-700 flex items-center gap-2">
            ✓ {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="rounded-2xl border border-red-200 bg-red-50 px-5 py-4 text-sm font-medium text-red-700 flex items-center gap-2">
            {{ session('error') }}
        </div>
    @endif

    <!-- Summary Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6">

        <div class="rounded-2xl bg-white border border-slate-200 shadow-sm p-6">
            <p class="text-sm font-medium uppercase tracking-wide text-slate-500">
                Total Incidents
            </p>
            <h3 class="mt-3 text-4xl font-bold text-blue-600">
                {{ $totalIncidents }}
            </h3>
            <p class="mt-2 text-sm text-slate-500">
                Total incidents recorded in the system.
            </p>
        </div>

        <div class="rounded-2xl bg-white border border-slate-200 shadow-sm p-6">
            <p class="text-sm font-medium uppercase tracking-wide text-slate-500">
                High Severity
            </p>
            <h3 class="mt-3 text-4xl font-bold text-red-600">
                {{ $bySeverity['High'] ?? 0 }}
            </h3>
            <p class="mt-2 text-sm text-slate-500">
                Urgent incidents requiring immediate action.
            </p>
        </div>

        <div class="rounded-2xl bg-white border border-slate-200 shadow-sm p-6">
            <p class="text-sm font-medium uppercase tracking-wide text-slate-500">
                Medium Severity
            </p>
            <h3 class="mt-3 text-4xl font-bold text-yellow-500">
                {{ $bySeverity['Medium'] ?? 0 }}
            </h3>
            <p class="mt-2 text-sm text-slate-500">
                Incidents needing timely investigation.
            </p>
        </div>

        <div class="rounded-2xl bg-white border border-slate-200 shadow-sm p-6">
            <p class="text-sm font-medium uppercase tracking-wide text-slate-500">
                Low Severity
            </p>
            <h3 class="mt-3 text-4xl font-bold text-green-600">
                {{ $bySeverity['Low'] ?? 0 }}
            </h3>
            <p class="mt-2 text-sm text-slate-500">
                Lower-impact incidents for routine handling.
            </p>
        </div>

    </div>

    <!-- Status Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6">
        @forelse($statusCounts as $status => $count)
            <div class="rounded-2xl bg-white border border-slate-200 shadow-sm p-6">
                <p class="text-sm font-medium uppercase tracking-wide text-slate-500">
                    {{ $status }}
                </p>
                <h3 class="mt-3 text-3xl font-bold text-slate-800">
                    {{ $count }}
                </h3>
                <p class="mt-2 text-sm text-slate-500">
                    Incidents currently in {{ strtolower($status) }} status.
                </p>
            </div>
        @empty
            <div class="rounded-2xl bg-white border border-slate-200 shadow-sm p-6 col-span-full">
                <p class="text-slate-500">No status data available.</p>
            </div>
        @endforelse
    </div>

    <!-- Severity Chart -->
    <div class="rounded-2xl bg-white border border-slate-200 shadow-sm p-6">
        <div class="mb-5">
            <h3 class="text-lg font-bold text-slate-900">Incident Severity Chart</h3>
            <p class="text-sm text-slate-500 mt-1">
                Visual overview of incidents grouped by severity level.
            </p>
        </div>

        <div class="h-80">
            <canvas id="severityChart"></canvas>
        </div>
    </div>

    <!-- Main Section -->
    <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">

        <!-- Severity Breakdown -->
        <div class="xl:col-span-1 rounded-2xl bg-white border border-slate-200 shadow-sm p-6">
            <div class="mb-5">
                <h3 class="text-lg font-bold text-slate-900">Incidents by Severity</h3>
                <p class="text-sm text-slate-500 mt-1">
                    Distribution of incidents based on severity level.
                </p>
            </div>

            <div class="space-y-4">
                @forelse($bySeverity as $sev => $count)
                    <div class="flex items-center justify-between rounded-xl bg-slate-50 border border-slate-200 px-4 py-3">
                        <div>
                            <p class="font-semibold text-slate-800 capitalize">{{ $sev }}</p>
                            <p class="text-xs text-slate-500">Severity category</p>
                        </div>
                        <span class="text-xl font-bold text-slate-900">{{ $count }}</span>
                    </div>
                @empty
                    <p class="text-sm text-slate-500">No severity data available.</p>
                @endforelse
            </div>
        </div>

        <!-- Recent Incidents -->
        <div class="xl:col-span-2 rounded-2xl bg-white border border-slate-200 shadow-sm overflow-hidden">
            <div class="px-6 py-5 border-b border-slate-200">
                <h3 class="text-lg font-bold text-slate-900">Recent Incidents</h3>
                <p class="text-sm text-slate-500 mt-1">
                    Review recent incidents and assign officers directly.
                </p>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full text-sm">
                    <thead class="bg-slate-50">
                        <tr class="text-left text-slate-600">
                            <th class="px-4 py-4 font-semibold">ID</th>
                            <th class="px-4 py-4 font-semibold">Title</th>
                            <th class="px-4 py-4 font-semibold">Reporter</th>
                            <th class="px-4 py-4 font-semibold">Severity</th>
                            <th class="px-4 py-4 font-semibold">Status</th>
                            <th class="px-4 py-4 font-semibold">Assign Officer</th>
                            <th class="px-4 py-4 font-semibold">Action</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-slate-200">
                        @forelse($recent as $incident)
                            <tr class="hover:bg-slate-50 transition">
                                <td class="px-4 py-4 text-slate-700 font-medium">
                                    #{{ $incident->id }}
                                </td>

                                <td class="px-4 py-4 text-slate-900 font-semibold min-w-[220px]">
                                    {{ \Illuminate\Support\Str::limit($incident->title, 40) }}
                                </td>

                                <td class="px-4 py-4 text-slate-700">
                                    {{ $incident->reporter->name ?? '-' }}
                                </td>

                                <td class="px-4 py-4">
                                    @if($incident->severity == 'High')
                                        <span class="inline-flex rounded-full bg-red-100 px-3 py-1 text-xs font-semibold text-red-700">
                                            High
                                        </span>
                                    @elseif($incident->severity == 'Medium')
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
                                    @php
                                        $status = $incident->status->name ?? '';
                                    @endphp

                                    @if($status == 'New')
                                        <span class="px-3 py-1 text-xs rounded-full bg-blue-100 text-blue-700">New</span>
                                    @elseif($status == 'Assigned')
                                        <span class="px-3 py-1 text-xs rounded-full bg-purple-100 text-purple-700">Assigned</span>
                                    @elseif($status == 'In Review')
                                        <span class="px-3 py-1 text-xs rounded-full bg-purple-200 text-purple-800">In Review</span>
                                    @elseif($status == 'Rejected')
                                        <span class="px-3 py-1 text-xs rounded-full bg-red-100 text-red-700">Rejected</span>
                                    @elseif($status == 'Resubmitted')
                                        <span class="px-3 py-1 text-xs rounded-full bg-blue-100 text-blue-700">Resubmitted</span>
                                    @elseif($status == 'Resolved')
                                        <span class="px-3 py-1 text-xs rounded-full bg-yellow-100 text-yellow-700">Pending Closure</span>
                                    @elseif($status == 'Closed')
                                        <span class="px-3 py-1 text-xs rounded-full bg-green-100 text-green-700">Closed</span>
                                    @else
                                        <span class="px-3 py-1 text-xs rounded-full bg-slate-100 text-slate-700">Unknown</span>
                                    @endif
                                </td>

                                <td class="px-4 py-4 min-w-[260px]">
                                    @if($incident->assignedTo)
                                        <div class="rounded-xl border border-slate-200 bg-slate-50 px-4 py-3">
                                            <p class="text-xs font-medium text-slate-500">Assigned Officer</p>
                                            <p class="mt-1 text-sm font-semibold text-slate-800">
                                                {{ $incident->assignedTo->name }}
                                            </p>
                                        </div>
                                    @else
                                        <form method="POST" action="{{ route('incidents.assign', $incident) }}">
                                            @csrf
                                            <div class="flex items-center gap-2">
                                                <select name="officer_id"
                                                        class="w-full rounded-lg border-slate-300 text-sm shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                                        required>
                                                    <option value="" selected disabled>Select officer</option>
                                                    @foreach($officers as $officer)
                                                        <option value="{{ $officer->id }}">
                                                            {{ $officer->name }}
                                                        </option>
                                                    @endforeach
                                                </select>

                                                <button type="submit"
                                                        onclick="return confirm('Assign this officer to investigate this incident?')"
                                                        class="rounded-lg bg-blue-600 px-3 py-2 text-xs font-semibold text-white hover:bg-blue-700 transition">
                                                    Assign
                                                </button>
                                            </div>
                                        </form>
                                    @endif
                                </td>

    <td class="px-4 py-4">
    <div class="flex items-center gap-2">
        <a href="{{ route('incidents.show', $incident) }}"
           class="inline-flex justify-center min-w-[72px] rounded-lg bg-slate-800 px-3 py-2 text-xs font-semibold text-white hover:bg-slate-900 transition">
            View
        </a>

        @if(($incident->status->name ?? '') === 'Resolved')
            <form method="POST" action="{{ route('incidents.close', $incident) }}">
                @csrf
                @method('PUT')

                <button type="submit"
                    onclick="return confirm('Are you sure you want to CLOSE this incident?')"
                    class="inline-flex justify-center min-w-[72px] rounded-lg bg-green-600 px-3 py-2 text-xs font-semibold text-white hover:bg-green-700 transition">
                    Close
                </button>
            </form>
        @endif
    </div>
</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-4 py-10 text-center text-slate-500">
                                    No incidents yet.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <div class="p-4">
                    {{ $recent->links() }}
                </div>
            </div>
        </div>

    </div>
</div>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const severityCtx = document.getElementById('severityChart');

    if (severityCtx) {
        new Chart(severityCtx, {
            type: 'bar',
            data: {
                labels: ['High', 'Medium', 'Low'],
                datasets: [{
                    label: 'Number of Incidents',
                    data: [
                        {{ $bySeverity['High'] ?? 0 }},
                        {{ $bySeverity['Medium'] ?? 0 }},
                        {{ $bySeverity['Low'] ?? 0 }}
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            precision: 0
                        }
                    }
                }
            }
        });
    }
</script>
@endpush