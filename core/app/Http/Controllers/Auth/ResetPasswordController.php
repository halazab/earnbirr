<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ResetPasswordController extends Controller
{
    public function showResetForm($token)
    {
        $pageTitle = 'Reset Password';
        $email = session('email') ?? '';
        $code = session('code') ?? '';
        return view('templates.basic.user.auth.passwords.reset', compact('pageTitle', 'token', 'email', 'code'));
    }

    public function reset(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users',
            'code' => 'required|string|size:6',
            'password' => 'required|min:6|confirmed',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || $user->ver_code !== $request->code) {
            return back()->with('error', 'Invalid verification code.');
        }

        $user->update([
            'password' => Hash::make($request->password),
            'ver_code' => null,
            'ver_code_send_at' => null,
        ]);

        return redirect()->route('user.login')->with('success', 'Password reset successfully. You can now sign in.');
    }
}
