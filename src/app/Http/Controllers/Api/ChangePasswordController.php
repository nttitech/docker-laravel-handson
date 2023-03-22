<?php
namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Models\User;
use App\Mail\VerificationMail;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use \Symfony\Component\HttpFoundation\Response;
class ChangePasswordController extends Controller
{

    public function change(Request $request)
    {
        // バリデーション
        $validator = Validator::make($request->all(), [
            'name' => ['required'],
            'email' => ['required', 'email'],
            'password' => ['required'],
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
            return 'Your name or email address is incorrect.';
        }
        //パスワード正誤チェック
        if (Hash :: check($request->input('password'),$user -> password)) {
            $user->password = Hash::make($request->input('new password'));
            $user->save();
            return 'Your password has changed.';
        }else{
            return 'Your password is incorrect.';
        }

    }
}
