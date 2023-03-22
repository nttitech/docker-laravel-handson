<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Http\Controllers\Controller;
use App\Mail\MailVerification as MailVerificationMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use \Symfony\Component\HttpFoundation\Response;

define('ACTIVATE_SALT', '123456');

class RegisterController extends Controller
{
    public function temp_register(Request $request)
    {
        // バリデーション
        $validator = Validator::make($request->all(), [
            'name' =>['required'],
            'email' => ['required', 'email'],
            'password' => ['required']
        ]);

        if ($validator->fails()) {
            return response()->json($validator->messages(), Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        //メールアドレスが使われているかのチェック
        if(User :: where('email',$request->input('email')) -> exists()){
            return 'This email address is already in use';
        }

        //ユーザー仮登録
        $user = new User();
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->password = Hash::make($request->input('password'));
        $user->mail_authentication = self::createActivationCode($user->email);
        $user->save();
        self::sendMailVerification($user);
        return 'Temporary registration completed';
    }

    private function createActivationCode($mail)
    {
        return hash_hmac('sha256', $mail, ACTIVATE_SALT);
    }

    private function sendMailVerification($user)
    {
        Mail::to($user->email)
            ->send(new MailVerificationMail($user->mail_authentication));

    }
}
