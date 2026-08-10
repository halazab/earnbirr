@extends('templates.basic.layouts.app')

@section('title', 'Forgot Password')

@section('content')
<section class="min-h-screen flex items-center pt-20 pb-16">
    <div class="absolute inset-0 bg-gradient-to-br from-emerald-50 via-white to-blue-50 -z-10"></div>
    <div class="max-w-md mx-auto px-4 w-full">
        <div class="card p-6 lg:p-8">
            <div class="text-center mb-6">
                <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-amber-400 to-amber-600 flex items-center justify-center mx-auto mb-4 shadow-lg shadow-amber-200">
                    <i class="fas fa-key text-2xl text-white"></i>
                </div>
                <h1 class="text-2xl font-bold text-gray-900">Forgot Password?</h1>
                <p class="text-sm text-gray-500 mt-1">Enter your email to receive a reset code</p>
            </div>
            <form method="POST" action="{{ route('user.password.email') }}">
                @csrf
                <div>
                    <label class="form-label">Email Address</label>
                    <input type="email" name="email" class="form-input" placeholder="Enter your email" required>
                </div>
                <button type="submit" class="btn-primary w-full mt-6 justify-center">
                    <i class="fas fa-paper-plane"></i> Send Reset Code
                </button>
            </form>
            <p class="text-center text-sm text-gray-500 mt-6">
                Remember your password?
                <a href="{{ route('user.login') }}" class="text-emerald-500 hover:text-emerald-600 font-medium">Sign in</a>
            </p>
        </div>
    </div>
</section>
@endsection
