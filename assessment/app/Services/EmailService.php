<?php

namespace App\Services;

use App\Mail\UserCreated;
use App\Notifications\SendNotification;
use Illuminate\Support\Facades\Mail;

class EmailService
{

    public function UserCreated($user, $type = null)
    {
        try {
            $subject = ($type != null) ?  $type : "Email Confirmation";
            Mail::to($user)->send(new UserCreated($user, $subject));
            return true;
        } catch (\Throwable $th) {
            return $th;
        }
    }

    public function SendNotification($user, $subject, $message)
    {
        try {
            $user->notify(new SendNotification($subject, $message));
            return true;
        } catch (\Throwable $th) {
            return $th;
        }
    }
}
