<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\Withdrawal;
use App\Models\WithdrawMethod;
use Illuminate\Http\Request;

class WithdrawalController extends Controller
{
    public function all()
    {
        $pageTitle = 'All Withdrawals';
        $withdrawals = $this->applySearch(Withdrawal::query())->with('user')->latest()->paginate(getPaginate());
        return view('admin.withdrawals.index', compact('pageTitle', 'withdrawals'));
    }

    public function pending()
    {
        $pageTitle = 'Pending Withdrawals';
        $withdrawals = $this->applySearch(Withdrawal::pending())->with('user')->latest()->paginate(getPaginate());
        return view('admin.withdrawals.index', compact('pageTitle', 'withdrawals'));
    }

    public function approved()
    {
        $pageTitle = 'Approved Withdrawals';
        $withdrawals = $this->applySearch(Withdrawal::approved())->with('user')->latest()->paginate(getPaginate());
        return view('admin.withdrawals.index', compact('pageTitle', 'withdrawals'));
    }

    public function rejected()
    {
        $pageTitle = 'Rejected Withdrawals';
        $withdrawals = $this->applySearch(Withdrawal::rejected())->with('user')->latest()->paginate(getPaginate());
        return view('admin.withdrawals.index', compact('pageTitle', 'withdrawals'));
    }

    protected function applySearch($query)
    {
        if ($search = request('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('trx', 'like', "%{$search}%")
                    ->orWhereHas('user', function ($user) use ($search) {
                        $user->where('firstname', 'like', "%{$search}%")
                            ->orWhere('lastname', 'like', "%{$search}%")
                            ->orWhere('username', 'like', "%{$search}%")
                            ->orWhere('email', 'like', "%{$search}%")
                            ->orWhere('mobile', 'like', "%{$search}%");
                    });
            });
        }
        return $query;
    }

    public function details($id)
    {
        $pageTitle = 'Withdrawal Details';
        $withdrawal = Withdrawal::with('user')->findOrFail($id);
        return view('admin.withdrawals.details', compact('pageTitle', 'withdrawal'));
    }

    public function approve(Request $request)
    {
        $request->validate(['id' => 'required|exists:withdrawals,id']);
        $withdrawal = Withdrawal::findOrFail($request->id);
        if ($withdrawal->status != 0) {
            return back()->withErrors(['Withdrawal already processed.']);
        }
        $withdrawal->status = 1;
        $withdrawal->save();
        return back()->with('success', 'Withdrawal approved.');
    }

    public function reject(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:withdrawals,id',
            'admin_feedback' => 'required|string',
        ]);
        $withdrawal = Withdrawal::findOrFail($request->id);
        if ($withdrawal->status != 0) {
            return back()->withErrors(['Withdrawal already processed.']);
        }
        $withdrawal->status = 2;
        $withdrawal->admin_feedback = $request->admin_feedback;
        $withdrawal->save();

        $user = $withdrawal->user;
        $user->balance += $withdrawal->final_amount;
        $user->save();

        $transaction = new Transaction();
        $transaction->user_id = $user->id;
        $transaction->trx = $withdrawal->trx;
        $transaction->amount = $withdrawal->final_amount;
        $transaction->charge = 0;
        $transaction->post_balance = $user->balance;
        $transaction->type = 'credit';
        $transaction->remark = 'withdrawal_reject';
        $transaction->details = 'Withdrawal rejected. Amount refunded.';
        $transaction->save();

        return back()->with('success', 'Withdrawal rejected and amount refunded.');
    }

    public function methods()
    {
        $pageTitle = 'Withdraw Methods';
        $methods = WithdrawMethod::latest()->paginate(getPaginate());
        return view('admin.withdrawals.methods', compact('pageTitle', 'methods'));
    }

    public function methodStore(Request $request, $id = null)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'min_limit' => 'required|numeric|gt:0',
            'max_limit' => 'required|numeric|gt:min_limit',
            'fixed_charge' => 'required|numeric|gte:0',
            'percent_charge' => 'required|numeric|gte:0|max:100',
        ]);
        $method = $id ? WithdrawMethod::findOrFail($id) : new WithdrawMethod();
        $method->name = $request->name;
        $method->description = $request->description;
        $method->min_limit = $request->min_limit;
        $method->max_limit = $request->max_limit;
        $method->fixed_charge = $request->fixed_charge;
        $method->percent_charge = $request->percent_charge;
        $method->currency = $request->currency ?? 'ETB';
        $method->status = $request->status ?? 1;
        $method->save();
        return back()->with('success', 'Method saved.');
    }

    public function toggleMethodStatus($id)
    {
        $method = WithdrawMethod::findOrFail($id);
        $method->status = $method->status == 1 ? 0 : 1;
        $method->save();
        return back()->with('success', 'Method status updated.');
    }

    public function methodDelete($id)
    {
        $method = WithdrawMethod::findOrFail($id);
        $method->delete();
        return back()->with('success', 'Method deleted.');
    }
}
