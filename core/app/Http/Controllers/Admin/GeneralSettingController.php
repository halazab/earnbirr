<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Frontend;
use App\Models\GeneralSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Mail;

class GeneralSettingController extends Controller
{
    public function general()
    {
        $pageTitle = 'General Settings';
        $setting = gs();
        return view('admin.settings.general', compact('pageTitle', 'setting'));
    }

    public function generalUpdate(Request $request)
    {
        $request->validate([
            'site_name' => 'required|string|max:255',
            'cur_text' => 'required|string|max:10',
            'cur_sym' => 'required|string|max:10',
            'base_color' => 'required|string',
            'secondary_color' => 'required|string',
            'min_withdraw' => 'required|numeric|gt:0',
            'max_withdraw' => 'required|numeric|gt:0',
            'activation_fee' => 'required|numeric|gt:0',
        ]);
        $setting = GeneralSetting::first();
        $setting->site_name = $request->site_name;
        $setting->cur_text = $request->cur_text;
        $setting->cur_sym = $request->cur_sym;
        $setting->base_color = $request->base_color;
        $setting->secondary_color = $request->secondary_color;
        $setting->min_withdraw = $request->min_withdraw;
        $setting->max_withdraw = $request->max_withdraw;
        $setting->activation_fee = $request->activation_fee;
        $setting->referral_bonus = $request->referral_bonus ?? 100;
        $setting->ev = $request->ev ?? 0;
        $setting->kv = $request->kv ?? 0;
        $setting->footer_text = $request->footer_text;
        $setting->footer_address = $request->footer_address;
        $setting->footer_email = $request->footer_email;
        $setting->footer_phone = $request->footer_phone;
        $setting->social_telegram = $request->social_telegram;
        $setting->social_facebook = $request->social_facebook;
        $setting->social_twitter = $request->social_twitter;
        $setting->social_instagram = $request->social_instagram;
        $setting->telegram_bot_token = $request->telegram_bot_token;
        $setting->telegram_chat_id = $request->telegram_chat_id;
        $setting->save();
        return back()->with('success', 'Settings updated.');
    }

    public function system()
    {
        $pageTitle = 'System Settings';
        $setting = gs();
        return view('admin.settings.system', compact('pageTitle', 'setting'));
    }

    public function systemUpdate(Request $request)
    {
        $setting = GeneralSetting::first();
        $setting->maintenance_mode = $request->maintenance_mode ?? 0;
        $setting->otp_expiration = $request->otp_expiration ?? 5;
        $setting->daily_claim_reward = $request->daily_claim_reward ?? 1;
        $setting->ev = $request->ev ?? 0;
        $setting->kv = $request->kv ?? 0;
        $setting->save();
        return back()->with('success', 'System settings updated.');
    }

    public function frontendSections($key)
    {
        $pageTitle = 'Frontend Sections';
        $sections = getContent($key, true);
        return view('admin.frontend.index', compact('pageTitle', 'sections', 'key'));
    }

    public function frontendContent(Request $request, $key)
    {
        $request->validate([
            'title' => 'required|string',
            'content' => 'nullable|string',
        ]);
        $data = Frontend::where('data_keys', $key)->first();
        if (!$data) {
            $data = new Frontend();
            $data->data_keys = $key;
        }
        $data->data_values = $request->except('_token');
        $data->save();
        return back()->with('success', 'Content updated successfully.');
    }

    public function logoIcon()
    {
        $pageTitle = 'Logo & Icon';
        return view('admin.settings.logo_icon', compact('pageTitle'));
    }

    public function logoIconUpdate(Request $request)
    {
        $request->validate([
            'site_logo_url' => 'nullable|url|max:500',
            'site_icon_url' => 'nullable|url|max:500',
        ]);

        $setting = GeneralSetting::first();
        $setting->site_logo_url = $request->site_logo_url;
        $setting->site_icon_url = $request->site_icon_url;
        $setting->save();

        Cache::forget('GeneralSetting');

        return back()->with('success', 'Logo & Icon updated.');
    }

    public function smtp()
    {
        $pageTitle = 'Email / SMTP Settings';
        $setting = gs();
        return view('admin.settings.smtp', compact('pageTitle', 'setting'));
    }

    public function smtpUpdate(Request $request)
    {
        $request->validate([
            'mail_host' => 'required|string|max:255',
            'mail_port' => 'required|integer',
            'mail_username' => 'required|email|max:255',
            'mail_password' => 'required|string|max:255',
            'mail_encryption' => 'required|string|in:tls,ssl,none',
        ]);

        $setting = GeneralSetting::first();
        $setting->mail_host = $request->mail_host;
        $setting->mail_port = $request->mail_port;
        $setting->mail_username = $request->mail_username;
        $setting->mail_password = $request->mail_password;
        $setting->mail_encryption = $request->mail_encryption;
        $setting->mail_from_address = $request->mail_from_address ?: $request->mail_username;
        $setting->mail_from_name = $request->mail_from_name ?: 'EarnBirr';
        $setting->save();

        Cache::forget('GeneralSetting');

        return back()->with('success', 'SMTP settings updated successfully.');
    }

    public function smtpTest(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        try {
            $setting = gs();
            config([
                'mail.default' => 'smtp',
                'mail.mailers.smtp.host' => $setting->mail_host,
                'mail.mailers.smtp.port' => (int) $setting->mail_port,
                'mail.mailers.smtp.username' => $setting->mail_username,
                'mail.mailers.smtp.password' => $setting->mail_password,
                'mail.mailers.smtp.encryption' => $setting->mail_encryption === 'none' ? null : $setting->mail_encryption,
                'mail.mailers.smtp.transport' => 'smtp',
                'mail.from.address' => $setting->mail_from_address ?: $setting->mail_username,
                'mail.from.name' => $setting->mail_from_name ?: 'EarnBirr',
            ]);

            Mail::raw('This is a test email from EarnBirr. Your SMTP settings are working correctly!', function ($message) use ($request, $setting) {
                $message->to($request->email)
                    ->subject('EarnBirr - Test Email')
                    ->from($setting->mail_from_address ?: $setting->mail_username, $setting->mail_from_name ?: 'EarnBirr');
            });

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }
}
