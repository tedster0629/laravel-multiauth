<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;

class AdminResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo = '/admin/dashboard';

    // The mail receiver will click the link and come to this route.
    // After that, we will pass the token in the reset.blade.php form.
    // The url will be something like this:
    // http://uiauth.test/password/reset/8589fe197516406898552b0f0f945f08acbe159a87ead7cfa3bc6f930d5b4277?email=h%40h.com
    public function showResetForm(Request $request, $token = null)
    {
        $email = $request->email;
        return view('admin.auth.passwords.reset', compact('token', 'email'));
    }

    /**
     * Get the broker to be used during password reset.
     */
    protected function broker()
    {
        return Password::broker('admins'); // used `admins` table
    }


    protected function guard()
    {
        return auth()->guard('admin');
    }
}
