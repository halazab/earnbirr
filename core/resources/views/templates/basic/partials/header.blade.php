<header class="fixed top-0 left-0 w-full z-50 glass border-b border-gray-100/50">
    <div class="max-w-7xl mx-auto pl-2 pr-4 sm:pl-3 sm:pr-6 lg:px-8">
        <div class="flex items-center justify-between h-16 lg:h-20">
            <div class="flex items-center gap-3">
                <a href="{{ route('user.tasks.index') }}" class="flex items-center gap-2">
                    <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-emerald-400 to-emerald-600 flex items-center justify-center shadow-md shadow-emerald-200">
                        <i class="fas fa-coins text-white text-sm"></i>
                    </div>
                    <span class="text-lg font-extrabold tracking-tight">
                        <span class="text-emerald-500">Earn</span><span class="text-gray-800">Birr</span>
                    </span>
                </a>
            </div>

            <nav class="hidden lg:flex items-center gap-8">
                @auth
                    <a href="{{ route('user.home') }}" class="text-sm font-medium text-gray-600 hover:text-emerald-500 transition-colors {{ request()->routeIs('user.home') ? 'text-emerald-500' : '' }}">{{ __('messages.dashboard') }}</a>
                @endauth
                <a href="{{ route('user.tasks.index') }}" class="text-sm font-medium text-gray-600 hover:text-emerald-500 transition-colors {{ request()->routeIs('user.tasks.*') ? 'text-emerald-500' : '' }}">{{ __('messages.tasks') }}</a>
                <a href="{{ route('faq') }}" class="text-sm font-medium text-gray-600 hover:text-emerald-500 transition-colors {{ request()->routeIs('faq') ? 'text-emerald-500' : '' }}">FAQ</a>
                <a href="{{ route('about') }}" class="text-sm font-medium text-gray-600 hover:text-emerald-500 transition-colors {{ request()->routeIs('about') ? 'text-emerald-500' : '' }}">About</a>
                @auth
                    <a href="{{ route('user.profile.setting') }}" class="text-sm font-medium text-gray-600 hover:text-emerald-500 transition-colors {{ request()->routeIs('user.profile.setting') ? 'text-emerald-500' : '' }}">{{ __('messages.profile') }}</a>
                @endauth
                <div class="relative group">
                    <button class="flex items-center gap-1.5 text-sm font-medium text-gray-600 hover:text-emerald-500 transition-colors">
                        <i class="fas fa-globe text-xs"></i>
                        {{ __('messages.language') }}
                        <i class="fas fa-chevron-down text-[10px]"></i>
                    </button>
                    <div class="absolute right-0 top-full mt-1 bg-white rounded-xl shadow-lg border border-gray-100 py-1.5 min-w-[140px] opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-50">
                        @foreach(config('app.locales') as $code => $name)
                            <a href="{{ route('lang', $code) }}" class="block px-4 py-2 text-sm text-gray-600 hover:text-emerald-500 hover:bg-gray-50 transition-colors {{ session('locale') == $code ? 'text-emerald-500 font-medium' : '' }}">
                                {{ $name }}
                            </a>
                        @endforeach
                    </div>
                </div>
            </nav>

            <div class="hidden lg:flex items-center gap-3">
                @auth
                    <a href="{{ route('user.deposit.index') }}" class="btn-primary text-sm !py-2 !px-5">
                        <i class="fas fa-arrow-down"></i> {{ __('messages.deposit') }}
                    </a>
                    <a href="{{ route('user.withdraw.index') }}" class="btn-primary text-sm !py-2 !px-5">
                        <i class="fas fa-arrow-up"></i> {{ __('messages.withdraw') }}
                    </a>
                    <form method="POST" action="{{ route('user.logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="text-sm font-medium text-gray-500 hover:text-red-500 transition-colors">
                            <i class="fas fa-sign-out-alt"></i> {{ __('messages.logout') }}
                        </button>
                    </form>
                @else
                    <a href="{{ route('user.login') }}" class="text-sm font-medium text-gray-600 hover:text-emerald-500 transition-colors">{{ __('messages.login') }}</a>
                    <a href="{{ route('user.register') }}" class="btn-primary text-sm !py-2 !px-5">
                        {{ __('messages.get_started') }} <i class="fas fa-arrow-right"></i>
                    </a>
                @endauth
            </div>

            @auth
            <button onclick="openDrawer()" class="w-10 h-10 flex items-center justify-center rounded-lg text-gray-600 hover:bg-gray-100 transition-colors lg:hidden">
                <i class="fas fa-bars text-xl"></i>
            </button>
            @else
            <div class="flex items-center gap-2 lg:hidden">
                <a href="{{ route('user.login') }}" class="text-sm font-medium text-gray-600 px-3 py-2">{{ __('messages.login') }}</a>
                <a href="{{ route('user.register') }}" class="btn-primary text-sm !py-2 !px-4">{{ __('messages.get_started') }}</a>
            </div>
            @endauth
        </div>
    </div>
</header>

@include('templates.basic.partials.drawer')

<script>
    function openDrawer() {
        document.getElementById('drawer-overlay').classList.remove('hidden');
        document.getElementById('drawer-panel').classList.remove('translate-x-full');
        document.body.style.overflow = 'hidden';
    }
    function closeDrawer() {
        document.getElementById('drawer-overlay').classList.add('hidden');
        document.getElementById('drawer-panel').classList.add('translate-x-full');
        document.body.style.overflow = '';
    }
</script>
