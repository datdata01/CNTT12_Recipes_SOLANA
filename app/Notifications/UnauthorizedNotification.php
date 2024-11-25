<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class UnauthorizedNotification extends Notification
{
    use Queueable;

    private $message;

    public function __construct(string $message)
    {
        $this->message = $message;
    }

    public function via($notifiable)
    {
        return ['database', 'mail']; // Hoặc thêm 'slack' nếu cần
    }

    public function toMail($notifiable)
    {
        return (new \Illuminate\Notifications\Messages\MailMessage)
            ->subject('Unauthorized Access Attempt')
            ->line($this->message)
            ->action('Contact Support', url('/contact'));
    }

    public function toArray($notifiable)
    {
        return [
            'message' => $this->message,
        ];
    }
}
