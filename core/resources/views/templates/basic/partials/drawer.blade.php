@auth
@php
    $todayClaimed = \App\Models\DailyClaim::where('user_id', auth()->id())->whereDate('created_at', today())->exists();
@endphp
<div id="drawer-overlay" class="fixed inset-0 bg-black/50 z-[60] hidden" onclick="closeDrawer()"></div>
<div id="drawer-panel" class="fixed top-0 right-0 h-full w-[300px] bg-white z-[70] shadow-2xl transform translate-x-full transition-transform duration-300 flex flex-col overflow-hidden">

    {{-- Header --}}
    <div class="flex items-center gap-2 px-4 pt-4 pb-3 border-b border-gray-100">
        <div class="w-8 h-8 rounded-full bg-emerald-100 flex items-center justify-center flex-shrink-0">
            <i class="fas fa-user text-emerald-500 text-xs"></i>
        </div>
        <p class="text-[11px] font-bold text-gray-900 truncate flex-1">{{ auth()->user()->mobile ?? auth()->user()->email }}</p>
        @if(!$todayClaimed)
        <form method="POST" action="{{ route('user.daily.claim') }}" class="flex-shrink-0">
            @csrf
            <button type="submit" class="bg-amber-500 hover:bg-amber-600 text-white text-[10px] font-bold px-2.5 py-1 rounded transition-colors whitespace-nowrap">
                <i class="fas fa-gift mr-0.5"></i> Claim
            </button>
        </form>
        @else
        <span class="text-[10px] text-emerald-500 font-medium flex-shrink-0"><i class="fas fa-check mr-0.5"></i> Claimed</span>
        @endif
        <button onclick="closeDrawer()" class="w-7 h-7 rounded-full bg-gray-100 flex items-center justify-center text-gray-500 hover:bg-gray-200 transition-colors flex-shrink-0">
            <i class="fas fa-times text-xs"></i>
        </button>
    </div>

    {{-- Balance + Buttons --}}
    <div class="px-4 py-3 border-b border-gray-100">
        <div class="flex items-center justify-between mb-2">
            <div>
                <p class="text-[10px] text-gray-400">Balance</p>
                <p class="text-sm font-bold text-gray-900">{{ showAmount(auth()->user()->balance) }}</p>
            </div>
            <div class="flex gap-2">
                <a href="{{ route('user.deposit.index') }}" class="bg-emerald-500 hover:bg-emerald-600 text-white text-[10px] font-bold px-3 py-1.5 rounded transition-colors">DEPOSIT</a>
                <a href="{{ route('user.withdraw.index') }}" class="bg-emerald-500 hover:bg-emerald-600 text-white text-[10px] font-bold px-3 py-1.5 rounded transition-colors">WITHDRAW</a>
            </div>
        </div>
        <div class="grid grid-cols-2 gap-x-4 gap-y-0.5 text-[10px]">
            <span class="text-gray-400">Bonus</span><span class="text-right text-gray-900">0.00 ETB</span>
            <span class="text-emerald-500 font-medium">Total</span><span class="text-right text-emerald-500 font-medium">{{ showAmount(auth()->user()->balance) }}</span>
            <span class="text-gray-400">Withdrawable</span><span class="text-right text-gray-900">{{ showAmount(auth()->user()->balance) }}</span>
        </div>
    </div>

    {{-- Menu Items --}}
    <div class="flex-1 overflow-y-auto">
        <nav class="py-1">
            <a href="{{ route('user.home') }}" class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-700 hover:bg-emerald-50 hover:text-emerald-600 transition-colors">
                <i class="fas fa-home w-5 text-center text-gray-400"></i> Dashboard
            </a>
            <a href="{{ route('user.tasks.index') }}" class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-700 hover:bg-emerald-50 hover:text-emerald-600 transition-colors">
                <i class="fas fa-tasks w-5 text-center text-gray-400"></i> Tasks
            </a>
            <a href="{{ route('user.deposit.index') }}" class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-700 hover:bg-emerald-50 hover:text-emerald-600 transition-colors">
                <i class="fas fa-wallet w-5 text-center text-gray-400"></i> Deposit
            </a>
            <a href="{{ route('user.deposit.history') }}" class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-700 hover:bg-emerald-50 hover:text-emerald-600 transition-colors">
                <i class="fas fa-history w-5 text-center text-gray-400"></i> Account History
            </a>
            <a href="{{ route('user.profile.setting') }}" class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-700 hover:bg-emerald-50 hover:text-emerald-600 transition-colors">
                <i class="fas fa-user w-5 text-center text-gray-400"></i> Profile
            </a>
            <a href="{{ route('user.tasks.my') }}" class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-700 hover:bg-emerald-50 hover:text-emerald-600 transition-colors">
                <i class="fas fa-clipboard-list w-5 text-center text-gray-400"></i> My Submissions
            </a>
            <a href="{{ route('user.transactions') }}" class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-700 hover:bg-emerald-50 hover:text-emerald-600 transition-colors">
                <i class="fas fa-exchange-alt w-5 text-center text-gray-400"></i> Transactions
            </a>
            <a href="{{ route('user.referral.index') }}" class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-700 hover:bg-emerald-50 hover:text-emerald-600 transition-colors">
                <i class="fas fa-share-alt w-5 text-center text-gray-400"></i> Referrals
            </a>
        </nav>
    </div>

    {{-- Language --}}
    <div class="px-4 py-2 border-t border-gray-100">
        <div class="relative" x-data="{ open: false }">
            <button @click="open = !open" class="w-full flex items-center justify-center gap-2 px-3 py-2 rounded-lg text-xs font-medium text-gray-600 bg-gray-100 hover:bg-gray-200 transition-colors">
                <span>🇬🇧</span> English <i class="fas fa-chevron-down text-[10px] text-gray-400"></i>
            </button>
            <div x-show="open" @click.away="open = false" x-transition class="absolute bottom-full left-0 mb-2 bg-white rounded-xl shadow-lg border border-gray-100 py-1.5 min-w-full z-50">
                @foreach(config('app.locales') as $code => $name)
                    <a href="{{ route('lang', $code) }}" class="block px-4 py-2 text-sm text-gray-600 hover:text-emerald-500 hover:bg-gray-50 transition-colors {{ session('locale') == $code ? 'text-emerald-500 font-medium' : '' }}">
                        {{ $name }}
                    </a>
                @endforeach
            </div>
        </div>
    </div>

    {{-- Logout --}}
    <div class="px-4 pb-2">
        <form method="POST" action="{{ route('user.logout') }}">
            @csrf
            <button type="submit" class="w-full flex items-center justify-center gap-2 bg-emerald-500 hover:bg-emerald-600 text-white font-semibold py-2.5 rounded transition-colors text-sm">
                <i class="fas fa-sign-out-alt"></i> Logout
            </button>
        </form>
    </div>

    {{-- Live Chat --}}
    <div class="px-4 pb-2">
        <a href="{{ route('user.ticket.index') }}" class="flex items-center justify-center gap-2 bg-gray-100 rounded-lg px-3 py-2 text-xs font-medium text-gray-700 hover:bg-emerald-50 hover:text-emerald-600 transition-colors">
            <i class="fas fa-headset"></i> LIVE CHAT
        </a>
    </div>

    {{-- Social --}}
    <div class="px-4 pb-3 text-center">
        <p class="text-[10px] text-emerald-500 font-medium mb-1.5">Follow Us!</p>
        <div class="flex justify-center gap-2">
            @if(gs('social_telegram'))
            <a href="{{ gs('social_telegram') }}" class="w-7 h-7 rounded-full bg-gray-200 flex items-center justify-center text-gray-500 hover:bg-emerald-500 hover:text-white transition-all"><i class="fab fa-telegram-plane text-xs"></i></a>
            @endif
            @if(gs('social_facebook'))
            <a href="{{ gs('social_facebook') }}" class="w-7 h-7 rounded-full bg-gray-200 flex items-center justify-center text-gray-500 hover:bg-emerald-500 hover:text-white transition-all"><i class="fab fa-facebook-f text-xs"></i></a>
            @endif
            @if(gs('social_twitter'))
            <a href="{{ gs('social_twitter') }}" class="w-7 h-7 rounded-full bg-gray-200 flex items-center justify-center text-gray-500 hover:bg-emerald-500 hover:text-white transition-all"><i class="fab fa-twitter text-xs"></i></a>
            @endif
            @if(gs('social_instagram'))
            <a href="{{ gs('social_instagram') }}" class="w-7 h-7 rounded-full bg-gray-200 flex items-center justify-center text-gray-500 hover:bg-emerald-500 hover:text-white transition-all"><i class="fab fa-instagram text-xs"></i></a>
            @endif
        </div>
    </div>
</div>
@endauth
