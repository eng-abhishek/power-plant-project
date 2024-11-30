<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendSchduledMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */

    public $name;
    public $scheduled_power;

    public function __construct($name,$scheduled_power)
    {
      $this->name = $name;
      $this->scheduled_power = $scheduled_power;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $data['name'] = $this->name;
        $data['scheduled_power'] = $this->scheduled_power;
        return $this->view('view.schduleNotification',$data);
    }
}
