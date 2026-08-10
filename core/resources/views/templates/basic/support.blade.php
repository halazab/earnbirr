@extends('templates.basic.layouts.app')

@section('title', $pageTitle)

@section('content')
<section class="pt-28 pb-16">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-8">
            <h1 class="text-2xl lg:text-3xl font-bold text-gray-900">Support</h1>
            <p class="text-gray-500 text-sm mt-1">Get help from our team</p>
        </div>

        @if($content && $content->data_values->content)
            <div class="card p-6 lg:p-8 mb-6">
                <div class="prose prose-sm max-w-none text-gray-600 leading-relaxed">
                    {!! $content->data_values->content !!}
                </div>
            </div>
        @endif

        <div class="grid sm:grid-cols-2 gap-4 mb-6">
            <a href="{{ route('user.ticket.create') }}" class="card p-5 hover:bg-emerald-50 transition-colors text-center">
                <div class="w-12 h-12 rounded-xl bg-emerald-100 flex items-center justify-center mx-auto mb-3">
                    <i class="fas fa-plus text-emerald-500 text-lg"></i>
                </div>
                <h3 class="font-semibold text-gray-900 text-sm">Create New Ticket</h3>
                <p class="text-xs text-gray-400 mt-1">Get help from our support team</p>
            </a>
            <a href="{{ route('user.ticket.index') }}" class="card p-5 hover:bg-blue-50 transition-colors text-center">
                <div class="w-12 h-12 rounded-xl bg-blue-100 flex items-center justify-center mx-auto mb-3">
                    <i class="fas fa-inbox text-blue-500 text-lg"></i>
                </div>
                <h3 class="font-semibold text-gray-900 text-sm">My Tickets</h3>
                <p class="text-xs text-gray-400 mt-1">View your support history</p>
            </a>
        </div>

        <div class="card p-6">
            <h3 class="font-semibold text-gray-900 mb-4">Contact Information</h3>
            <div class="space-y-3">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-emerald-100 flex items-center justify-center flex-shrink-0">
                        <i class="fas fa-envelope text-emerald-500"></i>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400">Email</p>
                        <p class="text-sm font-medium text-gray-900">{{ gs('footer_email') ?? 'support@earnbirr.com' }}</p>
                    </div>
                </div>
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-blue-100 flex items-center justify-center flex-shrink-0">
                        <i class="fas fa-phone text-blue-500"></i>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400">Phone</p>
                        <p class="text-sm font-medium text-gray-900">{{ gs('footer_phone') ?? '+251 9XX XXX XXXX' }}</p>
                    </div>
                </div>
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-purple-100 flex items-center justify-center flex-shrink-0">
                        <i class="fab fa-telegram-plane text-purple-500"></i>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400">Telegram</p>
                        <p class="text-sm font-medium text-gray-900">{{ gs('social_telegram') ? 'Join our group' : 'Not available' }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
