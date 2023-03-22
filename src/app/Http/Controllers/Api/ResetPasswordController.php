<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Http\Controllers\Controller;
use App\Mail\ResetURL;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use \Symfony\Component\HttpFoundation\Response;



class ResetPasswordController extends Controller
{
    public function reset_mail(Request $request)
    {
        // バリデーション
        $validator = Validator::make($request->all(), [
            'name' => ['required'],
            'email' => ['required', 'email'],
        ]);

        if ($validator->fails()) {
            return response()->json($validator->messages(), Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        $user = User::where('name', $request->input('name'))
            ->where('email',$request->input('email'))
            ->first();

        if (!$user) {
            return 'Your name or email address is incorrect.';
        }
        $user->reset_password = self::createActivationCode($user->email);
        $user->save();
        self::sendReseturl($user);
        return "Send url for reconfiguration";
    }

    public function display(Request $request)
    {
        // バリデーション
        $validator = Validator::make($request->all(), [
            'reset_password' => ['required']
        ]);

        if ($validator->fails()) {
            return response()->json($validator->messages(), Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        //ユーザー検索
        $user = User::where('reset_password',$request->input('reset_password'))
            ->first();

        if (!$user) {
            return 'Failed.';
        }
        //urlの情報とreset_passwordが一致
        return 'Password reset screen';
    }
    public function reset_password(Request $request){
        // バリデーション
        $validator = Validator::make($request->all(), [
            'name' => ['required'],
            'email' => ['required', 'email'],
            'new password' => ['required']
        ]);

        if ($validator->fails()) {
            return response()->json($validator->messages(), Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        //ユーザー検索
        $user = User::where('name', $request->input('name'))
            ->where('email',$request->input('email'))
            ->first();

        if (!$user) {
            return 'Your name or email address is incorrect';
        }else{
            $user->password = Hash::make($request->input('new password'));
            $user->save();
            return 'your password has resetted';
        }
        }

    private function createActivationCode($mail)
    {
        return hash_hmac('md5', $mail, '123456');
    }

    private function sendReseturl($user)
    {
        Mail::to($user->email)
            ->send(new ResetURL($user->reset_password));

    }
}
