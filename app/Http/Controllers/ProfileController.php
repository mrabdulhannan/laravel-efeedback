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

            // Handle profile image update
            $profileImage = $request->file('profile_image');
            // dd($profileImage);
            if ($profileImage) {
                try {
                    $path = $profileImage->store('profile_images', 'public');
                    // If storing is successful, update the user's profile image path
                    $user->profile_image = $path;
                } catch (\Exception $e) {
                    // Handle any storage-related errors
                    return redirect()->back()->withErrors(['profile_image' => 'Error storing the profile image.']);
                }
            }

            $user->save();

            return redirect()->route('home')->with('success', 'Password updated successfully.');
        } else {
            return redirect()->back()->withErrors(['current_password' => 'The email/current password is incorrect.']);
        }
    }
}
