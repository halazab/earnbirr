<footer class="bg-gray-900 text-gray-300">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 lg:py-16">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 lg:gap-12">
            <div class="lg:col-span-1">
                <a href="{{ route('user.tasks.index') }}" class="flex items-center gap-2 mb-4">
                    <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-emerald-400 to-emerald-600 flex items-center justify-center">
                        <i class="fas fa-coins text-white text-sm"></i>
                    </div>
                    <span class="text-lg font-extrabold tracking-tight">
                        <span class="text-emerald-400">Earn</span><span class="text-white">Birr</span>
                    </span>
                </a>
                <p class="text-sm text-gray-400 leading-relaxed">{{ gs('footer_text') ?? 'Complete micro-tasks, earn real money. Join thousands of Ethiopians earning from home.' }}</p>
                <div class="flex items-center gap-3 mt-5">
                    @if(gs('social_telegram'))
                    <a href="{{ gs('social_telegram') }}" class="w-9 h-9 rounded-lg bg-gray-800 flex items-center justify-center text-gray-400 hover:bg-emerald-500 hover:text-white transition-all"><i class="fab fa-telegram-plane"></i></a>
                    @endif
                    @if(gs('social_facebook'))
                    <a href="{{ gs('social_facebook') }}" class="w-9 h-9 rounded-lg bg-gray-800 flex items-center justify-center text-gray-400 hover:bg-emerald-500 hover:text-white transition-all"><i class="fab fa-facebook-f"></i></a>
                    @endif
                    @if(gs('social_twitter'))
                    <a href="{{ gs('social_twitter') }}" class="w-9 h-9 rounded-lg bg-gray-800 flex items-center justify-center text-gray-400 hover:bg-emerald-500 hover:text-white transition-all"><i class="fab fa-twitter"></i></a>
                    @endif
                    @if(gs('social_instagram'))
                    <a href="{{ gs('social_instagram') }}" class="w-9 h-9 rounded-lg bg-gray-800 flex items-center justify-center text-gray-400 hover:bg-emerald-500 hover:text-white transition-all"><i class="fab fa-instagram"></i></a>
                    @endif
                </div>
            </div>

            <div>
                <h4 class="text-white font-semibold text-sm uppercase tracking-wider mb-4">{{ __('messages.about') }}</h4>
                <ul class="space-y-3">
                    <li><a href="{{ route('home') }}" class="text-sm text-gray-400 hover:text-emerald-400 transition-colors">{{ __('messages.home') }}</a></li>
                    <li><a href="{{ route('about') }}" class="text-sm text-gray-400 hover:text-emerald-400 transition-colors">About Us</a></li>
                    <li><a href="{{ route('user.tasks.index') }}" class="text-sm text-gray-400 hover:text-emerald-400 transition-colors">{{ __('messages.task_browse') }}</a></li>
                    <li><a href="{{ route('contact') }}" class="text-sm text-gray-400 hover:text-emerald-400 transition-colors">{{ __('messages.contact') }}</a></li>
                    <li><a href="{{ route('user.register') }}" class="text-sm text-gray-400 hover:text-emerald-400 transition-colors">{{ __('messages.get_started') }}</a></li>
                </ul>
            </div>

            <div>
                <h4 class="text-white font-semibold text-sm uppercase tracking-wider mb-4">{{ __('messages.support') }}</h4>
                <ul class="space-y-3">
                    <li><a href="{{ route('faq') }}" class="text-sm text-gray-400 hover:text-emerald-400 transition-colors">{{ __('messages.faq') }}</a></li>
                    <li><a href="{{ route('support') }}" class="text-sm text-gray-400 hover:text-emerald-400 transition-colors">Help Center</a></li>
                    <li><a href="{{ route('contact') }}" class="text-sm text-gray-400 hover:text-emerald-400 transition-colors">{{ __('messages.contact') }}</a></li>
                    @auth
                        <li><a href="{{ route('user.ticket.index') }}" class="text-sm text-gray-400 hover:text-emerald-400 transition-colors">{{ __('messages.support') }}</a></li>
                    @endauth
                    <li><a href="{{ route('privacy') }}" class="text-sm text-gray-400 hover:text-emerald-400 transition-colors">{{ __('messages.privacy') }}</a></li>
                    <li><a href="{{ route('terms') }}" class="text-sm text-gray-400 hover:text-emerald-400 transition-colors">{{ __('messages.terms') }}</a></li>
                </ul>
            </div>

            <div>
                <h4 class="text-white font-semibold text-sm uppercase tracking-wider mb-4">{{ __('messages.contact') }}</h4>
                <ul class="space-y-3">
                    <li class="flex items-start gap-3 text-sm text-gray-400">
                        <i class="fas fa-map-marker-alt mt-1 text-emerald-400"></i>
                        {{ gs('footer_address') ?? 'Addis Ababa, Ethiopia' }}
                    </li>
                    <li class="flex items-start gap-3 text-sm text-gray-400">
                        <i class="fas fa-envelope mt-1 text-emerald-400"></i>
                        {{ gs('footer_email') ?? 'support@earnethio.com' }}
                    </li>
                    <li class="flex items-start gap-3 text-sm text-gray-400">
                        <i class="fas fa-phone mt-1 text-emerald-400"></i>
                        {{ gs('footer_phone') ?? '+251 9XX XXX XXXX' }}
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <div class="border-t border-gray-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            <p class="text-center text-sm text-gray-500">
                &copy; {{ date('Y') }} <span class="text-emerald-400">{{ gs('site_name') }}</span>. {{ __('messages.all_rights') }}
            </p>
        </div>
    </div>
</footer>
