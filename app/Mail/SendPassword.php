<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendPassword extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */

    public $name;
    public $password;
    public $email;
    
    public function __construct($name,$email,$password)
    {
        $this->name = $name;
        $this->password = $password;
        $this->email = $email;
    }
    

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    { 
        $data['name'] =  $this->name;
        $data['password'] = $this->password;
        $data['email'] = $this->email;
        return $this->view('mail.sendpassword',$data);
    }
}
