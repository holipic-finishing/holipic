<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ActivationMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    protected $user;
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
        $domain = \Config::get('testHolipic.url').'users/activation?access_token=';
        $urlActivation = $domain.$access_token;

        return $this->subject('Mail From Holipic')
                    ->view('mails.activation-mail',compact('fullname', 'urlActivation'));
    }
}
