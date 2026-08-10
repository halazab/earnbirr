@extends('templates.basic.layouts.app')

@section('title', 'Reset Password')

@section('content')
<section class="min-h-screen flex items-center pt-20 pb-16">
    <div class="absolute inset-0 bg-gradient-to-br from-emerald-50 via-white to-blue-50 -z-10"></div>
    <div class="max-w-md mx-auto px-4 w-full">
        <div class="card p-6 lg:p-8">
            <div class="text-center mb-6">
                <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-emerald-400 to-emerald-600 flex items-center justify-center mx-auto mb-4 shadow-lg shadow-emerald-200">
                    <i class="fas fa-lock-open text-2xl text-white"></i>
                </div>
                <h1 class="text-2xl font-bold text-gray-900">Reset Password</h1>
                <p class="text-sm text-gray-500 mt-1">Set your new password</p>
            </div>
            <form method="POST" action="{{ route('user.password.update') }}">
                @csrf
                <input type="hidden" name="email" value="{{ $email ?? '' }}">
                <input type="hidden" name="code" value="{{ $code ?? '' }}">
                <div>
                    <label class="form-label">New Password</label>
                    <input type="password" name="password" class="form-input" placeholder="Enter new password" required>
                </div>
                <div class="mt-5">
                    <label class="form-label">Confirm Password</label>
                    <input type="password" name="password_confirmation" class="form-input" placeholder="Confirm new password" required>
                </div>
                <button type="submit" class="btn-primary w-full mt-6 justify-center">
                    <i class="fas fa-save"></i> Reset Password
                </button>
            </form>
            <p class="text-center text-sm text-gray-500 mt-6">
                <a href="{{ route('user.login') }}" class="text-emerald-500 hover:text-emerald-600 font-medium">Back to Sign in</a>
            </p>
        </div>
    </div>
</section>
@endsection
