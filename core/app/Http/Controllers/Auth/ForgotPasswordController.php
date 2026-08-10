<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class ForgotPasswordController extends Controller
{
    public function showLinkRequestForm()
    {
        $pageTitle = 'Forgot Password';
        return view('templates.basic.user.auth.passwords.email', compact('pageTitle'));
    }

    public function sendResetCodeEmail(Request $request)
    {
        $request->validate(['email' => 'required|email|exists:users']);

        $user = User::where('email', $request->email)->first();
        $code = str_pad(random_int(100000, 999999), 6, '0', STR_PAD_LEFT);

        $user->update([
            'ver_code' => $code,
            'ver_code_send_at' => now(),
        ]);

        try {
            $setting = gs();
            config([
                'mail.default' => 'smtp',
                'mail.mailers.smtp.transport' => 'smtp',
                'mail.mailers.smtp.host' => $setting->mail_host,
                'mail.mailers.smtp.port' => (int) $setting->mail_port,
                'mail.mailers.smtp.username' => $setting->mail_username,
                'mail.mailers.smtp.password' => $setting->mail_password,
                'mail.mailers.smtp.encryption' => $setting->mail_encryption === 'none' ? null : $setting->mail_encryption,
                'mail.from.address' => $setting->mail_from_address ?: $setting->mail_username,
                'mail.from.name' => $setting->mail_from_name ?: 'EarnBirr',
            ]);

            Mail::send('emails.password_reset', ['user' => $user, 'code' => $code], function ($message) use ($user, $code, $setting) {
                $message->to($user->email)
                    ->subject('EarnBirr - Password Reset Code')
                    ->from($setting->mail_from_address ?: $setting->mail_username, $setting->mail_from_name ?: 'EarnBirr');
            });
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to send email. Please check SMTP settings in admin panel.');
        }

        return redirect()->route('user.password.code.verify')->with([
            'success' => 'A verification code has been sent to your email.',
            'email' => $user->email,
        ]);
    }

    public function codeVerify()
    {
        $pageTitle = 'Verify Code';
        $email = session('email') ?? request()->query('email', '');
        return view('templates.basic.user.auth.passwords.code_verify', compact('pageTitle', 'email'));
    }

    public function verifyCode(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users',
            'code' => 'required|string|size:6',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || $user->ver_code !== $request->code) {
            return back()->with('error', 'Invalid verification code.');
        }

        $expiration = gs('otp_expiration') ?? 5;
        if ($user->ver_code_send_at && now()->diffInMinutes($user->ver_code_send_at) > $expiration) {
            return back()->with('error', 'Verification code has expired. Please request a new one.');
        }

        $token = Str::random(64);

        return redirect()->route('user.password.reset', ['token' => $token])->with([
            'email' => $user->email,
            'code' => $request->code,
        ]);
    }
}
