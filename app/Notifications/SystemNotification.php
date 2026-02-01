<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class SystemNotification extends Notification
{
    use Queueable;

    public function __construct(
        public string $title,
        public string $message,
        public string $type = 'info', // info, success, warning, danger
        public ?string $url = null
    ) {}

    public function via(object $notifiable): array
    {
        // Kita simpan ke database dulu sesuai rencana kita
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        // Data ini yang bakal kesimpen di kolom 'data' di tabel notifications
        return [
            'title'   => $this->title,
            'message' => $this->message,
            'type'    => $this->type,
            'url'     => $this->url,
        ];
    }
}