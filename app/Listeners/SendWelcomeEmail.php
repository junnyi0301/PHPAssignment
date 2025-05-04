<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Mail;
use App\Mail\WelcomeMail;

class SendWelcomeEmail
{
    public function handle(Registered $event)
    {
        \Log::info('🎉 Sending welcome email to ' . $event->user->email);
        Mail::to($event->user->email)->send(new WelcomeMail($event->user));
    }
}