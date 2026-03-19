<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class RegistrationRejected extends Notification
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
        return (new MailMessage)
            ->subject('Your registration was not approved')
            ->greeting('Hello ' . ($notifiable->name ?? 'there') . ',')
            ->line('Unfortunately, your registration as **'.$this->roleName.'** has been rejected.')
            ->line('If you believe this was a mistake, please contact support.')
            ->line('Thank you.');
    }
}
