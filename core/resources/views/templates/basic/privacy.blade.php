@extends('templates.basic.layouts.app')

@section('title', $pageTitle)

@section('content')
<section class="pt-28 pb-16">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-8">
            <h1 class="text-2xl lg:text-3xl font-bold text-gray-900">Privacy Policy</h1>
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
                        <h2 class="text-lg font-bold text-gray-900 mb-2">1. Information We Collect</h2>
                        <p>We collect information you provide directly, including: name, email address, phone number, username, password, payment details (TeleBirr transaction IDs), and profile information. We also collect usage data such as IP address, device information, and browsing activity on the Platform.</p>
                    </div>
                    <div>
                        <h2 class="text-lg font-bold text-gray-900 mb-2">2. How We Use Your Information</h2>
                        <p>We use your information to: provide and maintain our services, process transactions, verify task completions, process withdrawals, send notifications about your account, improve the Platform, detect and prevent fraud, and comply with legal obligations.</p>
                    </div>
                    <div>
                        <h2 class="text-lg font-bold text-gray-900 mb-2">3. Information Sharing</h2>
                        <p>We do not sell your personal information. We may share your information with: payment processors (TeleBirr) for transaction processing, law enforcement when required by law, and service providers who assist in operating the Platform. All sharing is limited to what is necessary for these purposes.</p>
                    </div>
                    <div>
                        <h2 class="text-lg font-bold text-gray-900 mb-2">4. Data Security</h2>
                        <p>We implement industry-standard security measures to protect your personal information, including encryption, secure database storage, and regular security audits. However, no method of transmission over the Internet is 100% secure, and we cannot guarantee absolute security.</p>
                    </div>
                    <div>
                        <h2 class="text-lg font-bold text-gray-900 mb-2">5. Data Retention</h2>
                        <p>We retain your personal information for as long as your account is active or as needed to provide services. If you delete your account, we will remove your personal data within 30 days, except where retention is required by law.</p>
                    </div>
                    <div>
                        <h2 class="text-lg font-bold text-gray-900 mb-2">6. Your Rights</h2>
                        <p>You have the right to: access your personal data, correct inaccurate data, request deletion of your data, object to processing of your data, and export your data. To exercise these rights, contact our support team.</p>
                    </div>
                    <div>
                        <h2 class="text-lg font-bold text-gray-900 mb-2">7. Cookies</h2>
                        <p>We use cookies and similar technologies to maintain your session, remember your preferences, and analyze usage patterns. You can control cookies through your browser settings, but disabling cookies may affect Platform functionality.</p>
                    </div>
                    <div>
                        <h2 class="text-lg font-bold text-gray-900 mb-2">8. Third-Party Services</h2>
                        <p>The Platform may contain links to third-party services. We are not responsible for the privacy practices of these services. We encourage you to read their privacy policies before providing any information.</p>
                    </div>
                    <div>
                        <h2 class="text-lg font-bold text-gray-900 mb-2">9. Children's Privacy</h2>
                        <p>EarnBirr is not intended for users under 18 years of age. We do not knowingly collect personal information from children. If we become aware that we have collected data from a child, we will delete it promptly.</p>
                    </div>
                    <div>
                        <h2 class="text-lg font-bold text-gray-900 mb-2">10. Changes to This Policy</h2>
                        <p>We may update this Privacy Policy from time to time. We will notify you of any material changes by posting the new policy on this page and updating the "Last updated" date. Your continued use of the Platform after changes constitutes acceptance.</p>
                    </div>
                    <div>
                        <h2 class="text-lg font-bold text-gray-900 mb-2">11. Contact Us</h2>
                        <p>If you have questions about this Privacy Policy, please contact us through the Support page on the Platform or via the contact information provided on our Contact page.</p>
                    </div>
                </div>
            @endif
        </div>
    </div>
</section>
@endsection
