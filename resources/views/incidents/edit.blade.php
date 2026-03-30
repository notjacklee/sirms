@extends('layouts.app')

@section('page-title', 'Resubmit Incident')

@section('content')

<div class="max-w-4xl mx-auto space-y-6">

    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-slate-900">Resubmit Incident</h1>
            <p class="mt-1 text-slate-500">
                Update the rejected incident based on the feedback and submit it again for review.
            </p>
        </div>

        <a href="{{ route('incidents.index') }}"
           class="inline-flex items-center rounded-xl border border-slate-300 bg-white px-5 py-3 text-sm font-semibold text-slate-700 shadow-sm hover:bg-slate-50 transition">
            Back to Incidents
        </a>
    </div>

    @if(session('error'))
        <div class="rounded-2xl border border-red-200 bg-red-50 px-5 py-4 text-sm font-medium text-red-700">
            {{ session('error') }}
        </div>
    @endif

    @if(($incident->status->name ?? '') === 'Rejected' && !empty($incident->rejection_reason))
        <div class="rounded-2xl bg-red-50 border border-red-200 shadow-sm overflow-hidden">
            <div class="px-6 py-5 border-b border-red-200">
                <h3 class="text-lg font-bold text-red-700">Rejection Reason</h3>
                <p class="text-sm text-red-600 mt-1">
                    Please review the feedback below before resubmitting.
                </p>
            </div>

            <div class="px-6 py-6">
                <p class="text-slate-700 whitespace-pre-line">{{ $incident->rejection_reason }}</p>
            </div>
        </div>
    @endif

    <div class="rounded-2xl bg-white border border-slate-200 shadow-sm overflow-hidden">
        <div class="px-6 py-5 border-b border-slate-200">
            <h3 class="text-lg font-bold text-slate-900">Incident Information</h3>
            <p class="text-sm text-slate-500 mt-1">
                Correct the details and submit the incident again.
            </p>
        </div>

        <form method="POST" action="{{ route('incidents.update', $incident->id) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="px-6 py-6 space-y-6">

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Title</label>
                    <input
                        type="text"
                        name="title"
                        value="{{ old('title', $incident->title) }}"
                        class="w-full rounded-xl border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                        placeholder="Enter incident title"
                    >
                    @error('title')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Category</label>
                    <input
                        type="text"
                        name="category"
                        value="{{ old('category', $incident->category) }}"
                        class="w-full rounded-xl border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                        placeholder="Enter incident category"
                    >
                    @error('category')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Severity</label>
                    <select
                        name="severity"
                        class="w-full rounded-xl border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                    >
                        <option value="High" {{ old('severity', $incident->severity) == 'High' ? 'selected' : '' }}>High</option>
                        <option value="Medium" {{ old('severity', $incident->severity) == 'Medium' ? 'selected' : '' }}>Medium</option>
                        <option value="Low" {{ old('severity', $incident->severity) == 'Low' ? 'selected' : '' }}>Low</option>
                    </select>
                    @error('severity')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Description</label>
                    <textarea
                        name="description"
                        rows="6"
                        class="w-full rounded-xl border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                        placeholder="Describe the incident in detail..."
                    >{{ old('description', $incident->description) }}</textarea>
                    @error('description')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Upload New Attachment (Optional)</label>
                    <input
                        type="file"
                        name="attachment"
                        class="block w-full text-sm text-slate-700 file:mr-4 file:rounded-lg file:border-0 file:bg-blue-50 file:px-4 file:py-2 file:font-semibold file:text-blue-700 hover:file:bg-blue-100"
                    >
                    <p class="mt-2 text-xs text-slate-500">
                        Supported formats: JPG, JPEG, PNG, PDF, DOC, DOCX (max 5MB)
                    </p>
                    @error('attachment')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex flex-wrap gap-3 pt-2">
                    <button
                        type="submit"
                        class="inline-flex items-center rounded-xl bg-blue-600 px-5 py-3 text-sm font-semibold text-white shadow-sm hover:bg-blue-700 transition"
                    >
                        Submit Resubmission
                    </button>

                    <a href="{{ route('incidents.index') }}"
                       class="inline-flex items-center rounded-xl bg-slate-200 px-5 py-3 text-sm font-semibold text-slate-700 hover:bg-slate-300 transition">
                        Cancel
                    </a>
                </div>

            </div>
        </form>
    </div>

</div>

@endsection