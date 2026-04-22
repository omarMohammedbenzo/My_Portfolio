<?php

namespace App\Jobs;

use App\Models\Message;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendContactEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(public Message $message) {}

    public function handle(): void
    {
        $adminEmail = config('mail.from.address');

        Mail::send('emails.contact', ['message' => $this->message], function ($m) use ($adminEmail) {
            $m->to($adminEmail)
              ->replyTo($this->message->email, $this->message->name)
              ->subject("New message: {$this->message->subject}");
        });
    }
}
