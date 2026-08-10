<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\DailyClaim;
use App\Models\Transaction;
use Illuminate\Http\Request;

class DailyClaimController extends Controller
{
    public function claim()
    {
        $user = auth()->user();
        $todayClaim = DailyClaim::where('user_id', $user->id)
            ->whereDate('created_at', today())
            ->first();

        if ($todayClaim) {
            return back()->withErrors(['You have already claimed today. Come back tomorrow!']);
        }

        $yesterdayClaim = DailyClaim::where('user_id', $user->id)
            ->whereDate('created_at', today()->subDay())
            ->first();

        $streak = $yesterdayClaim ? $yesterdayClaim->streak + 1 : 1;
        $baseReward = gs('daily_claim_reward');

        // 25% increase per day: Day 1 = 1.0x, Day 2 = 1.25x, Day 3 = 1.5x, etc.
        // Capped at 10x base reward
        $multiplier = 1 + ($streak - 1) * 0.25;
        $multiplier = min($multiplier, 10);
        $reward = $baseReward * $multiplier;

        $claim = new DailyClaim();
        $claim->user_id = $user->id;
        $claim->claim_date = today();
        $claim->streak = $streak;
        $claim->reward = $reward;
        $claim->save();

        $user->balance += $reward;
        $user->total_earned += $reward;
        $user->save();

        $trx = 'CLM' . time() . rand(1000, 9999);
        $transaction = new Transaction();
        $transaction->user_id = $user->id;
        $transaction->trx = $trx;
        $transaction->amount = $reward;
        $transaction->charge = 0;
        $transaction->post_balance = $user->balance;
        $transaction->type = 'credit';
        $transaction->remark = 'daily_claim';
        $transaction->details = 'Daily claim reward (Day ' . $streak . ')';
        $transaction->save();

        return back()->with('success', 'Daily claim reward of ' . showAmount($reward) . ' credited!');
    }
}
