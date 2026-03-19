<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class RegistrationApproved extends Notification implements ShouldQueue
{
    use Queueable;

    protected string $roleName;

    public function __construct(string $roleName)
    {
        $this->roleName = $roleName;
    }

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $loginUrl = url('/login');

        return (new MailMessage)
            ->subject('Your registration has been approved')
            ->greeting('Hello ' . ($notifiable->name ?? 'there') . ',')
            ->line('Your registration as **' . $this->roleName . '** has been approved.')
            ->line('You can now log in to your account.')
            ->action('Log in', $loginUrl)
            ->line('Thank you for joining us.');
    }
}
