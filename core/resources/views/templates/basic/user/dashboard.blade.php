@extends('templates.basic.layouts.app')

@section('title', 'Dashboard')

@section('content')
<section class="pt-28 pb-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- User Info --}}
        <div class="mb-6">
            <div class="flex items-center gap-3">
                <div class="w-12 h-12 rounded-full bg-primary flex items-center justify-center text-white flex-shrink-0">
                    <i class="fas fa-user text-lg"></i>
                </div>
                <div>
                    <p class="text-base font-bold text-gray-900">{{ auth()->user()->username ?? auth()->user()->email }}</p>
                </div>
            </div>
        </div>

        {{-- Balance Card --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5 mb-6">
            <div class="flex items-center gap-4 mb-5">
                <div class="flex-1">
                    <p class="text-sm text-gray-500 font-medium">{{ __('messages.balance') }}</p>
                    <p class="text-2xl font-bold text-gray-900 mt-1">{{ showAmount(auth()->user()->balance) }}</p>
                </div>
                <a href="{{ route('user.deposit.index') }}" class="bg-primary hover:bg-primary-dark text-white text-sm font-bold px-6 py-3 rounded-xl transition-all flex items-center gap-2">
                    <i class="fas fa-arrow-down text-xs"></i> {{ __('messages.deposit') }}
                </a>
                <a href="{{ route('user.withdraw.index') }}" class="bg-primary hover:bg-primary-dark text-white text-sm font-bold px-6 py-3 rounded-xl transition-all flex items-center gap-2">
                    <i class="fas fa-arrow-up text-xs"></i> {{ __('messages.withdraw') }}
                </a>
            </div>

            <div class="border-t border-gray-100 pt-4 space-y-2.5">
                <div class="flex items-center justify-between">
                    <span class="text-sm text-gray-500">Total Balance</span>
                    <span class="text-sm font-bold text-primary">{{ showAmount(auth()->user()->balance) }}</span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-sm text-gray-500">{{ __('messages.total_earned') }}</span>
                    <span class="text-sm font-bold text-gray-900">{{ showAmount(auth()->user()->total_earned ?? 0) }}</span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-sm text-gray-500">{{ __('messages.total_withdrawn') ?? 'Withdrawable' }}</span>
                    <span class="text-sm font-bold text-gray-900">{{ showAmount(auth()->user()->total_withdrawn ?? 0) }}</span>
                </div>
            </div>
        </div>

        {{-- Alerts --}}
        @if(gs('kv') && !auth()->user()->kv)
            <div class="flex items-start gap-3 bg-amber-50 border border-amber-200 rounded-xl p-4 mb-6">
                <i class="fas fa-exclamation-triangle text-amber-500 mt-0.5"></i>
                <div>
                    <p class="text-sm font-medium text-amber-800">{{ __('messages.kyc_required') }}</p>
                    <p class="text-xs text-amber-600 mt-0.5">{{ __('messages.kyc_required_desc') }}</p>
                </div>
                <a href="{{ route('user.kyc') }}" class="ml-auto text-sm font-medium text-amber-700 hover:text-amber-800 whitespace-nowrap">{{ __('messages.verify_now') }}</a>
            </div>
        @endif

        @if(!auth()->user()->is_activated)
            <div class="flex items-start gap-3 bg-blue-50 border border-blue-200 rounded-xl p-4 mb-6">
                <i class="fas fa-rocket text-blue-500 mt-0.5"></i>
                <div>
                    <p class="text-sm font-medium text-blue-800">{{ __('messages.account_not_activated') }}</p>
                    <p class="text-xs text-blue-600 mt-0.5">{{ __('messages.activate_account') }}</p>
                </div>
                <a href="{{ route('user.activation') }}" class="ml-auto text-sm font-medium text-blue-700 hover:text-blue-800 whitespace-nowrap">{{ __('messages.activate_now') }}</a>
            </div>
        @endif

        @if(auth()->user()->balance < gs('min_withdraw'))
            <div class="flex items-start gap-3 bg-red-50 border border-red-200 rounded-xl p-4 mb-6">
                <i class="fas fa-wallet text-red-500 mt-0.5"></i>
                <div>
                    <p class="text-sm font-medium text-red-800">{{ __('messages.low_balance') }}</p>
                    <p class="text-xs text-red-600 mt-0.5">{{ __('messages.low_balance_desc', ['amount' => showAmount(gs('min_withdraw'))]) }}</p>
                </div>
            </div>
        @endif

        {{-- Quick Stats --}}
        <div class="grid grid-cols-3 gap-4 mb-6">
            <div class="card p-4 text-center">
                <p class="text-2xl font-bold text-gray-900">{{ $approvedTasks ?? 0 }}</p>
                <p class="text-xs text-gray-500 mt-1">{{ __('messages.completed') }}</p>
            </div>
            <div class="card p-4 text-center">
                <p class="text-2xl font-bold text-gray-900">{{ $pendingTasks ?? 0 }}</p>
                <p class="text-xs text-gray-500 mt-1">{{ __('messages.pending_review') }}</p>
            </div>
            <div class="card p-4 text-center">
                <p class="text-2xl font-bold text-gray-900">{{ $totalTasks ?? 0 }}</p>
                <p class="text-xs text-gray-500 mt-1">{{ __('messages.total') }}</p>
            </div>
        </div>

        {{-- Daily Claim --}}
        @php
            $nextStreak = $todayClaim ? $claimStreak + 1 : 1;
            $nextMultiplier = min(1 + ($nextStreak - 1) * 0.25, 10);
            $nextReward = gs('daily_claim_reward') * $nextMultiplier;
        @endphp
        @if(!$todayClaim)
            <div class="card p-5 mb-6">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-11 h-11 rounded-xl bg-amber-100 flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-gift text-amber-500"></i>
                        </div>
                        <div>
                            <p class="text-sm font-bold text-gray-900">{{ __('messages.daily_claim') }}</p>
                            <p class="text-xs text-emerald-500 font-semibold">{{ showAmount($nextReward) }} ({{ number_format($nextMultiplier, 2) }}x)</p>
                        </div>
                    </div>
                    <form method="POST" action="{{ route('user.daily.claim') }}">
                        @csrf
                        <button type="submit" class="btn-primary !py-2.5 !px-5 !text-sm">
                            <i class="fas fa-hand-pointer"></i> {{ __('messages.claim_now') }}
                        </button>
                    </form>
                </div>
                @if($claimStreak > 0)
                    <div class="mt-3 pt-3 border-t border-gray-100">
                        <div class="flex items-center justify-between text-xs text-gray-500">
                            <span>Current streak: <strong>{{ $claimStreak }} day(s)</strong></span>
                            <span>Next: <strong class="text-emerald-500">{{ number_format($nextMultiplier, 2) }}x</strong></span>
                        </div>
                        <div class="mt-2 w-full bg-gray-100 rounded-full h-2">
                            <div class="bg-amber-400 h-2 rounded-full transition-all" style="width: {{ min($claimStreak / 40 * 100, 100) }}%"></div>
                        </div>
                        <p class="text-xs text-gray-400 mt-1">Increases 25% daily. Max 10x at Day 40.</p>
                    </div>
                @endif
            </div>
        @else
            <div class="card p-5 mb-6">
                <div class="flex items-center gap-3">
                    <div class="w-11 h-11 rounded-xl bg-emerald-100 flex items-center justify-center flex-shrink-0">
                        <i class="fas fa-check-circle text-emerald-500"></i>
                    </div>
                    <div>
                        <p class="text-sm font-bold text-gray-900">{{ __('messages.claimed_today') }}</p>
                        @if($claimStreak > 0)
                            <p class="text-xs text-gray-500">{{ __('messages.claim_streak_desc', ['count' => $claimStreak]) }}</p>
                        @endif
                    </div>
                </div>
            </div>
        @endif

        {{-- Menu Items (card-based like inspiration) --}}
        <div class="card divide-y divide-gray-50 mb-6">
            <a href="{{ route('user.deposit.index') }}" class="flex items-center gap-4 px-5 py-4 hover:bg-gray-50 transition-colors rounded-t-2xl">
                <div class="w-10 h-10 rounded-xl bg-emerald-100 flex items-center justify-center flex-shrink-0">
                    <i class="fas fa-wallet text-emerald-500 text-sm"></i>
                </div>
                <div class="flex-1">
                    <span class="text-sm font-medium text-gray-700 block">Deposit Funds</span>
                    <span class="text-xs text-gray-400">Add money to your wallet via TeleBirr</span>
                </div>
                <i class="fas fa-chevron-right text-xs text-gray-300"></i>
            </a>
            <a href="{{ route('user.withdraw.index') }}" class="flex items-center gap-4 px-5 py-4 hover:bg-gray-50 transition-colors">
                <div class="w-10 h-10 rounded-xl bg-blue-100 flex items-center justify-center flex-shrink-0">
                    <i class="fas fa-money-bill-wave text-blue-500 text-sm"></i>
                </div>
                <div class="flex-1">
                    <span class="text-sm font-medium text-gray-700 block">Withdraw Earnings</span>
                    <span class="text-xs text-gray-400">Cash out your earned balance</span>
                </div>
                <i class="fas fa-chevron-right text-xs text-gray-300"></i>
            </a>
            <a href="{{ route('user.tasks.index') }}" class="flex items-center gap-4 px-5 py-4 hover:bg-gray-50 transition-colors">
                <div class="w-10 h-10 rounded-xl bg-amber-100 flex items-center justify-center flex-shrink-0">
                    <i class="fas fa-bolt text-amber-500 text-sm"></i>
                </div>
                <div class="flex-1">
                    <span class="text-sm font-medium text-gray-700 block">Browse Tasks</span>
                    <span class="text-xs text-gray-400">Find and complete tasks to earn</span>
                </div>
                <i class="fas fa-chevron-right text-xs text-gray-300"></i>
            </a>
            <a href="{{ route('user.deposit.history') }}" class="flex items-center gap-4 px-5 py-4 hover:bg-gray-50 transition-colors">
                <div class="w-10 h-10 rounded-xl bg-indigo-100 flex items-center justify-center flex-shrink-0">
                    <i class="fas fa-receipt text-indigo-500 text-sm"></i>
                </div>
                <div class="flex-1">
                    <span class="text-sm font-medium text-gray-700 block">Deposit History</span>
                    <span class="text-xs text-gray-400">View your deposit transactions</span>
                </div>
                <i class="fas fa-chevron-right text-xs text-gray-300"></i>
            </a>
            <a href="{{ route('user.transactions') }}" class="flex items-center gap-4 px-5 py-4 hover:bg-gray-50 transition-colors">
                <div class="w-10 h-10 rounded-xl bg-cyan-100 flex items-center justify-center flex-shrink-0">
                    <i class="fas fa-history text-cyan-500 text-sm"></i>
                </div>
                <div class="flex-1">
                    <span class="text-sm font-medium text-gray-700 block">Transaction History</span>
                    <span class="text-xs text-gray-400">Track all your earnings and spending</span>
                </div>
                <i class="fas fa-chevron-right text-xs text-gray-300"></i>
            </a>
            <a href="{{ route('user.tasks.my') }}" class="flex items-center gap-4 px-5 py-4 hover:bg-gray-50 transition-colors">
                <div class="w-10 h-10 rounded-xl bg-purple-100 flex items-center justify-center flex-shrink-0">
                    <i class="fas fa-clipboard-check text-purple-500 text-sm"></i>
                </div>
                <div class="flex-1">
                    <span class="text-sm font-medium text-gray-700 block">My Submissions</span>
                    <span class="text-xs text-gray-400">Check status of submitted tasks</span>
                </div>
                <i class="fas fa-chevron-right text-xs text-gray-300"></i>
            </a>
            <a href="{{ route('user.profile.setting') }}" class="flex items-center gap-4 px-5 py-4 hover:bg-gray-50 transition-colors">
                <div class="w-10 h-10 rounded-xl bg-rose-100 flex items-center justify-center flex-shrink-0">
                    <i class="fas fa-user-cog text-rose-500 text-sm"></i>
                </div>
                <div class="flex-1">
                    <span class="text-sm font-medium text-gray-700 block">Profile Settings</span>
                    <span class="text-xs text-gray-400">Update your personal information</span>
                </div>
                <i class="fas fa-chevron-right text-xs text-gray-300"></i>
            </a>
            <a href="{{ route('user.referral.index') }}" class="flex items-center gap-4 px-5 py-4 hover:bg-gray-50 transition-colors">
                <div class="w-10 h-10 rounded-xl bg-pink-100 flex items-center justify-center flex-shrink-0">
                    <i class="fas fa-user-plus text-pink-500 text-sm"></i>
                </div>
                <div class="flex-1">
                    <span class="text-sm font-medium text-gray-700 block">Referrals</span>
                    <span class="text-xs text-gray-400">Invite friends and earn rewards</span>
                </div>
                <i class="fas fa-chevron-right text-xs text-gray-300"></i>
            </a>
            <a href="{{ route('user.kyc') }}" class="flex items-center gap-4 px-5 py-4 hover:bg-gray-50 transition-colors">
                <div class="w-10 h-10 rounded-xl bg-teal-100 flex items-center justify-center flex-shrink-0">
                    <i class="fas fa-shield-alt text-teal-500 text-sm"></i>
                </div>
                <div class="flex-1">
                    <span class="text-sm font-medium text-gray-700 block">KYC Verification</span>
                    <span class="text-xs text-gray-400">Verify your identity for full access</span>
                </div>
                <i class="fas fa-chevron-right text-xs text-gray-300"></i>
            </a>
            <a href="{{ route('faq') }}" class="flex items-center gap-4 px-5 py-4 hover:bg-gray-50 transition-colors">
                <div class="w-10 h-10 rounded-xl bg-orange-100 flex items-center justify-center flex-shrink-0">
                    <i class="fas fa-question-circle text-orange-500 text-sm"></i>
                </div>
                <div class="flex-1">
                    <span class="text-sm font-medium text-gray-700 block">FAQ</span>
                    <span class="text-xs text-gray-400">Frequently asked questions</span>
                </div>
                <i class="fas fa-chevron-right text-xs text-gray-300"></i>
            </a>
            <a href="{{ route('user.ticket.index') }}" class="flex items-center gap-4 px-5 py-4 hover:bg-gray-50 transition-colors rounded-b-2xl">
                <div class="w-10 h-10 rounded-xl bg-red-100 flex items-center justify-center flex-shrink-0">
                    <i class="fas fa-headset text-red-500 text-sm"></i>
                </div>
                <div class="flex-1">
                    <span class="text-sm font-medium text-gray-700 block">Support</span>
                    <span class="text-xs text-gray-400">Get help from our support team</span>
                </div>
                <i class="fas fa-chevron-right text-xs text-gray-300"></i>
            </a>
        </div>

        {{-- Available Tasks & Recent Transactions --}}
        <div class="grid lg:grid-cols-2 gap-6 lg:gap-8 mb-8">
            <div class="card p-6">
                <div class="flex items-center justify-between mb-5">
                    <h2 class="text-lg font-bold text-gray-900">{{ __('messages.available_tasks') }}</h2>
                    <a href="{{ route('user.tasks.index') }}" class="text-sm text-emerald-500 hover:text-emerald-600 font-medium">{{ __('messages.view_all') }}</a>
                </div>
                @if(isset($availableTasks) && $availableTasks->count())
                    <div class="space-y-3">
                        @foreach($availableTasks as $task)
                            <a href="{{ route('user.tasks.details', $task->slug) }}" class="flex items-center justify-between py-2 border-b border-gray-50 last:border-0 hover:bg-gray-50 rounded-lg px-2 -mx-2 transition-colors">
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-medium text-gray-900 truncate">{{ $task->title }}</p>
                                    <p class="text-xs text-gray-400">{{ $task->category->name ?? 'General' }} | {{ __('messages.slots_left', ['count' => $task->remaining_slots ?? 0]) }}</p>
                                </div>
                                <div class="text-right ml-3 flex-shrink-0">
                                    <p class="text-sm font-bold text-emerald-500">{{ showAmount($task->reward) }}</p>
                                </div>
                            </a>
                        @endforeach
                    </div>
                @else
                    <p class="text-sm text-gray-400 text-center py-6">{{ __('messages.no_tasks') }}</p>
                @endif
            </div>

            <div class="card p-6">
                <div class="flex items-center justify-between mb-5">
                    <h2 class="text-lg font-bold text-gray-900">{{ __('messages.recent_transactions') }}</h2>
                    <a href="{{ route('user.transactions') }}" class="text-sm text-emerald-500 hover:text-emerald-600 font-medium">{{ __('messages.view_all') }}</a>
                </div>
                @if(isset($recentTransactions) && $recentTransactions->count())
                    <div class="space-y-3">
                        @foreach($recentTransactions as $trx)
                            <div class="flex items-center justify-between py-2 border-b border-gray-50 last:border-0">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-lg {{ $trx->type == 'credit' ? 'bg-emerald-100' : 'bg-red-100' }} flex items-center justify-center">
                                        <i class="fas {{ $trx->type == 'credit' ? 'fa-arrow-up text-emerald-500' : 'fa-arrow-down text-red-500' }} text-xs"></i>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-gray-900">{{ $trx->remark }}</p>
                                        <p class="text-xs text-gray-400">{{ showDateTime($trx->created_at) }}</p>
                                    </div>
                                </div>
                                <span class="text-sm font-bold {{ $trx->type == 'credit' ? 'text-emerald-500' : 'text-red-500' }}">
                                    {{ $trx->type == 'credit' ? '+' : '-' }}{{ showAmount($trx->amount) }}
                                </span>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-sm text-gray-400 text-center py-6">{{ __('messages.no_transactions') }}</p>
                @endif
            </div>
        </div>

        {{-- Daily Claim Streak Info --}}
        @if($claimStreak > 0)
            <div class="card p-6">
                <div class="flex flex-col sm:flex-row items-center gap-4">
                    <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-amber-400 to-amber-600 flex items-center justify-center">
                        <i class="fas fa-fire text-white text-xl"></i>
                    </div>
                    <div class="flex-1 text-center sm:text-left">
                        <h3 class="font-bold text-gray-900">{{ __('messages.claim_streak') }}</h3>
                        <p class="text-sm text-gray-500">{{ __('messages.claim_streak_desc', ['count' => $claimStreak]) }}</p>
                        <p class="text-xs text-emerald-500 font-semibold mt-1">Current: {{ number_format(1 + ($claimStreak - 1) * 0.25, 2) }}x multiplier</p>
                    </div>
                    <div class="flex items-center gap-1">
                        @php
                            $currentMultiplier = min(1 + ($claimStreak - 1) * 0.25, 10);
                        @endphp
                        @for($i = 1; $i <= min($claimStreak, 10); $i++)
                            @php $m = min(1 + ($i - 1) * 0.25, 10); @endphp
                            <div class="w-8 h-8 rounded-lg {{ $i <= $claimStreak ? 'bg-emerald-500 text-white' : 'bg-gray-100 text-gray-400' }} flex items-center justify-center text-[10px] font-bold" title="Day {{ $i }}: {{ number_format($m, 2) }}x">
                                {{ $i }}
                            </div>
                        @endfor
                    </div>
                </div>
            </div>
        @endif
    </div>
</section>
@endsection
