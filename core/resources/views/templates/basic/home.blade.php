@extends('templates.basic.layouts.app')

@section('title', 'Home')

@section('content')

{{-- Hero Section --}}
<section class="relative min-h-screen flex items-center pt-20 pb-16 overflow-hidden">
    <div class="absolute inset-0 bg-gradient-to-br from-emerald-50 via-white to-blue-50 -z-10"></div>
    <div class="absolute top-20 left-10 w-72 h-72 bg-emerald-200/30 rounded-full blur-3xl -z-10"></div>
    <div class="absolute bottom-20 right-10 w-96 h-96 bg-blue-200/30 rounded-full blur-3xl -z-10"></div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full">
        <div class="grid lg:grid-cols-2 gap-12 items-center">
            <div class="text-center lg:text-left">
                <div class="inline-flex items-center gap-2 bg-emerald-100 text-emerald-700 rounded-full px-4 py-1.5 text-sm font-medium mb-6">
                    <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                    Now Hiring Active Workers
                </div>
                <h1 class="text-4xl sm:text-5xl lg:text-6xl font-extrabold text-gray-900 leading-tight tracking-tight">
                    Earn Money by Completing
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-emerald-500 to-blue-500">Micro-Tasks</span>
                </h1>
                <p class="mt-6 text-lg text-gray-600 leading-relaxed max-w-xl mx-auto lg:mx-0">
                    Join thousands of Ethiopians earning real money from home. Complete simple tasks, get paid instantly.
                </p>
                <div class="flex flex-wrap items-center gap-4 mt-8 justify-center lg:justify-start">
                    <a href="{{ route('user.register') }}" class="btn-primary text-base !py-4 !px-8">
                        Get Started <i class="fas fa-arrow-right"></i>
                    </a>
                    <a href="{{ route('user.tasks.index') }}" class="btn-outline text-base !py-4 !px-8">
                        Browse Tasks <i class="fas fa-eye"></i>
                    </a>
                </div>
                <div class="flex items-center gap-8 mt-10 justify-center lg:justify-start">
                    <div>
                        <p class="text-2xl font-bold text-gray-900">10K+</p>
                        <p class="text-sm text-gray-500">Active Users</p>
                    </div>
                    <div class="w-px h-10 bg-gray-200"></div>
                    <div>
                        <p class="text-2xl font-bold text-gray-900">50K+</p>
                        <p class="text-sm text-gray-500">Tasks Done</p>
                    </div>
                    <div class="w-px h-10 bg-gray-200"></div>
                    <div>
                        <p class="text-2xl font-bold text-gray-900">Br 2M+</p>
                        <p class="text-sm text-gray-500">Earned</p>
                    </div>
                </div>
            </div>
            <div class="hidden lg:flex justify-center">
                <div class="w-96 h-96 bg-gradient-to-br from-emerald-400 to-blue-500 rounded-3xl rotate-6 shadow-2xl flex items-center justify-center">
                    <div class="w-80 h-80 bg-white/20 rounded-2xl -rotate-6 flex items-center justify-center">
                        <i class="fas fa-coins text-8xl text-white/80"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- Features Section --}}
<section class="py-16 lg:py-24">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-2xl mx-auto mb-12 lg:mb-16">
            <h2 class="text-3xl sm:text-4xl font-bold text-gray-900">How You Can Earn</h2>
            <p class="mt-4 text-gray-600">Choose from a variety of task categories and start earning today.</p>
        </div>
        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6 lg:gap-8">
            <div class="card p-6 lg:p-8 text-center group hover:-translate-y-1">
                <div class="w-16 h-16 rounded-2xl bg-emerald-100 flex items-center justify-center mx-auto mb-5 group-hover:bg-emerald-500 transition-colors">
                    <i class="fab fa-facebook text-2xl text-emerald-500 group-hover:text-white transition-colors"></i>
                </div>
                <h3 class="text-lg font-bold text-gray-900 mb-2">Social Tasks</h3>
                <p class="text-sm text-gray-500 leading-relaxed">Like, share, follow, and comment on social media platforms. Earn quick rewards.</p>
            </div>
            <div class="card p-6 lg:p-8 text-center group hover:-translate-y-1">
                <div class="w-16 h-16 rounded-2xl bg-blue-100 flex items-center justify-center mx-auto mb-5 group-hover:bg-blue-500 transition-colors">
                    <i class="fas fa-poll text-2xl text-blue-500 group-hover:text-white transition-colors"></i>
                </div>
                <h3 class="text-lg font-bold text-gray-900 mb-2">Surveys</h3>
                <p class="text-sm text-gray-500 leading-relaxed">Share your opinion through paid surveys and market research studies.</p>
            </div>
            <div class="card p-6 lg:p-8 text-center group hover:-translate-y-1">
                <div class="w-16 h-16 rounded-2xl bg-purple-100 flex items-center justify-center mx-auto mb-5 group-hover:bg-purple-500 transition-colors">
                    <i class="fas fa-laptop-code text-2xl text-purple-500 group-hover:text-white transition-colors"></i>
                </div>
                <h3 class="text-lg font-bold text-gray-900 mb-2">Freelance Gigs</h3>
                <p class="text-sm text-gray-500 leading-relaxed">Data entry, content writing, graphic design, and more freelance opportunities.</p>
            </div>
        </div>
    </div>
