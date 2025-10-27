<?php

namespace App\Http\Controllers;

class HomeController extends Controller
{
    public function index()
    {
        // You could pass data here later:
        // return view('home', ['welcome' => 'Hello']);
        return view('home');
    }
}
