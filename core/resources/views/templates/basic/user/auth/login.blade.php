@extends('templates.basic.layouts.app')

@section('title', 'Login')

@section('content')
<section class="min-h-screen flex items-center pt-20 pb-16">
    <div class="absolute inset-0 bg-gradient-to-br from-emerald-50 via-white to-blue-50 -z-10"></div>
    <div class="max-w-md mx-auto px-4 w-full">
        <div class="card p-6 lg:p-8">
            <div class="text-center mb-6">
                <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-emerald-400 to-emerald-600 flex items-center justify-center mx-auto mb-4 shadow-lg shadow-emerald-200">
                    <i class="fas fa-user text-2xl text-white"></i>
                </div>
                <h1 class="text-2xl font-bold text-gray-900">Welcome Back</h1>
                <p class="text-sm text-gray-500 mt-1">Sign in to your account</p>
            </div>
            <form method="POST" action="{{ route('user.login') }}">
                @csrf
                <div>
                    <label class="form-label">Email or Username</label>
                    <input type="text" name="username" class="form-input" placeholder="Enter email or username" required>
                </div>
                <div class="mt-5">
                    <label class="form-label">Password</label>
                    <div class="relative">
                        <input type="password" name="password" class="form-input pr-10" placeholder="Enter password" required>
                        <button type="button" onclick="togglePassword(this)" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600"><i class="fas fa-eye"></i></button>
                    </div>
                </div>
                <div class="flex items-center justify-between mt-5">
                    <label class="flex items-center gap-2 text-sm text-gray-600 cursor-pointer">
                        <input type="checkbox" name="remember" class="w-4 h-4 rounded border-gray-300 text-emerald-500 focus:ring-emerald-500">
                        Remember me
                    </label>
                    <a href="{{ route('user.password.request') }}" class="text-sm text-emerald-500 hover:text-emerald-600 font-medium">Forgot Password?</a>
                </div>
                <button type="submit" class="btn-primary w-full mt-6 justify-center">
                    <i class="fas fa-sign-in-alt"></i> Sign In
                </button>
            </form>
            <p class="text-center text-sm text-gray-500 mt-6">
                Don't have an account?
                <a href="{{ route('user.register') }}" class="text-emerald-500 hover:text-emerald-600 font-medium">Create one</a>
            </p>
        </div>
    </div>
</section>
@endsection

@push('script')
<script>
function togglePassword(btn) {
    const input = btn.previousElementSibling;
    const icon = btn.querySelector('i');
    if (input.type === 'password') {
        input.type = 'text';
        icon.classList.replace('fa-eye', 'fa-eye-slash');
    } else {
        input.type = 'password';
        icon.classList.replace('fa-eye-slash', 'fa-eye');
    }
}
</script>
@endpush
