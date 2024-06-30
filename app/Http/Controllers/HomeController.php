<?php

namespace App\Http\Controllers;

use App\Http\Requests\UploadFileRequest;
use Illuminate\Support\Facades\File as FileFacade;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Text;
use App\Models\File;
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
        $files = File::where('ip', request()->ip())->get();
        return view('index', compact('text', 'files'));
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
            return response()->successMessage('Text Saved Successfully !');
        }

        return response()->errorMessage('Someting went wrong !');
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

    /**
     * Display a listing of the resource.
     */
    public function upload(UploadFileRequest $request)
    {
        $fileName = Str::uuid() . '.' . $request->file->extension();

        try {
            $request->file->move(public_path('uploads'), $fileName);

            $file = File::create([
                'ip' => request()->ip(),
                'name' => $request->file->getClientOriginalName(),
                'source' => $fileName
            ]);
        } catch (\Exception $e) {
            // If an error occurs, delete the moved file
            if (FileFacade::exists(public_path('uploads') . '/' . $fileName)) {
                FileFacade::delete(public_path('uploads') . '/' . $fileName);
            }

            return response()->errorMessage('Uploading Failed !');
        }

        return response()->success([
            'file' => [
                'id' => $file->id,
                'name' => $file->name,
                'source' => $file->source
            ]
        ]);
    }
}
