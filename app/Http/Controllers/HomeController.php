<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
	/**
     * Display a listing of the resource.
     */
    public function index()
    {
    	return view('index');
    }

    /**
     * Display a listing of the resource.
     */
    public function howItWorks()
    {
    	return view('how-it-works');
    }
}
