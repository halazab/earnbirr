@extends('templates.basic.layouts.app')

@section('title', 'Change Password')

@section('content')
<section class="pt-28 pb-16">
    <div class="max-w-lg mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-8">
            <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-blue-400 to-blue-600 flex items-center justify-center mx-auto mb-4 shadow-lg shadow-blue-200">
                <i class="fas fa-lock text-2xl text-white"></i>
            </div>
            <h1 class="text-2xl lg:text-3xl font-bold text-gray-900">Change Password</h1>
            <p class="text-gray-500 text-sm mt-1">Update your account password</p>
        </div>

        <div class="card p-6 lg:p-8">
            <form method="POST" action="{{ route('user.change.password') }}">
                @csrf
                <div>
                    <label class="form-label">Current Password</label>
                    <input type="password" name="current_password" class="form-input" placeholder="Enter current password" required>
                </div>
                <div class="mt-5">
                    <label class="form-label">New Password</label>
                    <input type="password" name="password" class="form-input" placeholder="Enter new password" required>
                </div>
                <div class="mt-5">
                    <label class="form-label">Confirm New Password</label>
                    <input type="password" name="password_confirmation" class="form-input" placeholder="Confirm new password" required>
                </div>
                <button type="submit" class="btn-primary w-full mt-6 justify-center">
                    <i class="fas fa-save"></i> Update Password
                </button>
            </form>
        </div>
    </div>
</section>
@endsection
