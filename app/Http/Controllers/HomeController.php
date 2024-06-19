<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Text;

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
}
