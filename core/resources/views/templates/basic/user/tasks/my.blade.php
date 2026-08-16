@extends('templates.basic.layouts.app')

@section('title', __('messages.my_submissions'))

@section('content')
<section class="pt-28 pb-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-8">
            <div>
                <h1 class="text-2xl lg:text-3xl font-bold text-gray-900">{{ __('messages.my_submissions') }}</h1>
                <p class="text-gray-500 text-sm mt-1">Track your task submissions and their status</p>
            </div>
            <a href="{{ route('user.tasks.index') }}" class="mt-4 sm:mt-0 btn-primary text-sm !py-2.5 !px-5">
                <i class="fas fa-plus"></i> {{ __('messages.task_browse') }}
            </a>
        </div>

        <div class="card overflow-hidden">
            @if(isset($submissions) && $submissions->count())
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="bg-gray-50 border-b border-gray-100">
                                <th class="text-left py-4 px-4 lg:px-6 font-semibold text-gray-600 text-xs uppercase tracking-wider">{{ __('messages.tasks') }}</th>
                                <th class="text-left py-4 px-4 lg:px-6 font-semibold text-gray-600 text-xs uppercase tracking-wider">{{ __('messages.type') }}</th>
                                <th class="text-left py-4 px-4 lg:px-6 font-semibold text-gray-600 text-xs uppercase tracking-wider">{{ __('messages.reward') }}</th>
                                <th class="text-left py-4 px-4 lg:px-6 font-semibold text-gray-600 text-xs uppercase tracking-wider">{{ __('messages.status') }}</th>
                                <th class="text-left py-4 px-4 lg:px-6 font-semibold text-gray-600 text-xs uppercase tracking-wider">{{ __('messages.submitted') }}</th>
                                <th class="text-left py-4 px-4 lg:px-6 font-semibold text-gray-600 text-xs uppercase tracking-wider">{{ __('messages.feedback') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($submissions as $sub)
                                <tr class="border-b border-gray-50 hover:bg-gray-50/50 transition-colors">
                                    <td class="py-4 px-4 lg:px-6">
                                        <p class="font-medium text-gray-900">{{ $sub->task->title ?? 'N/A' }}</p>
                                    </td>
                                    <td class="py-4 px-4 lg:px-6">
                                        <span class="text-gray-600 capitalize">{{ implode(', ', (array) $sub->task->proof_type ?: ['N/A']) }}</span>
                                    </td>
                                    <td class="py-4 px-4 lg:px-6">
                                        <span class="font-medium text-emerald-500">{{ showAmount($sub->task->reward ?? 0) }}</span>
                                    </td>
                                    <td class="py-4 px-4 lg:px-6">
                                        @if($sub->status == Status::SUBMISSION_PENDING)
                                            <span class="badge badge-pending">{{ __('messages.pending') }}</span>
                                        @elseif($sub->status == Status::SUBMISSION_APPROVED)
                                            <span class="badge badge-success">{{ __('messages.approved') }}</span>
                                        @elseif($sub->status == Status::SUBMISSION_REJECTED)
                                            <span class="badge badge-danger">{{ __('messages.rejected') }}</span>
                                        @endif
                                    </td>
                                    <td class="py-4 px-4 lg:px-6">
                                        <span class="text-gray-600 text-xs">{{ showDateTime($sub->created_at) }}</span>
                                    </td>
                                    <td class="py-4 px-4 lg:px-6">
                                        <span class="text-gray-600 text-sm">{{ $sub->admin_note ?? '--' }}</span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @if(method_exists($submissions, 'links'))
                    <div class="p-4 lg:p-6 border-t border-gray-100">
                        {{ $submissions->links() }}
                    </div>
                @endif
            @else
                <div class="p-12 text-center">
                    <div class="w-16 h-16 rounded-2xl bg-gray-100 flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-clipboard text-gray-400 text-2xl"></i>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 mb-1">{{ __('messages.no_submissions') }}</h3>
                    <p class="text-sm text-gray-500">{{ __('messages.start_working') }}</p>
                    <a href="{{ route('user.tasks.index') }}" class="btn-primary mt-5">{{ __('messages.task_browse') }}</a>
                </div>
            @endif
        </div>
    </div>
</section>
@endsection
