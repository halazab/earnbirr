<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Mail;

class MailConfigServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        $this->configureMail();
    }

    protected function configureMail(): void
    {
        try {
            $setting = \App\Models\GeneralSetting::first();
            if (!$setting || !$setting->mail_host || !$setting->mail_username) {
                return;
            }

            config([
                'mail.default' => 'smtp',
                'mail.mailers.smtp.transport' => 'smtp',
                'mail.mailers.smtp.host' => $setting->mail_host,
                'mail.mailers.smtp.port' => (int) $setting->mail_port,
                'mail.mailers.smtp.username' => $setting->mail_username,
                'mail.mailers.smtp.password' => $setting->mail_password,
                'mail.mailers.smtp.encryption' => $setting->mail_encryption === 'none' ? null : $setting->mail_encryption,
                'mail.mailers.smtp.local_domain' => null,
                'mail.from.address' => $setting->mail_from_address ?: $setting->mail_username,
                'mail.from.name' => $setting->mail_from_name ?: config('app.name', 'EarnBirr'),
            ]);
        } catch (\Exception $e) {
            // If table doesn't exist yet (during migration), silently ignore
        }
    }
}
