<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Deposit;
use App\Models\DepositMethod;
use App\Models\Referral;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;

class DepositController extends Controller
{
    public function all()
    {
        $pageTitle = 'All Deposits';
        $deposits = $this->applySearch(Deposit::regular())->with('user')->latest()->paginate(getPaginate());
        return view('admin.deposits.index', compact('pageTitle', 'deposits'));
    }

    public function pending()
    {
        $pageTitle = 'Pending Deposits';
        $deposits = $this->applySearch(Deposit::regular()->pending())->with('user')->latest()->paginate(getPaginate());
        return view('admin.deposits.index', compact('pageTitle', 'deposits'));
    }

    public function approved()
    {
        $pageTitle = 'Approved Deposits';
        $deposits = $this->applySearch(Deposit::regular()->approved())->with('user')->latest()->paginate(getPaginate());
        return view('admin.deposits.index', compact('pageTitle', 'deposits'));
    }

    public function rejected()
    {
        $pageTitle = 'Rejected Deposits';
        $deposits = $this->applySearch(Deposit::regular()->rejected())->with('user')->latest()->paginate(getPaginate());
        return view('admin.deposits.index', compact('pageTitle', 'deposits'));
    }

    public function activation()
    {
        $pageTitle = 'Activation Fees';
        $deposits = $this->applySearch(Deposit::activation())->with('user');
        if (request('status') == 'pending') {
            $pageTitle = 'Pending Activation Fees';
            $deposits = $deposits->pending();
        } elseif (request('status') == 'approved') {
            $pageTitle = 'Approved Activation Fees';
            $deposits = $deposits->approved();
        } elseif (request('status') == 'rejected') {
            $pageTitle = 'Rejected Activation Fees';
            $deposits = $deposits->rejected();
        }
        $deposits = $deposits->latest()->paginate(getPaginate());
        return view('admin.deposits.activation', compact('pageTitle', 'deposits'));
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

    public function activationApprove($id)
    {
        $deposit = Deposit::findOrFail($id);
        if ($deposit->status != 0) {
            return back()->withErrors(['Already processed.']);
        }
        $deposit->status = 1;
        $deposit->save();

        $user = $deposit->user;
        $user->activation_fee_paid = 1;
        $user->activation_trx = $deposit->trx;
        $user->save();

        $transaction = new Transaction();
        $transaction->user_id = $user->id;
        $transaction->trx = $deposit->trx;
        $transaction->amount = $deposit->amount;
        $transaction->charge = $deposit->charge;
        $transaction->post_balance = $user->balance;
        $transaction->type = 'debit';
        $transaction->remark = 'activation_fee';
        $transaction->details = 'Account activation fee via ' . $deposit->gateway;
        $transaction->save();

        if ($user->referred_by) {
            $referrer = User::find($user->referred_by);
            if ($referrer) {
                $referral = Referral::where('referrer_id', $referrer->id)
                    ->where('referred_id', $user->id)
                    ->first();

                if ($referral && $referral->status != 2) {
                    $bonus = gs('referral_bonus') ?? 100;
                    $referrer->balance += $bonus;
                    $referrer->total_earned += $bonus;
                    $referrer->save();

                    $referral->status = 2;
                    $referral->save();

                    $trx = 'TRX' . time() . rand(1000, 9999);
                    Transaction::create([
                        'user_id' => $referrer->id,
                        'trx' => $trx,
                        'amount' => $bonus,
                        'charge' => 0,
                        'post_balance' => $referrer->balance,
                        'type' => 'credit',
                        'remark' => 'referral_bonus',
                        'details' => 'Referral bonus for inviting ' . $user->email,
                    ]);
                }
            }
        }

        return back()->with('success', 'Account activated successfully.');
    }

    public function details($id)
    {
        $pageTitle = 'Deposit Details';
        $deposit = Deposit::with('user')->findOrFail($id);
        return view('admin.deposits.details', compact('pageTitle', 'deposit'));
    }

    public function approve($id)
    {
        $deposit = Deposit::regular()->findOrFail($id);
        if ($deposit->status != 0) {
            return back()->withErrors(['Deposit already processed.']);
        }
        $deposit->status = 1;
        $deposit->save();

        $user = $deposit->user;
        $user->balance += $deposit->final_amount;
        $user->save();

        $transaction = new Transaction();
        $transaction->user_id = $user->id;
        $transaction->trx = $deposit->trx;
        $transaction->amount = $deposit->amount;
        $transaction->charge = $deposit->charge;
        $transaction->post_balance = $user->balance;
        $transaction->type = 'credit';
        $transaction->remark = 'deposit';
        $transaction->details = 'Deposit via ' . $deposit->gateway;
        $transaction->save();

        return back()->with('success', 'Deposit approved successfully.');
    }

    public function reject(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:deposits,id',
            'admin_feedback' => 'required|string',
        ]);
        $deposit = Deposit::findOrFail($request->id);
        $deposit->status = 2;
        $deposit->admin_feedback = $request->admin_feedback;
        $deposit->save();
        return back()->with('success', 'Deposit rejected.');
    }

    public function methods()
    {
        $pageTitle = 'Deposit Methods';
        $methods = DepositMethod::latest()->paginate(getPaginate());
        return view('admin.deposits.methods', compact('pageTitle', 'methods'));
    }

    public function methodStore(Request $request, $id = null)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone_number' => 'nullable|string|max:20',
            'min_amount' => 'required|numeric|gt:0',
            'max_amount' => 'required|numeric|gt:min_amount',
            'fixed_charge' => 'required|numeric|gte:0',
            'percent_charge' => 'required|numeric|gte:0|max:100',
            'description' => 'nullable|string',
            'currency' => 'required|string|max:10',
        ]);

        $method = $id ? DepositMethod::findOrFail($id) : new DepositMethod();
        $method->name = $request->name;
        $method->phone_number = $request->phone_number;
        $method->min_amount = $request->min_amount;
        $method->max_amount = $request->max_amount;
        $method->fixed_charge = $request->fixed_charge;
        $method->percent_charge = $request->percent_charge;
        $method->description = $request->description;
        $method->currency = $request->currency;

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $method->image = $file->getClientOriginalName();
            $method->image_data = base64_encode(file_get_contents($file->getRealPath()));
            $method->image_type = $file->getMimeType();
        }

        $method->save();
        $message = $id ? 'Deposit method updated.' : 'Deposit method created.';
        return back()->with('success', $message);
    }

    public function methodToggleStatus($id)
    {
        $method = DepositMethod::findOrFail($id);
        $method->status = $method->status == 1 ? 0 : 1;
        $method->save();
        $message = $method->status == 1 ? 'Deposit method activated.' : 'Deposit method deactivated.';
        return back()->with('success', $message);
    }

    public function methodDelete($id)
    {
        $method = DepositMethod::findOrFail($id);
        $method->delete();
        return back()->with('success', 'Deposit method deleted.');
    }
}
