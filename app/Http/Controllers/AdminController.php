<?php

namespace App\Http\Controllers;

use App\Models\AuditLog;
use App\Models\Incident;
use App\Models\Status;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\StreamedResponse;

class AdminController extends Controller
{
    public function index()
    {
        $totalIncidents = Incident::count();

        $officers = User::where('role', 'officer')
            ->orderBy('name')
            ->get();

        $byStatus = Incident::select('status_id', DB::raw('COUNT(*) as count'))
            ->groupBy('status_id')
            ->pluck('count', 'status_id');

        $bySeverity = Incident::select('severity', DB::raw('COUNT(*) as count'))
            ->groupBy('severity')
            ->pluck('count', 'severity')
            ->toArray();

        $statuses = Status::orderBy('id')->pluck('name', 'id');

        $statusCounts = [];
        foreach ($statuses as $id => $name) {
            $statusCounts[$name] = $byStatus[$id] ?? 0;
        }

        $recent = Incident::with(['reporter', 'status', 'assignedTo'])
            ->latest()
            ->paginate(10);

        return view('admin.dashboard', compact(
            'totalIncidents',
            'officers',
            'statusCounts',
            'bySeverity',
            'recent'
        ));
    }

    public function auditLogs()
    {
        $logs = AuditLog::with(['user', 'incident'])
            ->latest()
            ->paginate(15);

        return view('admin.audit-logs', compact('logs'));
    }

    public function exportCsv(): StreamedResponse
    {
        $fileName = 'sirms_incidents_' . now()->format('Ymd_His') . '.csv';

        $incidents = Incident::with(['reporter', 'status', 'assignedTo'])
            ->orderBy('created_at', 'desc')
            ->get();

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename={$fileName}",
        ];

        $callback = function () use ($incidents) {
            $file = fopen('php://output', 'w');

            fputcsv($file, [
                'Incident ID',
                'Title',
                'Category',
                'Severity',
                'Status',
                'Reporter',
                'Assigned Officer',
                'Created Date',
            ]);

            foreach ($incidents as $incident) {
                fputcsv($file, [
                    $incident->id,
                    $incident->title,
                    $incident->category,
                    $incident->severity,
                    $incident->status->name ?? '-',
                    $incident->reporter->name ?? '-',
                    $incident->assignedTo->name ?? 'Not Assigned',
                    optional($incident->created_at)->format('d M Y H:i'),
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function exportPdf()
    {
        $incidents = Incident::with(['reporter', 'status', 'assignedTo'])
            ->orderBy('created_at', 'desc')
            ->get();

        $pdf = Pdf::loadView('admin.reports.incidents-pdf', compact('incidents'))
            ->setPaper('a4', 'landscape');

        return $pdf->download('sirms_incidents_' . now()->format('Ymd_His') . '.pdf');
    }
}