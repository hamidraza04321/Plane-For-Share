<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Text;
use App\Models\File;
use App\Models\User;

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
     * How it Works
     */
    public function howItWorks()
    {
    	return view('how-it-works');
    }

    /**
     * Save the plain text
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
}
