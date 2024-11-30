<?php

namespace App\Listeners;

use App\Events\SendUserEmail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Mail;
use App\Mail\SendPassword;

class SendUserEmailPassword
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  SendUserEmail  $event
     * @return void
     */
    public function handle(SendUserEmail $event)
    {
        Mail::to($event->email)->send(new SendPassword($event->name,$event->email,$event->password));
    }
}
