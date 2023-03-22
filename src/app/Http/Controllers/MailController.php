<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendTestMail;
use App\Mail\TestMail;
use App\Models\User;
use App\Mail\VerificationMail;
class MailController extends Controller
{
    public function send(Request $request)
    {
        $user = new User();

        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->password = bcrypt($request->input('password'));
       // Mail::send(new TestMail($name, $email));
       //Mail::to('takahironakagawa2015@gmail.com')->send(new TestMail($name,$email));
       //Mail::send(new SendTestMail());
        Mail::to($user->email)->send(new VerificationMail($user));

    }
}
