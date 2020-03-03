<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class WelcomeEmail extends Mailable
{
    use Queueable, SerializesModels;
    
    public $welcomeEmail;
    
    public function __construct($welcomeEmail)
    {
         $this->welcome_email = $welcomeEmail;
    }

    public function build()
    {
        
        return $this->from('campaign@wildshark.co.uk')
                    ->view('mails.welcome_email')
                    ->text('mails.welcome_email_plain')->with(
                      [
                            'variables' => $this->welcome_email
                      ]); 
    }
}
