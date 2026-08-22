<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Deposit;
use App\Models\Task;
use App\Models\TaskSubmission;
use App\Models\User;
use App\Models\Withdrawal;
use App\Models\DailyClaim;
use App\Models\GeneralSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function dashboard()
    {
        $pageTitle = 'Dashboard';
        $widget = [
            'total_users' => User::count(),
            'active_users' => User::where('status', 1)->count(),
            'activated_users' => User::where('activation_fee_paid', 1)->count(),
            'banned_users' => User::where('status', 0)->count(),
            'total_tasks' => Task::count(),
            'active_tasks' => Task::where('status', 1)->count(),
            'total_submissions' => TaskSubmission::count(),
            'pending_submissions' => TaskSubmission::where('status', 0)->count(),
        ];
        $totalDeposits = Deposit::where('status', 1)->sum('amount');
        $totalWithdrawals = Withdrawal::where('status', 1)->sum('amount');
        $pendingWithdrawals = Withdrawal::where('status', 0)->count();
        $pendingDeposits = Deposit::where('status', 0)->count();
        $recentUsers = User::latest()->take(5)->get();
        $recentSubmissions = TaskSubmission::with(['user', 'task'])->latest()->take(5)->get();
        $monthlyEarnings = TaskSubmission::where('status', 1)
            ->whereMonth('created_at', now()->month)
            ->sum('task_id');

        $todayClaims = DailyClaim::whereDate('created_at', today())->count();
        $totalClaims = DailyClaim::count();
        $totalClaimRewards = DailyClaim::sum('reward');

        return view('admin.dashboard', compact(
            'pageTitle', 'widget', 'totalDeposits', 'totalWithdrawals',
            'pendingWithdrawals', 'pendingDeposits',
            'recentUsers', 'recentSubmissions', 'monthlyEarnings',
            'todayClaims', 'totalClaims', 'totalClaimRewards'
        ));
    }

    public function profile()
    {
        $pageTitle = 'Profile';
        $admin = Auth::guard('admin')->user();
        return view('admin.profile', compact('pageTitle', 'admin'));
    }

    public function profileUpdate(Request $request)
    {
        $admin = Auth::guard('admin')->user();
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:admins,email,' . $admin->id,
        ]);
        $admin->name = $request->name;
        $admin->email = $request->email;
        if ($request->hasFile('image')) {
            $admin->image = $request->file('image')->store('admin', 'public');
        }
        $admin->save();
        return back()->with('success', 'Profile updated successfully.');
    }

    public function password()
    {
        $pageTitle = 'Change Password';
        return view('admin.password', compact('pageTitle'));
    }

    public function passwordUpdate(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|min:6|confirmed',
        ]);
        $admin = Auth::guard('admin')->user();
        if (!Hash::check($request->current_password, $admin->password)) {
            return back()->withErrors(['Current password is incorrect.']);
        }
        $admin->password = Hash::make($request->password);
        $admin->save();
        return back()->with('success', 'Password changed successfully.');
    }

    public function notifications()
    {
        $pageTitle = 'Notifications';
        return view('admin.notifications', compact('pageTitle'));
    }

    public function notificationRead($id)
    {
        return back()->with('success', 'Notification marked as read.');
    }

    public function notificationDelete($id)
    {
        return back()->with('success', 'Notification deleted.');
    }

    public function regenerateTaskPrices()
    {
        $setting = GeneralSetting::first();
        $min = (int) ($setting->task_reward_min ?? 30);
        $max = (int) ($setting->task_reward_max ?? 50);

        if ($min > $max) {
            return back()->withErrors(['Minimum reward cannot be greater than maximum.']);
        }

        $count = Task::query()->update([
            'reward' => DB::raw("FLOOR({$min} + RAND() * " . ($max - $min + 1) . ")"),
        ]);

        return back()->with('success', "All {$count} task prices regenerated between {$min}–{$max} ETB.");
    }
}
