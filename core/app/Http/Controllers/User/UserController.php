<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\DailyClaim;
use App\Models\Deposit;
use App\Models\Task;
use App\Models\TaskSubmission;
use App\Models\Transaction;
use App\Models\Withdrawal;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function home()
    {
        $pageTitle = 'Dashboard';
        $user = auth()->user();
        $successfulDeposits = $user->deposits()->where('status', 1)->sum('amount');
        $pendingDeposits = $user->deposits()->where('status', 0)->sum('amount');
        $successfulWithdrawals = $user->withdrawals()->where('status', 1)->sum('amount');
        $pendingWithdrawals = $user->withdrawals()->where('status', 0)->sum('amount');
        $totalTasks = $user->taskSubmissions()->count();
        $pendingTasks = $user->taskSubmissions()->where('status', 0)->count();
        $approvedTasks = $user->taskSubmissions()->where('status', 1)->count();
        $recentTransactions = $user->transactions()->latest()->take(5)->get();
        $availableTasks = Task::available()->with('category')->latest()->take(6)->get();
        $todayClaim = DailyClaim::where('user_id', $user->id)->whereDate('created_at', today())->first();
        $yesterdayClaim = DailyClaim::where('user_id', $user->id)->whereDate('created_at', today()->subDay())->first();
        $claimStreak = $todayClaim?->streak ?? ($yesterdayClaim?->streak ?? 0);
        $activatedReferrals = $user->activatedReferrals()->count();

        return view('templates.basic.user.dashboard', compact(
            'pageTitle', 'user', 'successfulDeposits', 'pendingDeposits',
            'successfulWithdrawals', 'pendingWithdrawals',
            'totalTasks', 'pendingTasks', 'approvedTasks',
            'recentTransactions', 'availableTasks', 'todayClaim', 'claimStreak',
            'activatedReferrals'
        ));
    }

    public function transactions()
    {
        $pageTitle = 'Transactions';
        $transactions = auth()->user()->transactions()->latest()->paginate(getPaginate());
        return view('templates.basic.user.transactions', compact('pageTitle', 'transactions'));
    }

    public function depositHistory()
    {
        $pageTitle = 'Deposit History';
        $deposits = auth()->user()->deposits()->latest()->paginate(getPaginate());
        return view('templates.basic.user.deposit_history', compact('pageTitle', 'deposits'));
    }

    public function downloadAttachment($fileHash)
    {
        return back();
    }
}
