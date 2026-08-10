<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Referral;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class RegisterController extends Controller
{
    public function showRegistrationForm()
    {
        $pageTitle = 'Register';
        $referralCode = request('ref');
        return view('templates.basic.user.auth.register', compact('pageTitle', 'referralCode'));
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'firstname' => 'required|string|max:50',
            'lastname' => 'required|string|max:50',
            'email' => 'required|email|unique:users',
            'mobile' => 'required|unique:users',
            'username' => 'required|alpha_dash|unique:users',
            'password' => 'required|min:6|confirmed',
            'referral_code' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $referrer = null;
        if (!empty($request->referral_code)) {
            $referrer = User::where('referral_code', $request->referral_code)->first();
        }

        $evEnabled = gs('ev') ?? 0;

        $user = new User();
        $user->firstname = $request->firstname;
        $user->lastname = $request->lastname;
        $user->email = $request->email;
        $user->mobile = $request->mobile;
        $user->username = $request->username;
        $user->password = Hash::make($request->password);
        $user->referral_code = strtoupper(Str::random(8));
        $user->referred_by = $referrer?->id;
        $user->ev = $evEnabled ? 0 : 1;
        $user->sv = 1;
        $user->save();

        if ($referrer) {
            Referral::create([
                'referrer_id' => $referrer->id,
                'referred_id' => $user->id,
                'status' => $user->activation_fee_paid ? 2 : 1,
            ]);
        }

        if ($evEnabled) {
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

                Mail::send('emails.verify_email', ['user' => $user, 'code' => $code], function ($message) use ($user, $setting) {
                    $message->to($user->email)
                        ->subject('EarnBirr - Verify Your Email')
                        ->from($setting->mail_from_address ?: $setting->mail_username, $setting->mail_from_name ?: 'EarnBirr');
                });
            } catch (\Exception $e) {
                // Email failed, but user is created
            }

            auth()->login($user);
            return redirect()->route('user.verification.form')->with([
                'email' => $user->email,
                'success' => 'Account created! Please check your email for a verification code.',
            ]);
        }

        auth()->login($user);
        return redirect()->route('user.tasks.index');
    }

    public function checkUser(Request $request)
    {
        $exists = User::where('username', $request->username)->orWhere('email', $request->email)->exists();
        return response()->json(['exists' => $exists]);
    }
}
