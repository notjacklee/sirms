<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Notifications\Messages\MailMessage;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        VerifyEmail::toMailUsing(function (object $notifiable, string $url) {
            return (new MailMessage)
                ->subject('SIRMS Email Verification')
                ->greeting('Hello ' . ($notifiable->name ?? 'User') . '!')
                ->line('Welcome to the Security Incident Reporting and Management System (SIRMS).')
                ->line('Please verify your email address before accessing the platform.')
                ->action('Verify My Email', $url)
                ->line('This verification step helps protect your account and ensures secure access to the system.')
                ->line('If you did not create a SIRMS account, no further action is required.')
                ->salutation('Regards, SIRMS Security Team');
        });
    }
}