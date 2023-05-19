<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Models\Admin;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;


class AdminController extends Controller
{
    public function showLoginForm() {
        return view('admin.auth.login');
    }

    public function login(Request $request) {
        $this->validate($request, [
            'email' => 'required|string',
            'password' => 'required|string'
        ]);

        $credentials = $request->only(['email', 'password']);

        // By default, auth()->attempt() will use the default guard named `web`
        // but we have to use the `admin` guard that we have defined and
        // behind the scenes this method will attempt to get the guard from
        // the local cache.
        if (auth()->guard('admin')->attempt($credentials, $request->remember)) {

            $user = Admin::where('email', $request->email)->first();
            // guard() => Attempt to get the guard from the local cache.
            Auth::guard('admin')->login($user);

            return redirect()->route('dashboard');
        }
        else {
            return back()->withErrors([
                'email' => 'These credentials do not match our records.'
            ]);
        }
    }


    public function showRegistrationForm() {
        return view('admin.auth.register');
    }

    public function register(Request $request) {
        $this->validate($request, [
            'name' => 'required|max:255',
            'email' => 'required|email|unique:admins', // unique:admins will run query and check if email is taken or not.
            'password' => 'required|confirmed', // Automatically attach to the field password_confirmation
        ]);

        // After request validation create the field
        $admin = Admin::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        auth()->guard('admin')->loginUsingId($admin);

        return redirect()->route('dashboard');
    }



    public function showDashboard() {
        return view('admin.dashboard.home');
    }

    public function logout() {
        auth()->guard('admin')->logout();
        return redirect()->route('admin.login');
    }
}
