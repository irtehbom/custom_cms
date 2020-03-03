<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class MessageNotification extends Mailable
{
    use Queueable, SerializesModels;
    
    public $messageNotification;
    
    public function __construct($messageNotification)
    {
         $this->message_notification = $messageNotification;
    }

    public function build()
    {
        return $this->from('campaign@wildshark.co.uk')
                    ->view('mails.message_notification')
                    ->text('mails.message_notification_plain')->with(
                      [
                            'variables' => $this->message_notification
                      ]); 
    }
}
