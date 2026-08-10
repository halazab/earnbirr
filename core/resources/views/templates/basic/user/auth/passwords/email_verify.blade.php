@extends('templates.basic.layouts.app')

@section('title', 'Verify Email')

@section('content')
<section class="min-h-screen flex items-center pt-20 pb-16">
    <div class="absolute inset-0 bg-gradient-to-br from-emerald-50 via-white to-blue-50 -z-10"></div>
    <div class="max-w-md mx-auto px-4 w-full">
        <div class="card p-6 lg:p-8">
            <div class="text-center mb-6">
                <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-emerald-400 to-emerald-600 flex items-center justify-center mx-auto mb-4 shadow-lg shadow-emerald-200">
                    <i class="fas fa-envelope-open-text text-2xl text-white"></i>
                </div>
                <h1 class="text-2xl font-bold text-gray-900">Verify Your Email</h1>
                <p class="text-sm text-gray-500 mt-1">Enter the code sent to your email to activate your account</p>
            </div>

            @if(session('success'))
                <div class="bg-emerald-50 text-emerald-600 text-sm rounded-lg px-4 py-3 mb-4 text-center">
                    <i class="fas fa-check-circle mr-1"></i> {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="bg-red-50 text-red-600 text-sm rounded-lg px-4 py-3 mb-4 text-center">
                    <i class="fas fa-exclamation-circle mr-1"></i> {{ session('error') }}
                </div>
            @endif

            <form method="POST" action="{{ route('user.verification.verify') }}">
                @csrf
                <input type="hidden" name="email" value="{{ $email ?? '' }}">
                <div>
                    <label class="form-label font-medium text-gray-900">Verification Code</label>
                    <input type="text" name="code" class="form-input text-center text-2xl tracking-widest font-mono" placeholder="000000" maxlength="6" required autofocus>
                </div>
                <button type="submit" class="w-full bg-emerald-500 hover:bg-emerald-600 text-white font-bold py-3 rounded-xl transition-colors mt-6">
                    <i class="fas fa-check mr-1"></i> Verify Email
                </button>
            </form>

            <form method="POST" action="{{ route('user.verification.send') }}" class="mt-4">
                @csrf
                <input type="hidden" name="email" value="{{ $email ?? '' }}">
                <button type="submit" class="w-full text-center text-sm text-gray-500 hover:text-emerald-500 font-medium">
                    <i class="fas fa-redo mr-1"></i> Resend Code
                </button>
            </form>

            <p class="text-center text-sm text-gray-500 mt-4">
                <a href="{{ route('user.login') }}" class="text-emerald-500 hover:text-emerald-600 font-medium">Back to Sign in</a>
            </p>
        </div>
    </div>
</section>
@endsection