</section>

{{-- How It Works --}}
<section class="py-16 lg:py-24 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-2xl mx-auto mb-12 lg:mb-16">
            <h2 class="text-3xl sm:text-4xl font-bold text-gray-900">How It Works</h2>
            <p class="mt-4 text-gray-600">Start earning in just 4 simple steps.</p>
        </div>
        <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-6 lg:gap-8">
            <div class="text-center relative">
                <div class="w-16 h-16 rounded-2xl bg-emerald-500 text-white flex items-center justify-center mx-auto mb-4 text-xl font-bold shadow-lg shadow-emerald-200">1</div>
                <h3 class="text-lg font-bold text-gray-900 mb-2">Register</h3>
                <p class="text-sm text-gray-500">Create your free account with your basic details.</p>
            </div>
            <div class="text-center relative">
                <div class="hidden lg:block absolute top-8 left-[60%] w-[80%] h-0.5 border-t-2 border-dashed border-emerald-200"></div>
                <div class="w-16 h-16 rounded-2xl bg-blue-500 text-white flex items-center justify-center mx-auto mb-4 text-xl font-bold shadow-lg shadow-blue-200">2</div>
                <h3 class="text-lg font-bold text-gray-900 mb-2">Activate</h3>
                <p class="text-sm text-gray-500">Pay a one-time activation fee to unlock all tasks.</p>
            </div>
            <div class="text-center relative">
                <div class="hidden lg:block absolute top-8 left-[60%] w-[80%] h-0.5 border-t-2 border-dashed border-emerald-200"></div>
                <div class="w-16 h-16 rounded-2xl bg-amber-500 text-white flex items-center justify-center mx-auto mb-4 text-xl font-bold shadow-lg shadow-amber-200">3</div>
                <h3 class="text-lg font-bold text-gray-900 mb-2">Complete Tasks</h3>
                <p class="text-sm text-gray-500">Browse and complete available micro-tasks.</p>
            </div>
            <div class="text-center relative">
                <div class="hidden lg:block absolute top-8 left-[60%] w-[80%] h-0.5 border-t-2 border-dashed border-emerald-200"></div>
                <div class="w-16 h-16 rounded-2xl bg-purple-500 text-white flex items-center justify-center mx-auto mb-4 text-xl font-bold shadow-lg shadow-purple-200">4</div>
                <h3 class="text-lg font-bold text-gray-900 mb-2">Withdraw</h3>
                <p class="text-sm text-gray-500">Withdraw your earnings to mobile money or bank.</p>
            </div>
        </div>
    </div>
</section>

{{-- Stats Counter --}}
<section class="py-16 lg:py-24 bg-gradient-to-r from-emerald-500 to-emerald-600">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-8 text-center">
            <div>
                <p class="text-4xl lg:text-5xl font-extrabold text-white counter" data-target="10520">0</p>
                <p class="mt-2 text-emerald-100 text-sm font-medium">Registered Users</p>
            </div>
            <div>
                <p class="text-4xl lg:text-5xl font-extrabold text-white counter" data-target="52840">0</p>
                <p class="mt-2 text-emerald-100 text-sm font-medium">Tasks Completed</p>
            </div>
            <div>
                <p class="text-4xl lg:text-5xl font-extrabold text-white counter" data-target="2340">0</p>
                <p class="mt-2 text-emerald-100 text-sm font-medium">Active Workers</p>
            </div>
            <div>
                <p class="text-4xl lg:text-5xl font-extrabold text-white counter" data-target="1850000">0</p>
                <p class="mt-2 text-emerald-100 text-sm font-medium">Birr Paid Out</p>
            </div>
        </div>
    </div>
