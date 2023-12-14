<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function updatePassword(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $user->password = Hash::make($request->new_password);
            $user->save();
            return redirect()->route('home')->with('success', 'Password updated successfully.');
        }
        else{
            return redirect()->back()->withErrors(['current_password' => 'The email/current password is incorrect.']);
        }
    }
}
