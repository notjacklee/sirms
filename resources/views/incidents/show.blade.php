@extends('layouts.app')

@section('page-title', 'Incident Details')

@section('content')

@php
    $user = auth()->user();
    $statusName = $incident->status->name ?? 'Unknown';
@endphp

<div class="max-w-7xl mx-auto space-y-8">

    <!-- Top Bar -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <a href="{{ url()->previous() }}"
               class="inline-flex items-center text-sm font-medium text-blue-600 hover:text-blue-700 hover:underline mb-3">
                ← Back
            </a>

            <h1 class="text-3xl font-bold text-slate-900">
                Incident #{{ $incident->id }}
            </h1>
            <p class="text-slate-500 mt-1">
                {{ $incident->title }}
            </p>
        </div>

        <div class="flex flex-wrap gap-3">
            @if($statusName === 'New')
                <span class="inline-flex items-center rounded-full bg-blue-100 px-4 py-2 text-sm font-semibold text-blue-700">
                    Status: New
                </span>
            @elseif($statusName === 'Assigned')
                <span class="inline-flex items-center rounded-full bg-purple-100 px-4 py-2 text-sm font-semibold text-purple-700">
                    Status: Assigned
                </span>
            @elseif($statusName === 'In Review')
                <span class="inline-flex items-center rounded-full bg-purple-200 px-4 py-2 text-sm font-semibold text-purple-800">
                    Status: In Review
                </span>
            @elseif($statusName === 'Rejected')
                <span class="inline-flex items-center rounded-full bg-red-100 px-4 py-2 text-sm font-semibold text-red-700">
                    Status: Rejected
                </span>
            @elseif($statusName === 'Resubmitted')
                <span class="inline-flex items-center rounded-full bg-blue-100 px-4 py-2 text-sm font-semibold text-blue-700">
                    Status: Resubmitted
                </span>
            @elseif($statusName === 'Resolved')
                <span class="inline-flex items-center rounded-full bg-yellow-100 px-4 py-2 text-sm font-semibold text-yellow-700">
                    Status: Resolved
                </span>
            @elseif($statusName === 'Closed')
                <span class="inline-flex items-center rounded-full bg-green-100 px-4 py-2 text-sm font-semibold text-green-700">
                    Status: Closed
                </span>
            @else
                <span class="inline-flex items-center rounded-full bg-slate-100 px-4 py-2 text-sm font-semibold text-slate-700">
                    Status: {{ $statusName }}
                </span>
            @endif

            @if($incident->severity === 'High')
                <span class="inline-flex items-center rounded-full bg-red-100 px-4 py-2 text-sm font-semibold text-red-700">
                    Severity: High
                </span>
            @elseif($incident->severity === 'Medium')
                <span class="inline-flex items-center rounded-full bg-yellow-100 px-4 py-2 text-sm font-semibold text-yellow-700">
                    Severity: Medium
                </span>
            @else
                <span class="inline-flex items-center rounded-full bg-green-100 px-4 py-2 text-sm font-semibold text-green-700">
                    Severity: Low
                </span>
            @endif
        </div>
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

    <!-- Overview Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6">
        <div class="rounded-2xl bg-white border border-slate-200 shadow-sm p-6">
            <p class="text-sm font-medium uppercase tracking-wide text-slate-500">Reporter</p>
            <h3 class="mt-3 text-lg font-bold text-slate-900">
                {{ $incident->reporter->name ?? '-' }}
            </h3>
        </div>

        <div class="rounded-2xl bg-white border border-slate-200 shadow-sm p-6">
            <p class="text-sm font-medium uppercase tracking-wide text-slate-500">Assigned Officer</p>
            <h3 class="mt-3 text-lg font-bold text-slate-900">
                {{ $incident->assignedTo->name ?? 'Not Assigned' }}
            </h3>
        </div>

        <div class="rounded-2xl bg-white border border-slate-200 shadow-sm p-6">
            <p class="text-sm font-medium uppercase tracking-wide text-slate-500">Created Date</p>
            <h3 class="mt-3 text-lg font-bold text-slate-900">
                {{ $incident->created_at->format('d M Y') }}
            </h3>
        </div>

        <div class="rounded-2xl bg-white border border-slate-200 shadow-sm p-6">
            <p class="text-sm font-medium uppercase tracking-wide text-slate-500">Category</p>
            <h3 class="mt-3 text-lg font-bold text-slate-900">
                {{ $incident->category ?? '-' }}
            </h3>
        </div>
    </div>

    <!-- Main Grid -->
    <div class="grid grid-cols-1 xl:grid-cols-3 gap-8">

        <!-- Left Column -->
        <div class="xl:col-span-2 space-y-8">

            <!-- Description -->
            <div class="rounded-2xl bg-white border border-slate-200 shadow-sm overflow-hidden">
                <div class="px-6 py-5 border-b border-slate-200">
                    <h3 class="text-lg font-bold text-slate-900">Incident Description</h3>
                    <p class="text-sm text-slate-500 mt-1">
                        Detailed information submitted for this incident report.
                    </p>
                </div>

                <div class="px-6 py-6">
                    <p class="text-slate-700 leading-relaxed whitespace-pre-line">
                        {{ $incident->description }}
                    </p>
                </div>
            </div>

            <!-- Officer Investigation Panel -->
            @if($user->role === 'officer' && $incident->assigned_to == $user->id)
                @php
                    $currentStatus = $incident->status->name ?? '';

                    $allowedNextStatuses = match($currentStatus) {
                        'Assigned' => ['In Review', 'Rejected'],
                        'In Review' => ['Resolved', 'Rejected'],
                        'Resubmitted' => ['In Review', 'Rejected'],
                        'Resolved' => [],
                        'Rejected' => [],
                        'Closed' => [],
                        default => [],
                    };
                @endphp

                <div class="rounded-2xl bg-white border border-slate-200 shadow-sm overflow-hidden">
                    <div class="px-6 py-5 border-b border-slate-200">
                        <h3 class="text-lg font-bold text-slate-900">Investigation & Action</h3>
                        <p class="text-sm text-slate-500 mt-1">
                            Record findings, action taken, rejection reason, and resolution summary before updating status.
                        </p>
                    </div>

                    <form method="POST" action="{{ route('incidents.status', $incident) }}">
                        @csrf

                        <div class="px-6 py-6 space-y-6">
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-2">
                                    Investigation Notes
                                </label>
                                <textarea
                                    name="investigation_notes"
                                    rows="4"
                                    class="w-full rounded-xl border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                    placeholder="Write investigation findings, analysis, observations, or evidence review...">{{ old('investigation_notes', $incident->investigation_notes) }}</textarea>
                                @error('investigation_notes')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-2">
                                    Action Taken
                                </label>
                                <textarea
                                    name="action_taken"
                                    rows="3"
                                    class="w-full rounded-xl border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                    placeholder="Describe actions taken for this incident...">{{ old('action_taken', $incident->action_taken) }}</textarea>
                                @error('action_taken')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-2">
                                    Next Status
                                </label>

                                @if(count($allowedNextStatuses) > 0)
                                    <select
                                        id="status_id"
                                        name="status_id"
                                        required
                                        class="w-full rounded-xl border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                    >
                                        <option value="" disabled selected>Select next status</option>

                                        @foreach($statuses as $status)
                                            @if(in_array($status->name, $allowedNextStatuses))
                                                <option
                                                    value="{{ $status->id }}"
                                                    data-status-name="{{ $status->name }}"
                                                    {{ old('status_id') == $status->id ? 'selected' : '' }}
                                                >
                                                    {{ $status->name }}
                                                </option>
                                            @endif
                                        @endforeach
                                    </select>
                                @else
                                    <div class="rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-600">
                                        No further status update is available for this incident.
                                    </div>
                                @endif

                                @error('status_id')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div id="rejection_reason_wrapper" class="hidden">
                                <label class="block text-sm font-semibold text-red-600 mb-2">
                                    Rejection Reason
                                </label>
                                <textarea
                                    id="rejection_reason"
                                    name="rejection_reason"
                                    rows="3"
                                    class="w-full rounded-xl border-red-300 shadow-sm focus:border-red-500 focus:ring-red-500"
                                    placeholder="Explain why this incident is rejected...">{{ old('rejection_reason') }}</textarea>
                                @error('rejection_reason')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div id="resolution_summary_wrapper" class="hidden">
                                <label class="block text-sm font-semibold text-green-600 mb-2">
                                    Resolution Summary
                                </label>
                                <textarea
                                    id="resolution_summary"
                                    name="resolution_summary"
                                    rows="3"
                                    class="w-full rounded-xl border-green-300 shadow-sm focus:border-green-500 focus:ring-green-500"
                                    placeholder="Explain how the incident was resolved...">{{ old('resolution_summary') }}</textarea>
                                @error('resolution_summary')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            @if(count($allowedNextStatuses) > 0)
                                <button
                                    type="submit"
                                    class="w-full inline-flex justify-center rounded-xl bg-blue-600 px-5 py-3 text-sm font-semibold text-white shadow-sm hover:bg-blue-700 transition"
                                >
                                    Save Investigation Update
                                </button>
                            @endif
                        </div>
                    </form>
                </div>
            @endif

            <!-- Rejection Info -->
            @if(($incident->status->name ?? '') === 'Rejected' && !empty($incident->rejection_reason))
                <div class="rounded-2xl bg-red-50 border border-red-200 shadow-sm overflow-hidden">
                    <div class="px-6 py-5 border-b border-red-200">
                        <h3 class="text-lg font-bold text-red-700">Rejection Reason</h3>
                    </div>

                    <div class="px-6 py-6">
                        <p class="text-slate-700 whitespace-pre-line">{{ $incident->rejection_reason }}</p>

                        @if($user->role === 'reporter')
                            <div class="mt-4">
                                <a href="{{ route('incidents.edit', $incident->id) }}"
                                   class="inline-flex items-center rounded-lg bg-blue-600 px-4 py-2 text-sm font-semibold text-white hover:bg-blue-700 shadow-md transition">
                                    Edit & Resubmit
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            @endif

            <!-- Resolution Summary -->
            @if(!empty($incident->resolution_summary))
                <div class="rounded-2xl bg-green-50 border border-green-200 shadow-sm overflow-hidden">
                    <div class="px-6 py-5 border-b border-green-200">
                        <h3 class="text-lg font-bold text-green-700">Resolution Summary</h3>
                    </div>

                    <div class="px-6 py-6">
                        <p class="text-slate-700 whitespace-pre-line">{{ $incident->resolution_summary }}</p>
                    </div>
                </div>
            @endif

            <!-- Attachments -->
            <div class="rounded-2xl bg-white border border-slate-200 shadow-sm overflow-hidden">
                <div class="px-6 py-5 border-b border-slate-200">
                    <h3 class="text-lg font-bold text-slate-900">Attachments</h3>
                    <p class="text-sm text-slate-500 mt-1">
                        Supporting files uploaded for this incident.
                    </p>
                </div>

                <div class="px-6 py-6">
                    @forelse($incident->attachments as $attachment)
                        <div class="flex items-center justify-between rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 mb-3">
                            <div>
                                <p class="font-medium text-slate-800">
                                    {{ $attachment->filename ?? 'Attachment' }}
                                </p>
                                <p class="text-xs text-slate-500 mt-1">
                                    Uploaded {{ optional($attachment->uploaded_at)->format('d M Y H:i') ?? '-' }}
                                </p>
                            </div>

                            @if(!empty($attachment->filepath))
                                <a href="{{ asset('storage/' . $attachment->filepath) }}"
                                   target="_blank"
                                   class="text-sm font-semibold text-blue-600 hover:text-blue-700 hover:underline">
                                    View File
                                </a>
                            @endif
                        </div>
                    @empty
                        <p class="text-slate-500">No attachments uploaded.</p>
                    @endforelse
                </div>
            </div>

            <!-- Comments -->
            @if(
                $user->role === 'admin' ||
                ($user->role === 'officer' && $incident->assigned_to == $user->id) ||
                ($user->role === 'reporter' && $incident->reporter_id == $user->id)
            )
                <div class="rounded-2xl bg-white border border-slate-200 shadow-sm overflow-hidden">
                    <div class="px-6 py-5 border-b border-slate-200">
                        <h3 class="text-lg font-bold text-slate-900">Comments</h3>
                        <p class="text-sm text-slate-500 mt-1">
                            Discussion and communication related to this incident.
                        </p>
                    </div>

                    <div class="px-6 py-6">
                        @error('comment')
                            <div class="mb-4 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
                                {{ $message }}
                            </div>
                        @enderror

                        @forelse($incident->comments as $c)
                            <div class="rounded-2xl border border-slate-200 bg-slate-50 p-4 mb-4">
                                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2 text-sm">
                                    <strong class="text-slate-800">
                                        {{ $c->user->name ?? 'Unknown' }}
                                    </strong>

                                    <span class="text-slate-500">
                                        {{ $c->created_at->format('d M Y H:i') }}
                                    </span>
                                </div>

                                <p class="mt-3 text-slate-700 leading-relaxed whitespace-pre-line">
                                    {{ $c->message }}
                                </p>
                            </div>
                        @empty
                            <p class="text-slate-500">No comments yet.</p>
                        @endforelse

                        @if(Route::has('incidents.comment'))
                            <form method="POST" action="{{ route('incidents.comment', $incident) }}" class="mt-6">
                                @csrf

                                <label for="comment" class="block text-sm font-medium text-slate-700 mb-2">
                                    Add Comment
                                </label>

                                <textarea
                                    id="comment"
                                    name="comment"
                                    rows="4"
                                    required
                                    class="w-full rounded-xl border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                    placeholder="Write your comment here...">{{ old('comment') }}</textarea>

                                <button type="submit"
                                        class="mt-4 inline-flex rounded-xl bg-blue-600 px-5 py-3 text-sm font-semibold text-white shadow-sm hover:bg-blue-700 transition">
                                    Add Comment
                                </button>
                            </form>
                        @else
                            <div class="mt-6 rounded-xl border border-yellow-200 bg-yellow-50 px-4 py-3 text-sm text-yellow-800">
                                Comment route is not configured yet.
                            </div>
                        @endif
                    </div>
                </div>
            @endif

        </div>

        <!-- Right Column -->
        <div class="space-y-8">

            <!-- Incident Summary -->
            <div class="rounded-2xl bg-white border border-slate-200 shadow-sm overflow-hidden">
                <div class="px-6 py-5 border-b border-slate-200">
                    <h3 class="text-lg font-bold text-slate-900">Incident Summary</h3>
                </div>

                <div class="px-6 py-6 space-y-4 text-sm">
                    <div>
                        <p class="text-slate-500">Incident ID</p>
                        <p class="font-semibold text-slate-800 mt-1">#{{ $incident->id }}</p>
                    </div>

                    <div>
                        <p class="text-slate-500">Title</p>
                        <p class="font-semibold text-slate-800 mt-1">{{ $incident->title }}</p>
                    </div>

                    <div>
                        <p class="text-slate-500">Status</p>
                        <p class="font-semibold text-slate-800 mt-1">{{ $statusName }}</p>
                    </div>

                    <div>
                        <p class="text-slate-500">Severity</p>
                        <p class="font-semibold text-slate-800 mt-1">{{ $incident->severity }}</p>
                    </div>

                    <div>
                        <p class="text-slate-500">Reporter</p>
                        <p class="font-semibold text-slate-800 mt-1">{{ $incident->reporter->name ?? '-' }}</p>
                    </div>

                    <div>
                        <p class="text-slate-500">Assigned Officer</p>
                        <p class="font-semibold text-slate-800 mt-1">{{ $incident->assignedTo->name ?? 'Not Assigned' }}</p>
                    </div>

                    @if(!empty($incident->investigation_notes))
                        <div>
                            <p class="text-slate-500">Investigation Notes</p>
                            <p class="font-semibold text-slate-800 mt-1 whitespace-pre-line">{{ $incident->investigation_notes }}</p>
                        </div>
                    @endif

                    @if(!empty($incident->action_taken))
                        <div>
                            <p class="text-slate-500">Action Taken</p>
                            <p class="font-semibold text-slate-800 mt-1 whitespace-pre-line">{{ $incident->action_taken }}</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Timeline -->
            <div class="rounded-2xl bg-white border border-slate-200 shadow-sm overflow-hidden">
                <div class="px-6 py-5 border-b border-slate-200">
                    <h3 class="text-lg font-bold text-slate-900">Incident Timeline</h3>
                    <p class="text-sm text-slate-500 mt-1">
                        Recorded activity related to this incident.
                    </p>
                </div>

                <div class="px-6 py-6">
                    <div class="space-y-6">
                        @forelse($incident->auditLogs as $log)
                            <div class="flex items-start gap-4">
                                <div class="mt-1 w-3 h-3 rounded-full bg-blue-500 flex-shrink-0"></div>

                                <div>
                                    <div class="text-sm text-slate-600">
                                        <strong>{{ $log->user->name ?? 'System' }}</strong>
                                        <span class="ml-2 text-slate-400">
                                            {{ $log->created_at->format('d M Y H:i') }}
                                        </span>
                                    </div>

                                    <p class="mt-1 text-slate-700 leading-relaxed">
                                        {{ $log->action_type }} — {{ $log->details }}
                                    </p>
                                </div>
                            </div>
                        @empty
                            <p class="text-slate-500">No activity recorded.</p>
                        @endforelse
                    </div>
                </div>
            </div>

        </div>

    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const statusSelect = document.getElementById('status_id');
    const rejectionWrapper = document.getElementById('rejection_reason_wrapper');
    const resolutionWrapper = document.getElementById('resolution_summary_wrapper');
    const rejectionField = document.getElementById('rejection_reason');
    const resolutionField = document.getElementById('resolution_summary');

    function toggleStatusFields() {
        if (!statusSelect) return;

        const selectedOption = statusSelect.options[statusSelect.selectedIndex];
        const selectedStatus = selectedOption ? selectedOption.dataset.statusName : '';

        rejectionWrapper.classList.add('hidden');
        resolutionWrapper.classList.add('hidden');

        if (rejectionField) rejectionField.required = false;
        if (resolutionField) resolutionField.required = false;

        if (selectedStatus === 'Rejected') {
            rejectionWrapper.classList.remove('hidden');
            if (rejectionField) rejectionField.required = true;
        }

        if (selectedStatus === 'Resolved') {
            resolutionWrapper.classList.remove('hidden');
            if (resolutionField) resolutionField.required = true;
        }
    }

    if (statusSelect) {
        statusSelect.addEventListener('change', toggleStatusFields);
        toggleStatusFields();
    }
});
</script>

@endsection