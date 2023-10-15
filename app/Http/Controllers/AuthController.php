<?php

namespace App\Http\Controllers;

use App\Jobs\CustomerJob;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Mail\SendMailable;


class AuthController extends Controller
{
    public function loginForm() {
        return view('auth.login');
    }

    public function registerForm() {
        return view('auth.register');
    }

    public function register(Request $request) {
        $request->validate([
            'name'      => 'required|string',
            'email'     => 'required|email|unique:users',
            'password'  => 'required|confirmed|string|min:6'
        ]);

        $token = Str::random(24);

        $user = User::create([
            'name'              => $request->name,
            'email'             => $request->email,
            'password'          => bcrypt($request->password),
            'remember_token'    => $token
        ]);

        // dispatch(new CustomerJob());

        // dispatch(new CustomerJob($user));
        CustomerJob::dispatch(($user));

        // Mail::send('auth.verification-mail', ['user' => $user], function($mail) use($user) {
        //     $mail->to($user->email);
        //     $mail->subject('Account Verification');
        // });

        // Mail::send('auth.verification-mail', ['user' => $user], function($mail) use($user) {
        //     $mail->to($user->email);
        //     // $mail->subject('Account Verification');
        //     new SendMailable();
        // });

        // Mail::to($user->email)->send(new SendMailable($user));


        // dd('Email sent');

        return redirect('/')->with('message', 'Account registered successfully. Please check your email for verification');
    }

    public function verification(User $user, $token) {
        // If user tries to verify after trying to login before clicking the verification link
        // dd($token, $user->remember_token);
        if ($user->remember_token !== $token) {
            return redirect('/')->with('error', 'Invalid token');
        }

        $user->email_verified_at = now();
        // $user->remember_token = null;
        $user->save();

        //Verification successful
        return redirect('/')->with('message', 'Account verified successfully. You may now log in.');
    }

    public function login (Request $request) {
        $request->validate([
            'email'     => 'required|email',
            'password'  => 'required|string',
        ]);

        // $credentials = $request->only('email', 'password');
        $user = User::where('email', $request->email)->first();
        if (!$user || $user->email_verified_at == null) {
            return redirect('/')->with('error', 'Invalid credentials or account not verified.');
        }

        $login = auth()->attempt([
            'email'     => $request->email,
            'password'  => $request->password
        ]);

        if (!$login) {
            return back()->with('error', 'Invalid credentials');
        }

        return redirect('/dashboard');
        // if (Auth::attempt($credentials)) {
        //     if (Auth::user()->email_verified_at) {
        //         return view('dashboard');
        //     } else {
        //         Auth::logout();
        //         return redirect()->route('login')->with('error', 'Email not verified. Please check your email for verification');
        //     }
        // }

        // return back()->with('error', 'Credentials unmatched.');
    }

    public function logout(Request $request) {
        auth()->logout();

        // $request->session()->invalidate();
        // $request->session()->regenerateToken();

        return redirect('/')->with('message', 'You have logged out');
    }
}