</section>

{{-- FAQ Section --}}
<section class="py-16 lg:py-24">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl sm:text-4xl font-bold text-gray-900">Frequently Asked Questions</h2>
            <p class="mt-4 text-gray-600">Find answers to common questions about our platform.</p>
        </div>
        <div class="space-y-4" x-data="{active: null}">
            @php
                $faqs = [
                    ['q' => 'What is EarnBirr?', 'a' => 'EarnBirr is an online platform designed to help users earn money by completing micro-tasks and participating in reward programs.'],
                    ['q' => 'Why is there a pre-registration fee?', 'a' => 'The 250 ETB pre-registration fee secures your account, activates your membership, and gives you immediate access to earning tasks.'],
                    ['q' => 'Can I pay using any payment method or channel?', 'a' => 'You can send the pre-registration fee through the active payment methods and official channels provided on our platform checkout page.'],
                    ['q' => 'What should I write in the TeleBirr description/remark?', 'a' => 'Please write "EarnBirr Pre-reg" as the reason or remark when sending the money.'],
                    ['q' => 'What should I do after making the payment?', 'a' => 'Take a screenshot of the receipt or copy your Transaction ID, then submit it through the form on our website.'],
                    ['q' => 'How long does it take for my account to be activated?', 'a' => 'Once your payment and transaction details are verified, your account will be activated promptly.'],
                    ['q' => 'Can I use someone else\'s TeleBirr account to pay?', 'a' => 'Yes, you can, but make sure to submit the correct Transaction ID and receipt belonging to that payment so we can verify it.'],
                    ['q' => 'Is the pre-registration fee refundable?', 'a' => 'No, the pre-registration fee covers account setup and activation costs and is non-refundable.'],
                    ['q' => 'What kind of tasks will I find on EarnBirr?', 'a' => 'You will find various micro-tasks and earning opportunities that you can complete directly through your dashboard.'],
                    ['q' => 'How can I get help if I face issues?', 'a' => 'If you encounter any problems with payment or your account, you can reach out to our support team for quick assistance.'],
                ];
            @endphp
            @foreach($faqs as $i => $faq)
                <div class="card overflow-hidden" x-data="{open: false}">
                    <button @click="open = !open" class="w-full flex items-center justify-between p-5 lg:p-6 text-left">
                        <span class="font-medium text-gray-900 pr-4">{{ $faq['q'] }}</span>
                        <i class="fas fa-chevron-down text-gray-400 transition-transform duration-300" :class="{'rotate-180': open}"></i>
                    </button>
                    <div x-show="open" x-collapse class="px-5 lg:px-6 pb-5 lg:pb-6">
                        <p class="text-sm text-gray-500 leading-relaxed">{{ $faq['a'] }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

{{-- CTA Section --}}
<section class="py-16 lg:py-24">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="card p-8 lg:p-12 text-center bg-gradient-to-br from-emerald-500 to-blue-600 text-white">
            <h2 class="text-3xl sm:text-4xl font-bold mb-4">Ready to Start Earning?</h2>
            <p class="text-emerald-50/90 text-lg mb-8 max-w-lg mx-auto">Join thousands of Ethiopians earning real money from home. Sign up today and start your first task.</p>
            <a href="{{ route('user.register') }}" class="inline-flex items-center gap-2 bg-white text-emerald-600 font-bold px-8 py-4 rounded-xl hover:bg-emerald-50 transition-colors shadow-lg">
                Create Free Account <i class="fas fa-arrow-right"></i>
            </a>
        </div>
    </div>
</section>

@push('script')
<script>
    function animateCounters() {
        document.querySelectorAll('.counter').forEach(counter => {
            const target = parseInt(counter.dataset.target);
            const duration = 2000;
            const step = Math.ceil(target / (duration / 16));
            let current = 0;
            const update = () => {
                current += step;
                if (current >= target) {
                    counter.textContent = target.toLocaleString();
                    return;
                }
                counter.textContent = current.toLocaleString();
                requestAnimationFrame(update);
            };
            update();
        });
    }
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) { animateCounters(); observer.disconnect(); }
        });
    });
    document.addEventListener('DOMContentLoaded', () => {
        const section = document.querySelector('.counter')?.closest('section');
        if (section) observer.observe(section);
    });
</script>
@endpush
@endsection
