<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Message;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class MessageController extends Controller
{
    public function index(): Response
    {
        $messages = Message::latest()->paginate(20)->through(fn ($m) => [
            'id'         => $m->id,
            'name'       => $m->name,
            'email'      => $m->email,
            'subject'    => $m->subject,
            'body'       => $m->body,
            'read_at'    => $m->read_at?->toDateTimeString(),
            'replied_at' => $m->replied_at?->toDateTimeString(),
            'created_at' => $m->created_at->toDateTimeString(),
        ]);

        return Inertia::render('Dashboard/Messages/Index', [
            'messages'       => $messages,
            'unread_count'   => Message::unread()->count(),
        ]);
    }

    public function markRead(Message $message): RedirectResponse
    {
        $message->markAsRead();
        return back()->with('success', 'Marked as read.');
    }

    public function destroy(Message $message): RedirectResponse
    {
        $message->delete();
        return back()->with('success', 'Message deleted.');
    }
}
