<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\Withdrawal;
use App\Models\WithdrawMethod;
use Illuminate\Http\Request;

class WithdrawController extends Controller
{
    public function index()
    {
        $pageTitle = 'Withdraw Funds';
        $methods = WithdrawMethod::active()->get();
        $user = auth()->user();
        $activatedReferrals = $user->activatedReferrals()->count();
        $requiredReferrals = 3;

        return view('templates.basic.user.withdraw.index', compact(
            'pageTitle', 'methods', 'user', 'activatedReferrals', 'requiredReferrals'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'method_id' => 'required|exists:withdraw_methods,id',
            'amount' => 'required|numeric|gt:0',
            'account_info' => 'required|string',
        ]);

        $method = WithdrawMethod::findOrFail($request->method_id);
        $user = auth()->user();

        $activatedReferrals = $user->activatedReferrals()->count();
        if ($activatedReferrals < 3) {
            return back()->withErrors(['You need at least 3 activated referrals to withdraw. You have ' . $activatedReferrals . '.']);
        }

        if ($request->amount < $method->min_limit) {
            return back()->withErrors(['Amount is less than minimum limit.']);
        }
        if ($request->amount > $method->max_limit) {
            return back()->withErrors(['Amount exceeds maximum limit.']);
        }
        if ($request->amount > $user->balance) {
            return back()->withErrors(['Insufficient balance.']);
        }
        if ($user->balance < gs('min_withdraw')) {
            return back()->withErrors(['Minimum withdrawal amount is ' . showAmount(gs('min_withdraw'))]);
        }
        if ($request->amount > gs('max_withdraw')) {
            return back()->withErrors(['Maximum withdrawal amount is ' . showAmount(gs('max_withdraw'))]);
        }

        $charge = $method->fixed_charge + ($request->amount * $method->percent_charge / 100);
        $finalAmount = $request->amount - $charge;

        $withdrawal = new Withdrawal();
        $withdrawal->user_id = $user->id;
        $withdrawal->trx = 'WD' . time() . rand(1000, 9999);
        $withdrawal->amount = $request->amount;
        $withdrawal->charge = $charge;
        $withdrawal->final_amount = $finalAmount;
        $withdrawal->method = $method->name;
        $withdrawal->account_info = $request->account_info;
        $withdrawal->status = 0;
        $withdrawal->save();

        $user->balance -= $request->amount;
        $user->save();

        $transaction = new Transaction();
        $transaction->user_id = $user->id;
        $transaction->trx = $withdrawal->trx;
        $transaction->amount = $request->amount;
        $transaction->charge = $charge;
        $transaction->post_balance = $user->balance;
        $transaction->type = 'debit';
        $transaction->remark = 'withdrawal';
        $transaction->details = 'Withdrawal via ' . $method->name;
        $transaction->save();

        return redirect()->route('user.withdraw.history')->with('success', 'Withdrawal request submitted.');
    }

    public function history()
    {
        $pageTitle = 'Withdrawal History';
        $withdrawals = auth()->user()->withdrawals()->latest()->paginate(getPaginate());
        return view('templates.basic.user.withdraw.history', compact('pageTitle', 'withdrawals'));
    }
}
