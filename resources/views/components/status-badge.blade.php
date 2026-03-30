@php
    $classes = match($status) {
        'New' => 'bg-blue-100 text-blue-700',
        'Assigned' => 'bg-purple-100 text-purple-700',
        'In Review' => 'bg-purple-200 text-purple-800',
        'Rejected' => 'bg-red-100 text-red-700',
        'Resolved' => 'bg-yellow-100 text-yellow-700',
        'Closed' => 'bg-green-100 text-green-700',
        default => 'bg-slate-100 text-slate-700',
    };
@endphp

<span class="inline-flex rounded-full px-3 py-1 text-xs font-semibold {{ $classes }}">
    {{ $status }}
</span>