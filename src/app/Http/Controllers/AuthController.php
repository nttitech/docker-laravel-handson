<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Models\User;
use App\Mail\VerificationMail;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $user = new User();

        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->password = bcrypt($request->input('password'));

        Mail::to($user->email)->send(new VerificationMail($user));

        return response()->json([
            'message' => 'User created successfully.'
        ]);
    }

    public function verify(Request $request)
    {
        $user = User::where('email', $request->email)
            ->where('email_verified_at', null)
            ->first();

        if (!$user) {
            return response()->json([
                'message' => 'Verification failed.'
            ], 401);
        }

        $user->email_verified_at = now();
        $user->save();

        return response()->json([
            'message' => 'Verification succeeded.'
        ]);
    }
}
