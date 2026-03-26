<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ReporterStatusUpdatedNotification extends Notification
{
    use Queueable;

    public $incident;
    public $statusName;

    public function __construct($incident, $statusName)
    {
        $this->incident = $incident;
        $this->statusName = $statusName;
    }

    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $url = route('incidents.show', $this->incident);

        return (new MailMessage)
            ->subject('SIRMS Notification: Incident Status Updated')
            ->view('emails.reporter-status-updated', [
                'notifiable' => $notifiable,
                'incident' => $this->incident,
                'statusName' => $this->statusName,
                'url' => $url,
                'updatedAt' => now()->format('d M Y, h:i A'),
            ]);
    }

    public function toArray(object $notifiable): array
    {
        return [
            'incident_id' => $this->incident->id,
            'status' => $this->statusName,
            'message' => 'Your reported incident status has been updated to ' . $this->statusName . '.',
        ];
    }
}