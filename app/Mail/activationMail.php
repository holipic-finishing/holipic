<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class activationMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user)
    {
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $fullname =  $this->user['fullname'];
        $access_token = $this->user['access_token'];
        $domain = 'http://127.0.0.1:8000'.'/users/activation?access_token=';
        $urlActivation = $domain.$access_token;

  
        return $this->subject('Mail From Holipic')
                    ->view('mails.activationMail',compact('fullname', 'urlActivation'));
    }
}
