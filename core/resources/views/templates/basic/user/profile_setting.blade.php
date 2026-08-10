@extends('templates.basic.layouts.app')

@section('title', 'Profile Settings')

@section('content')
<section class="pt-24 pb-16">
    <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
        {{-- Compact Profile Header --}}
        <div class="card p-5 mb-6">
            <div class="flex items-center gap-4">
                <div class="w-16 h-16 rounded-full bg-gradient-to-br from-emerald-400 to-emerald-600 flex items-center justify-center flex-shrink-0 shadow-lg shadow-emerald-200">
                    <span class="text-xl font-bold text-white">{{ substr(auth()->user()->firstname ?? 'U', 0, 1) }}{{ substr(auth()->user()->lastname ?? 'S', 0, 1) }}</span>
                </div>
                <div class="flex-1 min-w-0">
                    <h1 class="text-lg font-bold text-gray-900 truncate">{{ auth()->user()->firstname }} {{ auth()->user()->lastname }}</h1>
                    <p class="text-sm text-gray-500 truncate">{{ auth()->user()->email }}</p>
                    <p class="text-xs text-emerald-500 font-medium mt-0.5">@{{ auth()->user()->username }}</p>
                </div>
                <a href="{{ route('user.change.password') }}" class="flex-shrink-0 text-sm text-emerald-500 hover:text-emerald-600 font-medium">
                    <i class="fas fa-key"></i>
                </a>
            </div>
        </div>

        <div class="card p-6 lg:p-8">
            <form method="POST" action="{{ route('user.profile.setting') }}">
                @csrf
                <div class="grid sm:grid-cols-2 gap-5">
                    <div>
                        <label class="form-label">First Name</label>
                        <input type="text" name="firstname" class="form-input" value="{{ old('firstname', auth()->user()->firstname) }}" required>
                    </div>
                    <div>
                        <label class="form-label">Last Name</label>
                        <input type="text" name="lastname" class="form-input" value="{{ old('lastname', auth()->user()->lastname) }}" required>
                    </div>
                </div>
                <div class="mt-5">
                    <label class="form-label">Email Address</label>
                    <input type="email" name="email" class="form-input" value="{{ old('email', auth()->user()->email) }}" required>
                </div>
                <div class="mt-5">
                    <label class="form-label">Mobile Number</label>
                    <input type="tel" name="mobile" class="form-input" value="{{ old('mobile', auth()->user()->mobile) }}" required>
                </div>
                <div class="mt-5">
                    <label class="form-label">Username</label>
                    <input type="text" class="form-input bg-gray-50" value="{{ auth()->user()->username }}" disabled>
                    <p class="text-xs text-gray-400 mt-1">Username cannot be changed</p>
                </div>
                <button type="submit" class="btn-primary mt-6">
                    <i class="fas fa-save"></i> Update Profile
                </button>
            </form>
        </div>
    </div>
</section>
@endsection
