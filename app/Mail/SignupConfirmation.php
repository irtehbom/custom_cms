<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class WelcomeEmail extends Mailable
{
    use Queueable, SerializesModels;
    
    public $signupConfirmation;
    
    public function __construct($signupConfirmation)
    {
         $this->signup_confirmation = $signupConfirmation;
    }

    public function build()
    {
        
        return $this->from('campaign@wildshark.co.uk')
                    ->view('mails.signup_confirmation')
                    ->with(
                      [
                            'variables' => $this->signup_confirmation
                      ]); 
    }
}
