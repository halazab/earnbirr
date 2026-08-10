@extends('templates.basic.layouts.app')

@section('title', 'Referral Program')

@section('content')
<section class="pt-28 pb-16">
    <div class="max-w-lg mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-8">
            <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-amber-400 to-amber-600 flex items-center justify-center mx-auto mb-4 shadow-lg shadow-amber-200">
                <i class="fas fa-users text-2xl text-white"></i>
            </div>
            <h1 class="text-2xl lg:text-3xl font-bold text-gray-900">Referral Program</h1>
            <p class="text-gray-500 text-sm mt-1">Invite friends and earn {{ showAmount($referralBonus ?? 100) }} per referral</p>
        </div>

        {{-- Stats --}}
        <div class="grid grid-cols-2 gap-4 mb-6">
            <div class="card p-5 text-center">
                <p class="text-3xl font-bold text-gray-900">{{ $referralCount }}</p>
                <p class="text-xs text-gray-500 mt-1">Activated Referrals</p>
            </div>
            <div class="card p-5 text-center">
                <p class="text-3xl font-bold text-gray-900">{{ $referrals->total() }}</p>
                <p class="text-xs text-gray-500 mt-1">Total Registered</p>
            </div>
        </div>

        {{-- Referral Link --}}
        <div class="card p-6 mb-6">
            <h3 class="font-semibold text-gray-900 mb-3">Your Referral Link</h3>
            <p class="text-sm text-gray-500 mb-4">Share this link with friends. They must register using this link for you to earn a referral.</p>
            <div class="flex items-center gap-2">
                <input type="text" value="{{ $referralLink }}" readonly class="form-input text-sm bg-gray-50" id="referral-link">
                <button onclick="copyLink()" class="btn-primary !py-3 !px-5 flex-shrink-0" id="copy-btn">
                    <i class="fas fa-copy"></i> Copy
                </button>
            </div>
        </div>

        {{-- Referral Code --}}
        <div class="card p-6 mb-6">
            <h3 class="font-semibold text-gray-900 mb-3">Your Referral Code</h3>
            <p class="text-sm text-gray-500 mb-4">Share this code with friends who already have an account.</p>
            <div class="flex items-center gap-2">
                <input type="text" value="{{ $user->referral_code }}" readonly class="form-input text-sm bg-gray-50 font-mono text-lg tracking-wider" id="referral-code">
                <button onclick="copyCode()" class="btn-primary !py-3 !px-5 flex-shrink-0">
                    <i class="fas fa-copy"></i> Copy
                </button>
            </div>
        </div>

        {{-- Referral List --}}
        <div class="card p-6">
            <h3 class="font-semibold text-gray-900 mb-4">Your Referrals</h3>
            @if($referrals->count())
                <div class="space-y-3">
                    @foreach($referrals as $ref)
                        <div class="flex items-center justify-between py-3 border-b border-gray-50 last:border-0">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-full bg-gray-100 flex items-center justify-center flex-shrink-0">
                                    <i class="fas fa-user text-gray-400 text-sm"></i>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-900">{{ $ref->referred->firstname ?? '' }} {{ $ref->referred->lastname ?? '' }}</p>
                                    <p class="text-xs text-gray-400">{{ $ref->referred->email ?? '' }}</p>
                                </div>
                            </div>
                            <span class="badge {{ $ref->status == 2 ? 'badge-success' : 'badge-pending' }}">
                                {{ $ref->status == 2 ? 'Activated' : 'Registered' }}
                            </span>
                        </div>
                    @endforeach
                </div>
                <div class="mt-4">
                    {{ $referrals->links() }}
                </div>
            @else
                <p class="text-sm text-gray-400 text-center py-4">No referrals yet. Share your link to get started!</p>
            @endif
        </div>
    </div>
</section>

@push('script')
<script>
    function copyLink() {
        const input = document.getElementById('referral-link');
        input.select();
        document.execCommand('copy');
        const btn = document.getElementById('copy-btn');
        btn.innerHTML = '<i class="fas fa-check"></i> Copied!';
        setTimeout(() => { btn.innerHTML = '<i class="fas fa-copy"></i> Copy'; }, 2000);
    }
    function copyCode() {
        const input = document.getElementById('referral-code');
        input.select();
        document.execCommand('copy');
    }
</script>
@endpush
@endsection
