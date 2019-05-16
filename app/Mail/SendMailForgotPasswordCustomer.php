<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\User;

class SendMailForgotPasswordCustomer extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    protected $token;
    
    protected $user;


    public function __construct(User $user, $token)
    {
        $this->token = $token;

        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {   
        $fullname = $this->user->customer->name;
        
        $domain = env('APP_URL').'/auth/customer/confirm-forgot-password?token='.$this->token;

        return $this->subject('Mail From Holipic')
                    ->view('mails.mail-forgot-password-customer',compact('fullname', 'domain'));
    }
}
