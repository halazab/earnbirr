<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Deposit;
use App\Models\DepositMethod;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;

class DepositController extends Controller
{
    public function index()
    {
        $pageTitle = 'Deposit Funds';
        $methods = DepositMethod::active()->get();
        return view('templates.basic.user.payment.deposit', compact('pageTitle', 'methods'));
    }

    public function insert(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|gt:0',
            'method_id' => 'required|exists:deposit_methods,id',
            'reference_code' => 'nullable|string',
        ]);

        $method = DepositMethod::findOrFail($request->method_id);
        if ($request->amount < $method->min_amount || $request->amount > $method->max_amount) {
            return back()->withErrors(['amount' => 'Amount must be between ' . showAmount($method->min_amount) . ' and ' . showAmount($method->max_amount)]);
        }

        $user = auth()->user();
        $charge = $method->fixed_charge + ($request->amount * $method->percent_charge / 100);
        $finalAmount = $request->amount + $charge;

        $deposit = new Deposit();
        $deposit->user_id = $user->id;
        $deposit->trx = 'DP' . time() . rand(1000, 9999);
        $deposit->amount = $request->amount;
        $deposit->charge = $charge;
        $deposit->final_amount = $finalAmount;
        $deposit->gateway = $method->name;
        $deposit->method = $method->name;
        $deposit->reference_code = $request->reference_code;
        $deposit->status = 0;
        $deposit->save();

        return redirect()->route('user.deposit.history')->with('success', 'Deposit request submitted. Your request is pending approval.');
    }

    public function activationFee()
    {
        $user = auth()->user();
        if ($user->activation_fee_paid) {
            return redirect()->route('user.tasks.index');
        }
        $pageTitle = 'Account Activation';
        $fee = gs('activation_fee');
        $methods = DepositMethod::active()->get();
        $pendingDeposit = Deposit::where('user_id', $user->id)
            ->where('reference_code', 'activation')
            ->where('status', 0)
            ->latest()
            ->first();
        return view('templates.basic.user.payment.activation', compact('pageTitle', 'fee', 'methods', 'pendingDeposit'));
    }

    public function activationFeeSubmit(Request $request)
    {
        $request->validate([
            'method_id' => 'required|exists:deposit_methods,id',
            'reference_code' => 'nullable|string',
            'receipt' => 'nullable|file|max:5120',
        ]);

        $method = DepositMethod::findOrFail($request->method_id);
        $user = auth()->user();
        $fee = gs('activation_fee');
        $receiptId = null;
        $receiptData = null;
        $receiptType = null;
        if ($request->hasFile('receipt')) {
            $file = $request->file('receipt');
            $receiptId = uploadFile($file);
            $receiptData = base64_encode(file_get_contents($file->getRealPath()));
            $receiptType = $file->getMimeType();
        }

        $deposit = new Deposit();
        $deposit->user_id = $user->id;
        $deposit->trx = 'ACT' . time() . rand(1000, 9999);
        $deposit->amount = $fee;
        $deposit->charge = 0;
        $deposit->final_amount = $fee;
        $deposit->gateway = $method->name;
        $deposit->method = $method->name;
        $deposit->reference_code = 'activation';
        $deposit->information = json_encode(['ref_code' => $request->reference_code, 'receipt_id' => $receiptId]);
        $deposit->status = 0;
        $deposit->save();

        $message = "<b>🏆 NEW ACTIVATION FEE SUBMISSION</b>\n"
            . "─────────────────────\n"
            . "👤 <b>User:</b> " . ($user->name ?? 'N/A') . "\n"
            . "📧 <b>Email:</b> " . $user->email . "\n"
            . "📱 <b>Phone:</b> " . ($user->mobile ?? 'N/A') . "\n"
            . "💳 <b>Method:</b> " . $method->name . "\n"
            . "💰 <b>Amount:</b> " . showAmount($fee) . "\n"
            . "🔖 <b>Reference:</b> " . ($request->reference_code ?: 'N/A') . "\n"
            . "🧾 <b>Trx:</b> " . $deposit->trx;

        if ($receiptData) {
            sendTelegramMessage($message, $receiptData, $receiptType);
        } else {
            sendTelegramMessage($message);
        }

        return redirect()->route('user.tasks.index')->with('success', 'Activation fee submitted. Waiting for admin approval.');
    }
}
