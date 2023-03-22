<?php
namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Models\User;
use App\Mail\VerificationMail;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use \Symfony\Component\HttpFoundation\Response;
class MailVerficationsController extends Controller
{

    public function verify(Request $request)
    {
        // バリデーション
        $validator = Validator::make($request->all(), [
            'mail_authentication' => ['required']
        ]);

        if ($validator->fails()) {
            return response()->json($validator->messages(), Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        //ユーザー検索
        $user = User::where('register_flag', null)
            ->where('mail_authentication',$request->input('mail_authentication'))
            ->first();

        if (!$user) {
            return 'Verification failed.';
        }
        //登録
        $user->register_flag = 1;
        $user->save();

        return 'Verification succeeded.';
    }
}
