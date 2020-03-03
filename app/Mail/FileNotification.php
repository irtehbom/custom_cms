<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class FileNotification extends Mailable
{
    use Queueable, SerializesModels;
    
    public $FileNotification;
    
    public function __construct($fileNotification)
    {
         $this->file_notification = $fileNotification;
    }

    public function build()
    {
        return $this->from('campaign@wildshark.co.uk')
                    ->view('mails.file_notification')
                    ->text('mails.file_notification_plain')->with(
                      [
                            'variables' => $this->file_notification
                      ]); 
    }
}
