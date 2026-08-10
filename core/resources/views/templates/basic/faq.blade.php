@extends('templates.basic.layouts.app')

@section('title', $pageTitle)

@section('content')
<section class="pt-28 pb-16">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-8">
            <h1 class="text-2xl lg:text-3xl font-bold text-gray-900">Frequently Asked Questions</h1>
            <p class="text-gray-500 text-sm mt-1">Find answers to common questions</p>
        </div>

        <div class="space-y-4" x-data="{ open: null }">
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
            <div class="card overflow-hidden">
                <button @click="open === {{ $i }} ? open = null : open = {{ $i }}" class="w-full flex items-center justify-between p-5 text-left hover:bg-gray-50 transition-colors">
                    <span class="text-sm font-medium text-gray-900 pr-4">{{ $faq['q'] }}</span>
                    <i class="fas fa-chevron-down text-gray-400 text-xs transition-transform duration-200" :class="open === {{ $i }} ? 'rotate-180' : ''"></i>
                </button>
                <div x-show="open === {{ $i }}" x-collapse x-cloak>
                    <div class="px-5 pb-5 text-sm text-gray-600 leading-relaxed border-t border-gray-50 pt-4">
                        {{ $faq['a'] }}
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endsection
