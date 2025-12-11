<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function showForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $data = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $nameParts = explode(' ', $data['name']);

        User::create([
            'name'      => $data['name'],
            'firstname' => $nameParts[0] ?? '',
            'lastname'  => $nameParts[1] ?? '',
            'email'     => $data['email'],
            'user_type' => 'client',
            'password'  => Hash::make($data['password']),
        ]);

        return redirect()->route('auth.login')->with('success', 'Account created.');
    }
}
