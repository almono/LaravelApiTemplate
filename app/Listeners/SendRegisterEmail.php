<?php

namespace App\Listeners;

use App\Events\UserRegistered;
use App\Mail\RegistrationEmail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendRegisterEmail
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(UserRegistered $event): void
    {
        Log::info('UserRegistered Event Triggered');
        Mail::to($event->user->email)->send(new RegistrationEmail($event->user));
    }
}
