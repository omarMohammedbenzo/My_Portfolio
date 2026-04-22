<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Http\Requests\Public\ContactRequest;
use App\Jobs\SendContactEmail;
use App\Models\Message;
use App\Models\PersonalInfo;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class ContactController extends Controller
{
    public function index(): Response
    {
        $info = PersonalInfo::main();

        return Inertia::render('Contact', [
            'personalInfo' => [
                'email'    => $info->email,
                'phone'    => $info->phone,
                'location' => $info->getTranslations('location'),
                'socials'  => $info->socials,
            ],
        ]);
    }

    public function store(ContactRequest $request): RedirectResponse
    {
        $message = Message::create([
            'name'       => $request->name,
            'email'      => $request->email,
            'subject'    => $request->subject,
            'body'       => $request->message,
            'ip'         => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        SendContactEmail::dispatch($message)->onQueue('default');

        return back()->with('success', __('messages.contact_sent'));
    }
}
