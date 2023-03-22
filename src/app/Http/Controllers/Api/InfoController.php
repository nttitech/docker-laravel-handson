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
class InfoController extends Controller
{

    public function get_info(Request $request)
    {
        // バリデーション
        $validator = Validator::make($request->all(), [
            'email' => ['required', 'email'],
            'password' => ['required']
        ]);

        if ($validator->fails()) {
            return response()->json($validator->messages(), Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        $user = User::where('email', $request->input('email'))
            ->first();

        if (!$user) {
            return 'Your email address is incorrect.';
        }

        if($user->register_flag != 1){
            return 'Please login';
        }

        if (Hash :: check($request->input('password'),$user -> password)) {
            return response()->json([
                'name' => $user->name,'email' => $user->email
            ], 401);
        }else{
            return 'Your password is incorrect.';
        }

    }
}
