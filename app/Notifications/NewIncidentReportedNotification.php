<?php

namespace App\Notifications;

use App\Models\Incident;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class NewIncidentReportedNotification extends Notification
{
    use Queueable;

    protected $incident;

    public function __construct(Incident $incident)
    {
        $this->incident = $incident;
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        return [
            'incident_id' => $this->incident->id,
            'title' => 'New Incident Reported',
            'message' => 'A new incident "' . $this->incident->title . '" has been submitted by ' . ($this->incident->reporter->name ?? 'a reporter') . '.',
        ];
    }
}