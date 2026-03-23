@extends('layouts.app')

@section('page-title', 'Audit Logs')

@section('content')

<div class="space-y-8">

    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h1 class="text-3xl font-bold text-slate-900">Audit Logs</h1>
            <p class="text-slate-500 mt-1">
                Review system activities related to incident creation, assignment, status updates, and investigation notes.
            </p>
        </div>

        <a href="{{ route('admin.index') }}"
           class="inline-flex items-center rounded-xl border border-slate-300 bg-white px-5 py-3 text-sm font-semibold text-slate-700 shadow-sm hover:bg-slate-50 transition">
            Back to Dashboard
        </a>
    </div>

    @if(session('success'))
        <div class="rounded-2xl border border-green-200 bg-green-50 px-5 py-4 text-sm font-medium text-green-700 flex items-center gap-2">
            ✓ {{ session('success') }}
        </div>
    @endif

    <div class="rounded-2xl bg-white border border-slate-200 shadow-sm overflow-hidden">
        <div class="px-6 py-5 border-b border-slate-200">
            <h3 class="text-lg font-bold text-slate-900">System Activity Log</h3>
            <p class="text-sm text-slate-500 mt-1">
                Chronological record of actions performed by users in the system.
            </p>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead class="bg-slate-50 border-b border-slate-200">
                    <tr class="text-left">
                        <th class="px-6 py-4 font-semibold text-slate-600">Date & Time</th>
                        <th class="px-6 py-4 font-semibold text-slate-600">User</th>
                        <th class="px-6 py-4 font-semibold text-slate-600">Incident</th>
                        <th class="px-6 py-4 font-semibold text-slate-600">Action</th>
                        <th class="px-6 py-4 font-semibold text-slate-600">Details</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-slate-200">
                    @forelse($logs as $log)
                        <tr class="hover:bg-slate-50 transition">
                            <td class="px-6 py-4 text-slate-600 whitespace-nowrap">
                                {{ $log->created_at->format('d M Y H:i') }}
                            </td>

                            <td class="px-6 py-4 text-slate-800 font-medium">
                                {{ $log->user->name ?? 'System' }}
                            </td>

                            <td class="px-6 py-4">
                                @if($log->incident)
                                    <a href="{{ route('incidents.show', $log->incident) }}"
                                       class="font-semibold text-blue-600 hover:text-blue-700 hover:underline">
                                        #{{ $log->incident->id }} — {{ \Illuminate\Support\Str::limit($log->incident->title, 35) }}
                                    </a>
                                @else
                                    <span class="text-slate-500">-</span>
                                @endif
                            </td>

                            <td class="px-6 py-4">
                                <span class="inline-flex rounded-full bg-slate-100 px-3 py-1 text-xs font-semibold text-slate-700">
                                    {{ $log->action_type }}
                                </span>
                            </td>

                            <td class="px-6 py-4 text-slate-600">
                                {{ $log->details }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-14 text-center text-slate-500">
                                No audit logs recorded yet.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="px-6 py-4 border-t border-slate-200">
            {{ $logs->links() }}
        </div>
    </div>

</div>

@endsection