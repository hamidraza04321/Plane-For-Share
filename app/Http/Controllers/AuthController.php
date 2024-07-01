<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

class AuthController extends Controller
{
    /**
     * Login Page
     */
    public function login()
    {
        return view('login');
    }

    /**
     * User Authentication
     */
    public function signin(Request $request)
    {
        $request->validate([
            'login' => 'required',
            'password' => 'required'
        ]);

        $key = filter_var($request->login, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
        $attempt = [ 
            $key => $request->login,
            'password' => $request->password
        ];

        if (Auth::attempt($attempt)) {
            return redirect()->route('index');
        }

        return redirect()->back()->withErrors([ 'message' => 'Invalid Credentials !' ]);
    }

    /**
     * Register Page
     */
    public function register()
    {
        return view('register');
    }

    /**
     * User Registration
     */
    public function signup(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'username' => 'required|unique:users,username',
            'password' => 'required|min:6'
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'username' => $request->username,
            'password' => bcrypt($request->password)
        ]);

        return redirect()->route('login')->with([ 'message' => 'User Register Successfully !' ]);
    }
}
