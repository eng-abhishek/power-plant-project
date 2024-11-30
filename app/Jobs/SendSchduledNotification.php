<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Mail;
use App\Mail\SendSchduledMail;

class SendSchduledNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public $email;
    public $scheduled_power;
    public $name;

    public function __construct($email,$name,$scheduled_power)
    {
        $this->email = $email;
        $this->name = $name;
        $this->scheduled_power = $scheduled_power;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Mail::to($this->email)->send( new SendSchduledMail($this->name,$this->scheduled_power));
    }
}
