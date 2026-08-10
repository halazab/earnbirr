<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Referral;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;

class ReferralController extends Controller
{
    public function index()
    {
        $pageTitle = 'Referral Program';
        $user = auth()->user();
        $referralCount = $user->activatedReferrals()->count();
        $referrals = $user->referrals()->with('referred')->latest()->paginate(20);
        $referralLink = url('/register?ref=' . $user->referral_code);
        $referralBonus = gs('referral_bonus') ?? 100;

        return view('templates.basic.user.referral', compact(
            'pageTitle', 'user', 'referralCount', 'referrals', 'referralLink', 'referralBonus'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ]);

        $referrer = auth()->user();
        $referred = User::where('email', $request->email)->first();

        if ($referred->id === $referrer->id) {
            return back()->withErrors(['You cannot refer yourself.']);
        }

        if ($referred->referred_by) {
            return back()->withErrors(['This user already has a referrer.']);
        }

        $exists = Referral::where('referrer_id', $referrer->id)
            ->where('referred_id', $referred->id)
            ->exists();

        if ($exists) {
            return back()->withErrors(['You have already referred this user.']);
        }

        Referral::create([
            'referrer_id' => $referrer->id,
            'referred_id' => $referred->id,
            'status' => $referred->activation_fee_paid ? 2 : 1,
        ]);

        $referred->referred_by = $referrer->id;
        $referred->save();

        if ($referred->activation_fee_paid) {
            $bonus = gs('referral_bonus') ?? 100;
            $referrer->balance += $bonus;
            $referrer->total_earned += $bonus;
            $referrer->save();

            $trx = 'TRX' . time() . rand(1000, 9999);
            Transaction::create([
                'user_id' => $referrer->id,
                'trx' => $trx,
                'amount' => $bonus,
                'charge' => 0,
                'post_balance' => $referrer->balance,
                'type' => 'credit',
                'remark' => 'referral_bonus',
                'details' => 'Referral bonus for inviting ' . $referred->email,
            ]);
        }

        return back()->with('success', 'Referral recorded successfully!');
    }
}
