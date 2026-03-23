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
        return (new MailMessage)
            ->subject('Incident Status Updated')
            ->greeting('Hello ' . $notifiable->name . '!')
            ->line('The status of your reported incident has been updated.')
            ->line('Incident Title: ' . $this->incident->title)
            ->line('New Status: ' . $this->statusName)
            ->action('View Incident', route('incidents.show', $this->incident))
            ->line('Thank you for using SIRMS.');
    }

    public function toArray(object $notifiable): array
    {
        return [
            'incident_id' => $this->incident->id,
            'status' => $this->statusName,
            'message' => 'Your incident status has been updated.',
        ];
    }
}