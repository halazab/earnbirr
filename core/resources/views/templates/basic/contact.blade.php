@extends('templates.basic.layouts.app')

@section('title', 'Contact Us')

@section('content')
<section class="pt-28 pb-16 lg:pb-24">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-2xl mx-auto mb-12">
            <h1 class="text-3xl sm:text-4xl font-bold text-gray-900">Contact Us</h1>
            <p class="mt-4 text-gray-600">Have a question or concern? We'd love to hear from you.</p>
        </div>
        <div class="grid lg:grid-cols-3 gap-8">
            <div class="lg:col-span-2">
                <div class="card p-6 lg:p-8">
                    <h2 class="text-xl font-bold text-gray-900 mb-6">Send us a Message</h2>
                    <form method="POST" action="{{ route('contact') }}">
                        @csrf
                        <div class="grid sm:grid-cols-2 gap-5">
                            <div>
                                <label class="form-label">Your Name</label>
                                <input type="text" name="name" class="form-input" required>
                            </div>
                            <div>
                                <label class="form-label">Email Address</label>
                                <input type="email" name="email" class="form-input" required>
                            </div>
                        </div>
                        <div class="mt-5">
                            <label class="form-label">Subject</label>
                            <input type="text" name="subject" class="form-input">
                        </div>
                        <div class="mt-5">
                            <label class="form-label">Message</label>
                            <textarea name="message" rows="5" class="form-input resize-none" required></textarea>
                        </div>
                        <button type="submit" class="btn-primary mt-6">
                            <i class="fas fa-paper-plane"></i> Send Message
                        </button>
                    </form>
                </div>
            </div>
            <div class="space-y-6">
                <div class="card p-6">
                    <div class="w-12 h-12 rounded-xl bg-emerald-100 flex items-center justify-center mb-4">
                        <i class="fas fa-map-marker-alt text-emerald-500 text-lg"></i>
                    </div>
                    <h3 class="font-semibold text-gray-900 mb-1">Our Location</h3>
                    <p class="text-sm text-gray-500">Addis Ababa, Ethiopia</p>
                </div>
                <div class="card p-6">
                    <div class="w-12 h-12 rounded-xl bg-blue-100 flex items-center justify-center mb-4">
                        <i class="fas fa-envelope text-blue-500 text-lg"></i>
                    </div>
                    <h3 class="font-semibold text-gray-900 mb-1">Email Us</h3>
                    <p class="text-sm text-gray-500">support@earnethio.com</p>
                </div>
                <div class="card p-6">
                    <div class="w-12 h-12 rounded-xl bg-purple-100 flex items-center justify-center mb-4">
                        <i class="fas fa-phone text-purple-500 text-lg"></i>
                    </div>
                    <h3 class="font-semibold text-gray-900 mb-1">Call Us</h3>
                    <p class="text-sm text-gray-500">+251 9XX XXX XXXX</p>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
