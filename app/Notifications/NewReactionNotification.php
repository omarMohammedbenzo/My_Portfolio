<?php

namespace App\Notifications;

use App\Models\Reaction;
use App\Notifications\Channels\TelegramChannel;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewReactionNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(public Reaction $reaction) {}

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
            ->subject('❤️ New love on your portfolio!')
            ->line("Someone hearted your page: **{$this->reaction->page_url}**")
            ->line('Country: ' . ($this->reaction->country ?? 'Unknown'))
            ->line('Time: ' . $this->reaction->created_at->toDateTimeString());
    }

    public function toTelegram(mixed $notifiable): string
    {
        return "❤️ New love on <b>{$this->reaction->page_url}</b>\n"
             . "🌍 " . ($this->reaction->country ?? 'Unknown') . "\n"
             . "🕐 " . $this->reaction->created_at->toDateTimeString();
    }
}
