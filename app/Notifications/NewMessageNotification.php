<?php

namespace App\Notifications;

use App\Models\Message;
use App\Notifications\Channels\TelegramChannel;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewMessageNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(public Message $message) {}

    public function via(mixed $notifiable): array
    {
        $channels = ['mail'];
        if (config('services.telegram.enabled')) {
            $channels[] = TelegramChannel::class;
        }
        return $channels;
    }

    public function toMail(mixed $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject("📩 New contact message: {$this->message->subject}")
            ->line("From: **{$this->message->name}** ({$this->message->email})")
            ->line("Subject: {$this->message->subject}")
            ->line($this->message->body);
    }

    public function toTelegram(mixed $notifiable): string
    {
        return "📩 New message from <b>{$this->message->name}</b>\n"
             . "📧 {$this->message->email}\n"
             . "📌 {$this->message->subject}\n"
             . "💬 " . substr($this->message->body, 0, 200);
    }
}
