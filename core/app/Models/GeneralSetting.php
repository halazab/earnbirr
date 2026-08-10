<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GeneralSetting extends Model
{
    protected $fillable = [
        'site_name', 'cur_text', 'cur_sym', 'base_color', 'secondary_color',
        'min_withdraw', 'max_withdraw', 'activation_fee', 'email_from', 'email_template',
        'sms_api', 'otp_expiration', 'daily_claim_reward',
        'footer_text', 'footer_address', 'footer_email', 'footer_phone',
        'social_telegram', 'social_facebook', 'social_twitter', 'social_instagram',
        'telegram_bot_token', 'telegram_chat_id',
        'system_config', 'maintenance_mode', 'kv', 'ev',
        'site_logo_url', 'site_icon_url',
        'mail_host', 'mail_port', 'mail_username', 'mail_password',
        'mail_encryption', 'mail_from_address', 'mail_from_name',
        'referral_bonus',
    ];

    public function scopeActive($query)
    {
        return $query->where('maintenance_mode', 0);
    }
}
