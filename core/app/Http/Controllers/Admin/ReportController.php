<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Deposit;
use App\Models\TaskSubmission;
use App\Models\Transaction;
use App\Models\User;
use App\Models\Withdrawal;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function transaction()
    {
        $pageTitle = 'Transaction Log';
        $transactions = $this->applyUserSearch(Transaction::query())->with('user')->latest()->paginate(getPaginate());
        return view('admin.reports.transactions', compact('pageTitle', 'transactions'));
    }

    public function loginHistory()
    {
        $pageTitle = 'Login History';
        $logins = $this->applyUserSearch(\App\Models\UserLogin::query())->with('user')->latest()->paginate(getPaginate());
        return view('admin.reports.logins', compact('pageTitle', 'logins'));
    }

    public function notificationHistory()
    {
        $pageTitle = 'Notification History';
        $logs = $this->applyUserSearch(\App\Models\NotificationLog::query())->with('user')->latest()->paginate(getPaginate());
        return view('admin.reports.notifications', compact('pageTitle', 'logs'));
    }

    protected function applyUserSearch($query)
    {
        if ($search = request('search')) {
            $query->where(function ($q) use ($search) {
                if (in_array('trx', $q->getModel()->getFillable())) {
                    $q->where('trx', 'like', "%{$search}%");
                }
                $q->orWhereHas('user', function ($user) use ($search) {
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
}
