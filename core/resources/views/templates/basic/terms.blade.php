@extends('templates.basic.layouts.app')

@section('title', $pageTitle)

@section('content')
<section class="pt-28 pb-16">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-8">
            <h1 class="text-2xl lg:text-3xl font-bold text-gray-900">Terms & Conditions</h1>
            <p class="text-gray-500 text-sm mt-1">Last updated: {{ $content && $content->data_values->updated_at ? date('F d, Y', strtotime($content->data_values->updated_at)) : date('F d, Y') }}</p>
        </div>

        <div class="card p-6 lg:p-8">
            @if($content && $content->data_values->content)
                <div class="prose prose-sm max-w-none text-gray-600 leading-relaxed">
                    {!! $content->data_values->content !!}
                </div>
            @else
                <div class="space-y-6 text-sm text-gray-600 leading-relaxed">
                    <div>
                        <h2 class="text-lg font-bold text-gray-900 mb-2">1. Acceptance of Terms</h2>
                        <p>By accessing and using EarnBirr ("the Platform"), you agree to be bound by these Terms and Conditions. If you do not agree with any part of these terms, you may not use our services.</p>
                    </div>
                    <div>
                        <h2 class="text-lg font-bold text-gray-900 mb-2">2. Eligibility</h2>
                        <p>You must be at least 18 years of age to use EarnBirr. By using the Platform, you represent and warrant that you meet this age requirement and have the legal capacity to enter into binding agreements.</p>
                    </div>
                    <div>
                        <h2 class="text-lg font-bold text-gray-900 mb-2">3. Account Registration</h2>
                        <p>To access earning features, you must create an account and pay a one-time pre-registration fee of 250 ETB. This fee activates your membership and grants access to available tasks. You are responsible for maintaining the confidentiality of your account credentials.</p>
                    </div>
                    <div>
                        <h2 class="text-lg font-bold text-gray-900 mb-2">4. Pre-Registration Fee</h2>
                        <p>The 250 ETB pre-registration fee is non-refundable. It covers account setup, activation, and platform maintenance costs. Payment must be made through the official payment methods provided on the Platform.</p>
                    </div>
                    <div>
                        <h2 class="text-lg font-bold text-gray-900 mb-2">5. Earning & Tasks</h2>
                        <p>EarnBirr provides micro-tasks including but not limited to social media engagement, surveys, app testing, and freelance gigs. Task rewards are set by the platform and may vary. You must complete tasks honestly and provide accurate proof of completion.</p>
                    </div>
                    <div>
                        <h2 class="text-lg font-bold text-gray-900 mb-2">6. Withdrawals</h2>
                        <p>Withdrawals are processed via TeleBirr or other available payment methods. Minimum withdrawal amounts apply. You must have at least 3 activated referrals to be eligible for withdrawals. Processing time is typically 24-48 hours.</p>
                    </div>
                    <div>
                        <h2 class="text-lg font-bold text-gray-900 mb-2">7. Prohibited Activities</h2>
                        <p>You may not: submit false or misleading proof, use multiple accounts, manipulate the referral system, engage in fraud, or violate any applicable laws. Violation may result in account suspension or termination without notice.</p>
                    </div>
                    <div>
                        <h2 class="text-lg font-bold text-gray-900 mb-2">8. Account Termination</h2>
                        <p>EarnBirr reserves the right to suspend or terminate accounts that violate these terms. Upon termination, any pending withdrawals may be cancelled, and access to the Platform will be revoked.</p>
                    </div>
                    <div>
                        <h2 class="text-lg font-bold text-gray-900 mb-2">9. Limitation of Liability</h2>
                        <p>EarnBirr shall not be held liable for any indirect, incidental, or consequential damages arising from your use of the Platform. We do not guarantee uninterrupted or error-free service.</p>
                    </div>
                    <div>
                        <h2 class="text-lg font-bold text-gray-900 mb-2">10. Changes to Terms</h2>
                        <p>We reserve the right to modify these Terms and Conditions at any time. Changes will be effective immediately upon posting. Continued use of the Platform constitutes acceptance of the modified terms.</p>
                    </div>
                    <div>
                        <h2 class="text-lg font-bold text-gray-900 mb-2">11. Contact</h2>
                        <p>For questions about these Terms, please contact our support team through the Support page on the Platform.</p>
                    </div>
                </div>
            @endif
        </div>
    </div>
</section>
@endsection
