<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OfficerAssignedNotification extends Notification
{
    use Queueable;

    public $incident;

    public function __construct($incident)
    {
        $this->incident = $incident;
    }

    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('New Incident Assigned')
            ->greeting('Hello ' . $notifiable->name . '!')
            ->line('A new incident has been assigned to you.')
            ->line('Incident Title: ' . $this->incident->title)
            ->line('Severity: ' . $this->incident->severity)
            ->action('View Incident', route('incidents.show', $this->incident))
            ->line('Please begin investigation as soon as possible.');
    }

    public function toArray(object $notifiable): array
    {
        return [
            'incident_id' => $this->incident->id,
            'title' => $this->incident->title,
            'message' => 'A new incident has been assigned to you.',
        ];
    }
}