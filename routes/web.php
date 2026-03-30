<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\IncidentController;
use App\Http\Controllers\AdminController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    $user = auth()->user();

    if ($user->role === 'admin') {
        return redirect()->route('admin.index');
    }

    if ($user->role === 'officer') {
        return redirect()->route('incidents.assigned');
    }

    return redirect()->route('incidents.index');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::post('/notifications/{notification}/read', function ($notification) {
        $userNotification = auth()->user()
            ->notifications()
            ->where('id', $notification)
            ->firstOrFail();

        $userNotification->markAsRead();

        if (isset($userNotification->data['incident_id'])) {
            return redirect()->route('incidents.show', $userNotification->data['incident_id']);
        }

        return back();
    })->name('notifications.read');

    Route::post('/notifications/read-all', function () {
        auth()->user()->unreadNotifications->markAsRead();
        return back()->with('success', 'All notifications marked as read.');
    })->name('notifications.readAll');
});

/*
|--------------------------------------------------------------------------
| Reporter Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'verified', 'role:reporter'])->group(function () {
    Route::get('/incidents/create', [IncidentController::class, 'create'])->name('incidents.create');
    Route::post('/incidents', [IncidentController::class, 'store'])->name('incidents.store');

    // Reporter resubmit routes
    Route::get('/incidents/{incident}/edit', [IncidentController::class, 'edit'])->name('incidents.edit');
    Route::put('/incidents/{incident}', [IncidentController::class, 'update'])->name('incidents.update');
});

/*
|--------------------------------------------------------------------------
| Shared Incident Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/incidents', [IncidentController::class, 'index'])->name('incidents.index');

    Route::get('/attachments/{attachment}', [IncidentController::class, 'viewAttachment'])
        ->name('attachments.view');

    Route::get('/incidents/{incident}', [IncidentController::class, 'show'])->name('incidents.show');
    Route::post('/incidents/{incident}/comment', [IncidentController::class, 'comment'])->name('incidents.comment');
});

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'verified', 'role:admin'])->group(function () {
    Route::get('/admin', [AdminController::class, 'index'])
        ->name('admin.index');

    Route::post('/incidents/{incident}/assign', [IncidentController::class, 'assign'])
        ->name('incidents.assign');

    Route::get('/admin/audit-logs', [AdminController::class, 'auditLogs'])
        ->name('admin.audit-logs');

    Route::get('/admin/reports/incidents/csv', [AdminController::class, 'exportCsv'])
        ->name('admin.reports.csv');

    Route::get('/admin/reports/incidents/pdf', [AdminController::class, 'exportPdf'])
        ->name('admin.reports.pdf');
    Route::put('/incidents/{incident}/close', [IncidentController::class, 'close'])
    ->name('incidents.close')
    ->middleware(['auth', 'role:admin']);
});

/*
|--------------------------------------------------------------------------
| Officer Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'verified', 'role:officer'])->group(function () {
    Route::get('/assigned-incidents', [IncidentController::class, 'assigned'])
        ->name('incidents.assigned');

    Route::post('/incidents/{incident}/status', [IncidentController::class, 'updateStatus'])
        ->name('incidents.status');
});

require __DIR__.'/auth.php';