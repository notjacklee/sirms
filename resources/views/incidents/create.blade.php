@extends('layouts.app')

@section('page-title', 'Report Incident')

@section('content')

<div class="max-w-5xl mx-auto space-y-8">

    <!-- Page Header -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h1 class="text-3xl font-bold text-slate-900">Report Incident</h1>
            <p class="text-slate-500 mt-1">
                Submit a new security incident with the required details for review and investigation.
            </p>
        </div>

        <a href="{{ route('incidents.index') }}"
           class="inline-flex items-center text-sm font-medium text-slate-500 hover:text-blue-600 hover:underline transition">
            ← Back to Incidents
        </a>
    </div>

    <!-- Form Card -->
    <div class="rounded-2xl bg-white border border-slate-200 shadow-sm overflow-hidden">
        <div class="px-6 py-5 border-b border-slate-200">
            <h2 class="text-lg font-bold text-slate-900">Security Incident Report Form</h2>
            <p class="text-sm text-slate-500 mt-1">
                Complete all required fields accurately before submitting the incident.
            </p>
        </div>

        <form id="incidentForm" method="POST" action="{{ route('incidents.store') }}" enctype="multipart/form-data" class="px-6 py-6 space-y-6">
            @csrf

            <!-- Title -->
            <div>
                <label for="title" class="block text-sm font-semibold text-slate-700 mb-2">
                    Incident Title <span class="text-red-500">*</span>
                </label>

                <input
                    id="title"
                    type="text"
                    name="title"
                    value="{{ old('title') }}"
                    placeholder="Enter a clear incident title"
                    class="w-full rounded-xl border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                    required
                >

                @error('title')
                    <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                @enderror
            </div>

            <!-- Category + Severity -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                <div>
                    <label for="category" class="block text-sm font-semibold text-slate-700 mb-2">
                        Category <span class="text-red-500">*</span>
                    </label>

                    <input
                        id="category"
                        type="text"
                        name="category"
                        list="incident-categories"
                        value="{{ old('category') }}"
                        placeholder="Select or enter a category"
                        class="w-full rounded-xl border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                        required
                    >

                    <datalist id="incident-categories">
                        <option value="Malware">
                        <option value="Phishing">
                        <option value="Network Attack">
                        <option value="Unauthorized Access">
                        <option value="Data Breach">
                        <option value="Suspicious Email">
                        <option value="Account Compromise">
                        <option value="Insider Threat">
                    </datalist>

                    @error('category')
                        <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="severity" class="block text-sm font-semibold text-slate-700 mb-2">
                        Severity <span class="text-red-500">*</span>
                    </label>

                    <select
                        id="severity"
                        name="severity"
                        class="w-full rounded-xl border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                        required
                    >
                        <option value="">Select Severity</option>
                        <option value="Low" {{ old('severity') == 'Low' ? 'selected' : '' }}>Low</option>
                        <option value="Medium" {{ old('severity') == 'Medium' ? 'selected' : '' }}>Medium</option>
                        <option value="High" {{ old('severity') == 'High' ? 'selected' : '' }}>High</option>
                    </select>

                    @error('severity')
                        <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                    @enderror
                </div>

            </div>

            <!-- Description -->
            <div>
                <label for="description" class="block text-sm font-semibold text-slate-700 mb-2">
                    Description <span class="text-red-500">*</span>
                </label>

                <textarea
                    id="description"
                    name="description"
                    rows="6"
                    placeholder="Describe the incident clearly, including what happened, when it happened, affected systems, and any suspicious activity observed."
                    class="w-full rounded-xl border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                    required
                >{{ old('description') }}</textarea>

                <p class="mt-2 text-xs text-slate-400">
                    Do not include passwords or sensitive credentials in this report.
                </p>

                @error('description')
                    <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                @enderror
            </div>

            <!-- Supporting Evidence -->
            <div>
                <label for="attachment" class="block text-sm font-semibold text-slate-700 mb-2">
                    Supporting Evidence
                </label>

                <input
                    id="attachment"
                    type="file"
                    name="attachment"
                    class="w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-sm shadow-sm focus:border-blue-500 focus:ring-blue-500"
                    accept=".jpg,.jpeg,.png,.pdf,.doc,.docx"
                >

                <p class="mt-2 text-sm text-slate-500">
                    Optional. Upload screenshots, PDFs, or supporting documents.
                </p>

                @error('attachment')
                    <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                @enderror
            </div>

            <!-- Severity Guide -->
            <div class="rounded-2xl border border-slate-200 bg-slate-50 p-5">
                <h3 class="text-sm font-bold text-slate-800 mb-3">Severity Guide</h3>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm">
                    <div class="rounded-xl bg-white border border-slate-200 p-4 hover:shadow-md transition">
                        <span class="inline-flex rounded-full bg-green-100 px-3 py-1 text-xs font-semibold text-green-700 mb-3">
                            Low
                        </span>
                        <p class="text-slate-600">
                            Minor issue with limited impact and low urgency.
                        </p>
                    </div>

                    <div class="rounded-xl bg-white border border-slate-200 p-4 hover:shadow-md transition">
                        <span class="inline-flex rounded-full bg-yellow-100 px-3 py-1 text-xs font-semibold text-yellow-700 mb-3">
                            Medium
                        </span>
                        <p class="text-slate-600">
                            Incident that affects operations and requires timely investigation.
                        </p>
                    </div>

                    <div class="rounded-xl bg-white border border-slate-200 p-4 hover:shadow-md transition">
                        <span class="inline-flex rounded-full bg-red-100 px-3 py-1 text-xs font-semibold text-red-700 mb-3">
                            High
                        </span>
                        <p class="text-slate-600">
                            Serious incident with high impact that needs immediate attention.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex flex-col sm:flex-row justify-end gap-3 pt-2">
                <a href="{{ route('incidents.index') }}"
                   class="inline-flex justify-center rounded-xl bg-slate-200 px-5 py-3 text-sm font-semibold text-slate-700 hover:bg-slate-300 transition">
                    Cancel
                </a>

                <button id="submitBtn" type="submit"
                        class="inline-flex justify-center rounded-xl bg-blue-600 px-6 py-3 text-sm font-semibold text-white shadow-md hover:bg-blue-700 transition">
                    Submit Incident Report
                </button>
            </div>
        </form>
    </div>

</div>

<script>
document.getElementById('incidentForm').addEventListener('submit', function () {
    const btn = document.getElementById('submitBtn');
    btn.innerHTML = 'Submitting...';
    btn.disabled = true;
});
</script>

@endsection