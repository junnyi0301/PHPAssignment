<?php

namespace App\Listeners;

use App\Events\UserDeleted;
use App\Mail\GoodbyeMail;
use Illuminate\Support\Facades\Mail;

class SendGoodbyeMail
{
    /**
     * Handle the event (synchronously)
     */
    public function handle(UserDeleted $event)
    {
        Mail::to($event->user->email)
            ->send(new GoodbyeMail($event->user));
    }
}