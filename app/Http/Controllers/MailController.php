<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Mail\WelcomeEmail;
use App\Mail\MessageNotification;
use App\Mail\TimeNotification;
use App\Mail\FileNotification;
use Illuminate\Support\Facades\Mail;

class MailController extends Controller {

    public function sendWelcome($receiver_email, $receiver_name, $create_password_url) {
        $messageVars = new \stdClass();
        $messageVars->sender = 'Wildshark';
        $messageVars->receiver = $receiver_name;
        $messageVars->email = $receiver_email;
        $messageVars->url = $create_password_url;

        if ($messageVars->email != $user->email) {
            $this->mail->sendMessageNotification($userMail->email, $userMail->name, $user->name, '/dashboard/project/' . $project->id . '/messages/' . $thread->id);
        }

        foreach ($this->users->all() as $wildshark_users) {
            $role = $user->getRoleName($wildshark_users);
            if ($role == 'Consultant' || $role == 'Administrator') {
                $this->mail->sendMessageNotification($wildshark_users->email, $wildshark_users->name, $user->name, '/dashboard/project/' . $project->id . '/messages/' . $thread->id);
            }
        }

        Mail::to($receiver_email)->send(new WelcomeEmail($messageVars));
    }

    public function sendSignupConfirmation($receiver_email, $receiver_name) {
        $messageVars = new \stdClass();
        $messageVars->sender = 'Wildshark';
        $messageVars->receiver = $receiver_name;
        $messageVars->email = $receiver_email;

        Mail::to($receiver_email)->send(new SignupConfirmation($messageVars));
    }

    public function sendMessageNotification($receiver_email, $receiver_name, $sender_name, $url) {
        $messageVars = new \stdClass();
        $messageVars->sender = $sender_name;
        $messageVars->receiver = $receiver_name;
        $messageVars->email = $receiver_email;
        $messageVars->url = url($url);

        Mail::to($receiver_email)->send(new MessageNotification($messageVars));
    }

    public function sendTimeNotification($receiver_email, $receiver_name, $receiver_password) {
        $messageVars = new \stdClass();
        $messageVars->sender = 'Wildshark';
        $messageVars->receiver = $receiver_name;
        $messageVars->email = $receiver_email;
        $messageVars->password = $receiver_password;
        $messageVars->url = url('/dashboard');

        Mail::to($receiver_email)->send(new TimeNotification($messageVars));
    }

    public function sendFileNotification($receiver_email, $receiver_name, $sender_name) {
        $messageVars = new \stdClass();
        $messageVars->sender = $sender_name;
        $messageVars->receiver = $receiver_name;
        $messageVars->email = $receiver_email;
        $messageVars->url = url('/dashboard');

        Mail::to($receiver_email)->send(new FileNotification($messageVars));
    }

}
