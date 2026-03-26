<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Models\Incident;
use App\Models\Status;
use App\Models\AuditLog;
use App\Models\User;
use App\Models\Comment;
use App\Models\Attachment;
use App\Notifications\OfficerAssignedNotification;
use App\Notifications\ReporterStatusUpdatedNotification;
use App\Notifications\NewIncidentReportedNotification;

class IncidentController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();

        $query = Incident::with('status', 'reporter');

        if ($user->role !== 'admin') {
            $query->where('reporter_id', $user->id);
        }

        if ($request->filled('search')) {
            $search = trim($request->search);

            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('category', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        if ($request->filled('severity')) {
            $query->where('severity', $request->severity);
        }

        if ($request->filled('status')) {
            $query->whereHas('status', function ($q) use ($request) {
                $q->where('name', $request->status);
            });
        }

        $filteredIncidents = (clone $query)->get();

        $stats = [
            'total' => $filteredIncidents->count(),
            'high' => $filteredIncidents->where('severity', 'High')->count(),
            'medium' => $filteredIncidents->where('severity', 'Medium')->count(),
            'low' => $filteredIncidents->where('severity', 'Low')->count(),
        ];

        $incidents = $query->orderBy('created_at', 'desc')
            ->paginate(10)
            ->withQueryString();

        $statuses = Status::orderBy('name')->get();

        return view('incidents.index', compact('incidents', 'statuses', 'stats'));
    }

    public function create()
    {
        return view('incidents.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:200|unique:incidents,title',
            'category' => 'required|string|max:100',
            'severity' => 'required|string',
            'description' => 'required|string',
            'attachment' => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx|max:5120',
        ]);

        return DB::transaction(function () use ($request, $data) {
            $statusNew = Status::firstOrCreate(['name' => 'New']);

            $incident = Incident::create([
                'title' => $data['title'],
                'category' => $data['category'],
                'severity' => $data['severity'],
                'description' => $data['description'],
                'status_id' => $statusNew->id,
                'reporter_id' => auth()->id(),
            ]);

            $incident->load('reporter');

            User::where('role', 'admin')->each(function (User $admin) use ($incident) {
                $admin->notify(new NewIncidentReportedNotification($incident));
            });

            if ($request->hasFile('attachment')) {
                $file = $request->file('attachment');
                $path = $file->store('attachments', 'public');

                Attachment::create([
                    'incident_id' => $incident->id,
                    'filename' => $file->getClientOriginalName(),
                    'filepath' => $path,
                    'uploaded_by' => auth()->id(),
                    'uploaded_at' => now(),
                ]);

                AuditLog::create([
                    'incident_id' => $incident->id,
                    'user_id' => auth()->id(),
                    'action_type' => 'Attachment Uploaded',
                    'details' => 'Uploaded attachment: ' . $file->getClientOriginalName(),
                ]);
            }

            AuditLog::create([
                'incident_id' => $incident->id,
                'user_id' => auth()->id(),
                'action_type' => 'Created',
                'details' => 'Incident created',
            ]);

            return redirect()->route('incidents.index')
                ->with('success', 'Incident submitted.');
        });
    }

    public function show(Incident $incident)
    {
        $user = auth()->user();

        if (
            $user->role !== 'admin' &&
            $incident->reporter_id !== $user->id &&
            $incident->assigned_to !== $user->id
        ) {
            abort(403);
        }

        $incident->load(
            'comments.user',
            'attachments',
            'status',
            'reporter',
            'assignedTo',
            'auditLogs.user'
        );

        return view('incidents.show', compact('incident'));
    }

    public function assigned()
    {
        $user = auth()->user();

        $incidents = Incident::where('assigned_to', $user->id)
            ->with('status', 'reporter')
            ->orderBy('created_at', 'desc')
            ->get();

        $statuses = Status::all();

        return view('incidents.assigned', compact('incidents', 'statuses'));
    }

    public function assign(Request $request, Incident $incident)
    {
        if (auth()->user()->role !== 'admin') {
            abort(403);
        }

        $request->validate([
            'officer_id' => 'required|exists:users,id',
        ]);

        if ($incident->assigned_to) {
            return back()->with('error', 'This incident has already been assigned.');
        }

        $assignedStatus = Status::where('name', 'Assigned')->firstOrFail();

        $incident->assigned_to = $request->officer_id;
        $incident->status_id = $assignedStatus->id;
        $incident->save();

        $officer = User::findOrFail($request->officer_id);

        AuditLog::create([
            'incident_id' => $incident->id,
            'user_id' => auth()->id(),
            'action_type' => 'Assigned',
            'old_value' => 'New',
            'new_value' => 'Assigned',
            'details' => 'Assigned to ' . $officer->name . ' and status changed to Assigned',
        ]);

        $officer->notify(new OfficerAssignedNotification($incident));

        if ($incident->reporter) {
            $incident->reporter->notify(
                new ReporterStatusUpdatedNotification($incident, 'Assigned')
            );
        }

        return back()->with('success', 'Officer assigned and status updated to Assigned.');
    }

    public function updateStatus(Request $request, Incident $incident)
    {
        $request->validate([
            'status_id' => 'required|exists:statuses,id',
        ]);

        $user = auth()->user();

        if ($user->role === 'officer' && $incident->assigned_to != $user->id) {
            abort(403);
        }

        $newStatus = Status::findOrFail($request->status_id);
        $currentStatus = $incident->status;

        $allowedTransitions = [
            'New' => ['Assigned', 'Invalid'],
            'Assigned' => ['In Review'],
            'In Review' => ['Resolved', 'Invalid'],
            'Resolved' => ['Closed'],
            'Closed' => [],
            'Invalid' => [],
        ];

        $currentName = trim($currentStatus->name ?? '');
        $newName = trim($newStatus->name ?? '');

        if (
            $currentName &&
            $newName &&
            isset($allowedTransitions[$currentName]) &&
            !in_array($newName, $allowedTransitions[$currentName])
        ) {
            return back()->with('error', "Invalid status transition: {$currentName} → {$newName}");
        }

        $oldValue = $currentName;

        $incident->status_id = $newStatus->id;
        $incident->save();

        AuditLog::create([
            'incident_id' => $incident->id,
            'user_id' => auth()->id(),
            'action_type' => 'Status Updated',
            'old_value' => $oldValue,
            'new_value' => $newName,
            'details' => 'Changed status from ' . $oldValue . ' to ' . $newName,
        ]);

        if ($incident->reporter) {
            $incident->reporter->notify(
                new ReporterStatusUpdatedNotification($incident, $newName)
            );
        }

        return back()->with('success', 'Status updated.');
    }

    public function comment(Request $request, Incident $incident)
    {
        $request->validate([
            'comment' => 'required|string|max:2000',
        ]);

        $user = auth()->user();

        if (
            $user->role !== 'admin' &&
            !($user->role === 'officer' && $incident->assigned_to == $user->id) &&
            !($user->role === 'reporter' && $incident->reporter_id == $user->id)
        ) {
            abort(403);
        }

        Comment::create([
            'incident_id' => $incident->id,
            'user_id' => $user->id,
            'message' => $request->comment,
        ]);

        AuditLog::create([
            'incident_id' => $incident->id,
            'user_id' => $user->id,
            'action_type' => 'Comment Added',
            'details' => 'Comment added to incident',
        ]);

        return back()->with('success', 'Comment added successfully.');
    }

    public function viewAttachment(Attachment $attachment)
    {
        $user = auth()->user();
        $incident = $attachment->incident;

        if (
            !$incident ||
            (
                $user->role !== 'admin' &&
                $incident->reporter_id !== $user->id &&
                $incident->assigned_to !== $user->id
            )
        ) {
            abort(403);
        }

        if (!Storage::disk('public')->exists($attachment->filepath)) {
            abort(404, 'File not found.');
        }

        AuditLog::create([
            'incident_id' => $incident->id,
            'user_id' => $user->id,
            'action_type' => 'Attachment Viewed',
            'details' => 'Viewed attachment: ' . $attachment->filename,
        ]);

        $path = Storage::disk('public')->path($attachment->filepath);

        return response()->download($path, $attachment->filename);
    }
}