@extends('templates.basic.layouts.app')

@section('title', 'Page Expired')

@section('content')
<section class="pt-28 pb-16">
    <div class="max-w-lg mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <div class="card p-8 lg:p-10">
            <div class="w-16 h-16 rounded-2xl bg-amber-100 flex items-center justify-center mx-auto mb-5">
                <i class="fas fa-clock text-amber-500 text-2xl"></i>
            </div>
            <h1 class="text-2xl font-bold text-gray-900 mb-2">Page Expired</h1>
            <p class="text-sm text-gray-500 mb-6">
                Your session has expired or the page you requested is no longer valid. 
                This can happen if you left the page open for too long or opened it in another tab.
            </p>
            <div class="flex flex-col sm:flex-row gap-3 justify-center">
                <a href="{{ url()->previous(route('home')) }}" class="btn-primary justify-center">
                    <i class="fas fa-redo"></i> Go Back & Retry
                </a>
                <a href="{{ route('home') }}" class="btn-outline justify-center">
                    <i class="fas fa-home"></i> Go Home
                </a>
            </div>
        </div>
    </div>
</section>
@endsection
