<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DailyClaim;
use App\Models\Deposit;
use App\Models\Transaction;
use App\Models\User;
use App\Models\Withdrawal;
use Illuminate\Http\Request;

class ManageUsersController extends Controller
{
    public function allUsers(Request $request)
    {
        $pageTitle = 'All Users';
        $users = $this->applySearch(User::query(), $request)->latest()->paginate(getPaginate());
        return view('admin.users.list', compact('pageTitle', 'users'));
    }

    public function activeUsers(Request $request)
    {
        $pageTitle = 'Active Users';
        $users = $this->applySearch(User::active(), $request)->latest()->paginate(getPaginate());
        return view('admin.users.list', compact('pageTitle', 'users'));
    }

    public function bannedUsers(Request $request)
    {
        $pageTitle = 'Banned Users';
        $users = $this->applySearch(User::banned(), $request)->latest()->paginate(getPaginate());
        return view('admin.users.list', compact('pageTitle', 'users'));
    }

    public function activatedUsers(Request $request)
    {
        $pageTitle = 'Activated Users';
        $users = $this->applySearch(User::activated(), $request)->latest()->paginate(getPaginate());
        return view('admin.users.list', compact('pageTitle', 'users'));
    }

    protected function applySearch($query, Request $request)
    {
        if ($search = $request->search) {
            $query->where(function ($q) use ($search) {
                $q->where('firstname', 'like', "%{$search}%")
                    ->orWhere('lastname', 'like', "%{$search}%")
                    ->orWhere('username', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('mobile', 'like', "%{$search}%");
            });
        }
        return $query;
    }

    public function detail($id)
    {
        $user = User::with(['deposits', 'withdrawals', 'transactions'])->findOrFail($id);
        $pageTitle = 'User Detail - ' . $user->fullname();
        $totalDeposit = $user->deposits()->where('status', 1)->sum('amount');
        $totalWithdraw = $user->withdrawals()->where('status', 1)->sum('amount');
        $transactionCount = $user->transactions()->count();
        $transactions = $user->transactions()->latest()->take(10)->get();
        return view('admin.users.detail', compact('pageTitle', 'user', 'totalDeposit', 'totalWithdraw', 'transactionCount', 'transactions'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        if ($request->has('kv')) {
            $request->validate(['kv' => 'required|in:0,1']);
            $user->kv = $request->kv;
            $user->save();
            $msg = $request->kv == 1 ? 'KYC approved.' : 'KYC rejected.';
            return back()->with('success', $msg);
        }
        $request->validate([
            'firstname' => 'required|string|max:50',
            'lastname' => 'required|string|max:50',
            'email' => 'required|email|unique:users,email,' . $id,
            'mobile' => 'required|unique:users,mobile,' . $id,
        ]);
        $user->firstname = $request->firstname;
        $user->lastname = $request->lastname;
        $user->email = $request->email;
        $user->mobile = $request->mobile;
        $user->save();
        return back()->with('success', 'User updated successfully.');
    }

    public function toggleStatus($id)
    {
        $user = User::findOrFail($id);
        $user->status = $user->status == 1 ? 0 : 1;
        $user->save();
        $message = $user->status == 1 ? 'User activated successfully.' : 'User banned successfully.';
        return back()->with('success', $message);
    }

    public function addSubBalance(Request $request, $id)
    {
        $request->validate([
            'amount' => 'required|numeric|gt:0',
            'type' => 'required|in:credit,debit',
            'details' => 'required|string',
        ]);
        $user = User::findOrFail($id);
        $trx = 'TRX' . time() . rand(1000, 9999);
        if ($request->type == 'credit') {
            $user->balance += $request->amount;
            $user->save();
            $transaction = new Transaction();
            $transaction->user_id = $user->id;
            $transaction->trx = $trx;
            $transaction->amount = $request->amount;
            $transaction->charge = 0;
            $transaction->post_balance = $user->balance;
            $transaction->type = 'credit';
            $transaction->remark = 'admin_add';
            $transaction->details = $request->details;
            $transaction->save();
            return back()->with('success', 'Balance added successfully.');
        } else {
            if ($user->balance < $request->amount) {
                return back()->withErrors(['Insufficient balance.']);
            }
            $user->balance -= $request->amount;
            $user->save();
            $transaction = new Transaction();
            $transaction->user_id = $user->id;
            $transaction->trx = $trx;
            $transaction->amount = $request->amount;
            $transaction->charge = 0;
            $transaction->post_balance = $user->balance;
            $transaction->type = 'debit';
            $transaction->remark = 'admin_deduct';
            $transaction->details = $request->details;
            $transaction->save();
            return back()->with('success', 'Balance deducted successfully.');
        }
    }

    public function login($id)
    {
        $user = User::findOrFail($id);
        auth()->login($user);
        return redirect()->route('user.home');
    }

    public function resetDailyClaim($id)
    {
        $user = User::findOrFail($id);
        DailyClaim::where('user_id', $user->id)
            ->whereDate('created_at', today())
            ->delete();
        return back()->with('success', 'Daily claim reset for ' . $user->fullname() . '. They can now claim again.');
    }
}
