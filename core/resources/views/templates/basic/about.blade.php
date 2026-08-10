@extends('templates.basic.layouts.app')

@section('title', $pageTitle)

@section('content')
<section class="pt-28 pb-16">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-8">
            <h1 class="text-2xl lg:text-3xl font-bold text-gray-900">About Us</h1>
        </div>
        <div class="card p-6 lg:p-8">
            @if($content && $content->data_values->content)
                <div class="prose prose-sm max-w-none text-gray-600 leading-relaxed">
                    {!! $content->data_values->content !!}
                </div>
            @else
                <div class="text-center py-8">
                    <div class="w-16 h-16 rounded-2xl bg-gray-100 flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-info-circle text-gray-400 text-2xl"></i>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900">About EarnBirr</h3>
                    <p class="text-sm text-gray-500 mt-2 max-w-md mx-auto">
                        EarnBirr is a leading micro-task and freelancing platform in Ethiopia. 
                        We connect task posters with skilled workers, enabling everyone to earn money 
                        from home by completing simple tasks like social media engagement, surveys, 
                        app testing, and freelance gigs.
                    </p>
                    <p class="text-sm text-gray-500 mt-3 max-w-md mx-auto">
                        Our mission is to create economic opportunities for all Ethiopians by providing 
                        a reliable, transparent, and easy-to-use platform for earning and paying in 
                        Ethiopian Birr via TeleBirr.
                    </p>
                </div>
            @endif
        </div>
    </div>
</section>
@endsection
