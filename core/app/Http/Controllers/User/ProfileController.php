<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function profile()
    {
        $pageTitle = 'Profile Settings';
        $user = auth()->user();
        return view('templates.basic.user.profile_setting', compact('pageTitle', 'user'));
    }

    public function submitProfile(Request $request)
    {
        $user = auth()->user();
        $request->validate([
            'firstname' => 'required|string|max:50',
            'lastname' => 'required|string|max:50',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'mobile' => 'required|unique:users,mobile,' . $user->id,
        ]);
        $user->firstname = $request->firstname;
        $user->lastname = $request->lastname;
        $user->email = $request->email;
        $user->mobile = $request->mobile;
        $user->save();
        return back()->with('success', 'Profile updated successfully.');
    }

    public function changePassword()
    {
        $pageTitle = 'Change Password';
        return view('templates.basic.user.password', compact('pageTitle'));
    }

    public function submitPassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|min:6|confirmed',
        ]);
        $user = auth()->user();
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['Current password is incorrect.']);
        }
        $user->password = Hash::make($request->password);
        $user->save();
        return back()->with('success', 'Password changed successfully.');
    }
}
