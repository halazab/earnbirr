<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'firstname', 'lastname', 'username', 'email', 'mobile',
        'country_code', 'password', 'balance', 'total_earned', 'total_withdrawn',
        'referral_code', 'referred_by',
        'kv', 'kyc_data', 'kyc_info', 'kyc_rejection_reason',
        'ev', 'sv', 'ver_code', 'ver_code_send_at',
        'ts', 'tsc', 'activation_fee_paid', 'activation_trx',
        'provider', 'provider_id', 'device_token', 'ip', 'device_info', 'status'
    ];

    protected $hidden = ['password', 'remember_token'];

    public function deposits()
    {
        return $this->hasMany(Deposit::class);
    }

    public function withdrawals()
    {
        return $this->hasMany(Withdrawal::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    public function taskSubmissions()
    {
        return $this->hasMany(TaskSubmission::class);
    }

    public function supportTickets()
    {
        return $this->hasMany(SupportTicket::class);
    }

    public function dailyClaims()
    {
        return $this->hasMany(DailyClaim::class);
    }

    public function userActivations()
    {
        return $this->hasMany(UserActivation::class);
    }

    public function logins()
    {
        return $this->hasMany(UserLogin::class);
    }

    public function referrals()
    {
        return $this->hasMany(Referral::class, 'referrer_id');
    }

    public function referredBy()
    {
        return $this->belongsTo(User::class, 'referred_by');
    }

    public function activatedReferrals()
    {
        return $this->referrals()->where('status', 2);
    }

    public function fullname()
    {
        return trim($this->firstname . ' ' . $this->lastname);
    }

    public function getIsActivatedAttribute()
    {
        return $this->activation_fee_paid == 1;
    }

    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }

    public function scopeBanned($query)
    {
        return $query->where('status', 0);
    }

    public function scopeActivated($query)
    {
        return $query->where('activation_fee_paid', 1);
    }

    public function scopeKycVerified($query)
    {
        return $query->where('kv', 1);
    }
}
