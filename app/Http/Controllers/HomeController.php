<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Text;
use App\Models\User;
use Auth;

class HomeController extends Controller
{
	/**
     * Display a listing of the resource.
     */
    public function index()
    {
        $text = Text::where('ip', request()->ip())->first()?->text;
        return view('index', compact('text'));
    }

    /**
     * Display a listing of the resource.
     */
    public function howItWorks()
    {
    	return view('how-it-works');
    }

    /**
     * Display a listing of the resource.
     */
    public function saveText(Request $request)
    {
        $saveText = Text::updateOrCreate(
            [ 'ip' => request()->ip() ],
            [ 'text' => $request->text ]
        );

        if ($saveText) {
            return response()->json([
                'message' => 'Text Saved Successfully !'
            ]);
        }

        return response()->json([
            'message' => 'Someting went wrong !'
        ]);
    }

    /**
     * Display a listing of the resource.
     */
    public function login()
    {
        return view('login');
    }

    /**
     * Display a listing of the resource.
     */
    public function authenticate(Request $request)
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
     * Display a listing of the resource.
     */
    public function register()
    {
        return view('register');
    }

    /**
     * Display a listing of the resource.
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
