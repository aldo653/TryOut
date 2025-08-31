<?php

namespace App\Http\Controllers\Index;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function index(){
        return view('index');
    }

    public function login(Request $request)
    {
        // Logic for handling login
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        // Here you would typically check the credentials against your user model
        $credentials = [
            'nip_nim' => $request->input('username'),
            'password' => $request->input('password'),
        ];

        if (Auth::attempt($credentials)) {
            // Authentication passed
            return redirect()->intended(route('dashboard')); // Redirect to intended page after login
        }

        return redirect()->back()
            ->withInput($request->only('username'));// Keep the username in the input
    }

    public function logout()
    {
        Auth::logout(); // Log the user out
        return redirect()->route('login'); // Redirect to the index page after logout
    }
}
