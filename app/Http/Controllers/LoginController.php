<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /**
     * Handle an authentication attempt.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function authenticate(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            return redirect()->intended('/checkout');
        }

        if (session('locale') === 'en') {
            $message = 'The provided credentials do not match our records.';
        } else {
            $message = 'Tus credenciales no concuerdan con nuestros datos.';
        }


        return back()->withErrors([

            'email' => $message,
        ]);
    }
}
