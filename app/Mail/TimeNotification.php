<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class TimeNotification extends Mailable
{
    use Queueable, SerializesModels;
    
    public $timeNotification;
    
    public function __construct($timeNotification)
    {
         $this->time_notification = $timeNotification;
    }

    public function build()
    {
        return $this->from('campaign@wildshark.co.uk')
                    ->view('mails.time_notification')
                    ->text('mails.time_notification_plain')->with(
                      [
                            'variables' => $this->time_notification
                      ]); 
    }
}
