<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Sanctum\PersonalAccessToken;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use \Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function login(Request $request){
        // バリデーション
        $validator = Validator::make($request->all(), [
            'email' => ['required', 'email'],
            'password' => ['required']
        ]);

        if ($validator->fails()) {
            return response()->json($validator->messages(), Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        // ユーザー認証
        $user = User::where('email', $request->input('email'))
        ->first();

        if (!$user) {
            return 'Your email address is incorrect.';
        }

        if (Hash :: check($request->input('password'),$user -> password)) {
            $user->login_flag = 1;
            $user->save();
            return 'login completed.';
        }else{
            return 'Your password is incorrect.';
        }
     }

}
