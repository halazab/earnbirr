@extends('templates.basic.layouts.app')

@section('title', 'Withdraw')

@section('content')
<section class="pt-28 pb-16">
    <div class="max-w-lg mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-6">
            <h1 class="text-2xl lg:text-3xl font-bold text-gray-900">Withdraw Funds</h1>
            <p class="text-gray-500 text-sm mt-1">Cash out your earnings</p>
        </div>

        {{-- Balance Card --}}
        <div class="card p-5 mb-4 text-center">
            <p class="text-sm text-gray-500">Available Balance</p>
            <p class="text-3xl font-bold text-emerald-500 mt-1">{{ showAmount(auth()->user()->balance) }}</p>
        </div>

        {{-- Referral Requirement --}}
        @if($activatedReferrals < $requiredReferrals)
        <div class="card p-4 mb-4 border-amber-200 bg-amber-50">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-amber-100 flex items-center justify-center flex-shrink-0">
                    <i class="fas fa-lock text-amber-500"></i>
                </div>
                <div class="flex-1">
                    <p class="text-sm font-medium text-gray-900">Referral Required</p>
                    <p class="text-xs text-gray-500">You need {{ $requiredReferrals - $activatedReferrals }} more activated referral(s) to unlock withdrawals</p>
                </div>
                <div class="text-right">
                    <p class="text-lg font-bold text-amber-600">{{ $activatedReferrals }}/{{ $requiredReferrals }}</p>
                </div>
            </div>
            <a href="{{ route('user.referral.index') }}" class="mt-3 block text-center text-xs font-medium text-amber-700 bg-white border border-amber-300 rounded-lg py-2 hover:bg-amber-100 transition-colors">
                <i class="fas fa-share-alt mr-1"></i> Invite Friends to Unlock
            </a>
        </div>
        @endif

        {{-- Withdraw Form --}}
        <div class="card overflow-hidden">
            @forelse($methods as $m)
            <div class="border-b border-gray-100 last:border-b-0">
                {{-- Method Header --}}
                <div class="p-5 text-center">
                    @if($m->image_data)
                        <img src="data:{{ $m->image_type }};base64,{{ $m->image_data }}" class="h-10 mx-auto mb-2 object-contain" alt="{{ $m->name }}">
                    @elseif(stripos($m->name, 'telebirr') !== false)
                        <div class="flex items-center justify-center gap-2 mb-2">
                            @include('templates.basic.partials.telebirr-logo')
                            <span class="text-xl font-bold text-gray-900">TeleBirr</span>
                        </div>
                    @else
                        <div class="w-12 h-12 rounded-xl bg-gray-100 flex items-center justify-center mx-auto mb-2">
                            <i class="fas fa-money-bill text-gray-500 text-xl"></i>
                        </div>
                    @endif
                </div>

                {{-- Info Table --}}
                <div class="divide-y divide-gray-100 text-center text-sm">
                    <div class="py-3">
                        <p class="text-gray-500">Service Fee</p>
                        <p class="font-medium text-gray-900">Free</p>
                    </div>
                    <div class="py-3">
                        <p class="text-gray-500">Process Time</p>
                        <p class="font-medium text-gray-900">Instant</p>
                    </div>
                </div>

                {{-- Withdraw Form --}}
                <form method="POST" action="{{ route('user.withdraw.store') }}" class="p-5">
                    @csrf
                    <input type="hidden" name="method_id" value="{{ $m->id }}">

                    <div class="mb-4">
                        <label class="form-label font-medium text-gray-900">Amount (ETB)</label>
                        <input type="number" step="0.01" name="amount" class="form-input text-center text-lg font-bold" placeholder="Enter amount" min="{{ gs('min_withdraw') }}" max="{{ min(gs('max_withdraw'), auth()->user()->balance) }}" required {{ $activatedReferrals < $requiredReferrals ? 'disabled' : '' }}>
                        <p class="text-xs text-gray-400 mt-1 text-center">Min: {{ showAmount(gs('min_withdraw')) }} | Max: {{ showAmount(min(gs('max_withdraw'), auth()->user()->balance)) }}</p>
                    </div>

                    <div class="mb-4">
                        <label class="form-label font-medium text-gray-900">Your TeleBirr Number</label>
                        <input type="text" name="account_info" class="form-input" placeholder="e.g. 912345678" required {{ $activatedReferrals < $requiredReferrals ? 'disabled' : '' }}>
                        <p class="text-xs text-gray-400 mt-1">Enter the phone number linked to your TeleBirr account</p>
                    </div>

                    <button type="submit" class="w-full bg-emerald-500 hover:bg-emerald-600 text-white font-bold py-4 rounded-xl transition-colors text-base {{ $activatedReferrals < $requiredReferrals ? 'opacity-50 cursor-not-allowed' : '' }}" {{ $activatedReferrals < $requiredReferrals ? 'disabled' : '' }}>
                        <i class="fas fa-paper-plane mr-2"></i> WITHDRAW
                    </button>
                </form>
            </div>
            @empty
            <div class="p-8 text-center text-gray-400">
                <i class="fas fa-wallet text-3xl mb-3"></i>
                <p>No withdrawal methods available right now.</p>
            </div>
            @endforelse
        </div>
    </div>
</section>
@endsection
