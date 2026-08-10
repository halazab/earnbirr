@extends('templates.basic.layouts.app')

@section('title', 'Register')

@section('content')
<section class="min-h-screen flex items-center pt-20 pb-16">
    <div class="absolute inset-0 bg-gradient-to-br from-emerald-50 via-white to-blue-50 -z-10"></div>
    <div class="max-w-lg mx-auto px-4 w-full">
        <div class="card p-6 lg:p-8">
            <div class="text-center mb-6">
                <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-emerald-400 to-emerald-600 flex items-center justify-center mx-auto mb-4 shadow-lg shadow-emerald-200">
                    <i class="fas fa-user-plus text-2xl text-white"></i>
                </div>
                <h1 class="text-2xl font-bold text-gray-900">Create Account</h1>
                <p class="text-sm text-gray-500 mt-1">Join EarnBirr and start earning</p>
            </div>
            <form method="POST" action="{{ route('user.register') }}">
                @csrf
                @if($referralCode)
                    <input type="hidden" name="referral_code" value="{{ $referralCode }}">
                @endif
                <div class="grid sm:grid-cols-2 gap-5">
                    <div>
                        <label class="form-label">First Name</label>
                        <input type="text" name="firstname" class="form-input" required>
                    </div>
                    <div>
                        <label class="form-label">Last Name</label>
                        <input type="text" name="lastname" class="form-input" required>
                    </div>
                </div>
                <div class="mt-5">
                    <label class="form-label">Username</label>
                    <input type="text" name="username" class="form-input" required>
                </div>
                <div class="mt-5">
                    <label class="form-label">Email Address</label>
                    <input type="email" name="email" class="form-input" required>
                </div>
                <div class="mt-5">
                    <label class="form-label">Mobile Number</label>
                    <input type="tel" name="mobile" class="form-input" placeholder="+2519XXXXXXXX" required>
                </div>
                <div class="grid sm:grid-cols-2 gap-5 mt-5">
                    <div>
                        <label class="form-label">Password</label>
                        <div class="relative">
                            <input type="password" name="password" class="form-input pr-10" required>
                            <button type="button" onclick="togglePassword(this)" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600"><i class="fas fa-eye"></i></button>
                        </div>
                    </div>
                    <div>
                        <label class="form-label">Confirm Password</label>
                        <div class="relative">
                            <input type="password" name="password_confirmation" class="form-input pr-10" required>
                            <button type="button" onclick="togglePassword(this)" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600"><i class="fas fa-eye"></i></button>
                        </div>
                    </div>
                </div>
                <div class="mt-5">
                    <label class="flex items-start gap-3 text-sm text-gray-600 cursor-pointer">
                        <input type="checkbox" name="agree" class="mt-0.5 w-4 h-4 rounded border-gray-300 text-emerald-500 focus:ring-emerald-500" required>
                        I agree to the <a href="#" class="text-emerald-500 hover:text-emerald-600 ml-1">Terms of Service</a> and <a href="#" class="text-emerald-500 hover:text-emerald-600 ml-1">Privacy Policy</a>
                    </label>
                </div>
                <button type="submit" class="btn-primary w-full mt-6 justify-center">
                    <i class="fas fa-user-plus"></i> Create Account
                </button>
            </form>
            <p class="text-center text-sm text-gray-500 mt-6">
                Already have an account?
                <a href="{{ route('user.login') }}" class="text-emerald-500 hover:text-emerald-600 font-medium">Sign in</a>
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
