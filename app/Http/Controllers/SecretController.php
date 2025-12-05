<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;


class SecretController extends Controller
{
    public function index()
    {
        if (Auth::check()) {
            $user = Auth::user();
            $email = $user->email; // Get the user's email address
            
            // You can use this email for any purpose (e.g., logging, conditional logic, etc.)
            Log::info('Authenticated user email: ' . $email);
            // Example: You could also check for a specific email domain or role
            return view('secret', compact('user'));
        }
    }
}


