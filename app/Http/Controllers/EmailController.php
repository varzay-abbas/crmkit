<?php

namespace App\Http\Controllers;

use App\Mail\SendEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class EmailController extends Controller
{
    //
    public function sendEmail()
    {
        $reveiverEmailAddress = "aus234@gmail.com";
        Mail::to($reveiverEmailAddress)->send(new SendEmail);
        return "Email has been sent successfully";
    }
}