@extends('templates.basic.layouts.app')

@section('title', $task->title ?? 'Task Details')

@section('content')
<section class="pt-28 pb-16">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <a href="{{ route('user.tasks.index') }}" class="inline-flex items-center gap-2 text-sm text-gray-500 hover:text-emerald-500 mb-6 transition-colors">
            <i class="fas fa-arrow-left"></i> Back to Tasks
        </a>

        @isset($task)
            <div class="grid lg:grid-cols-3 gap-6 lg:gap-8">
                <div class="lg:col-span-2">
                    <div class="card p-6 lg:p-8">
                        <div class="flex items-start justify-between mb-4">
                            <span class="badge badge-info">{{ $task->category->name ?? 'General' }}</span>
                            <span class="text-2xl font-bold text-emerald-500">{{ showAmount($task->reward) }}</span>
                        </div>
                        <h1 class="text-2xl lg:text-3xl font-bold text-gray-900 mb-4">{{ $task->title }}</h1>
                        <div class="prose prose-sm max-w-none text-gray-600 mb-6">
                            {!! $task->description !!}
                        </div>
                        @if($task->instructions)
                            <div class="bg-gray-50 rounded-xl p-5 mb-6">
                                <h3 class="font-semibold text-gray-900 mb-2 flex items-center gap-2">
                                    <i class="fas fa-list text-emerald-500"></i> Instructions
                                </h3>
                                <div class="text-sm text-gray-600 leading-relaxed whitespace-pre-line">
                                    {!! nl2br(e($task->instructions)) !!}
                                </div>
                            </div>
                        @endif
                        @if($task->external_link)
                            <div class="mb-6">
                                <a href="{{ $task->external_link }}" target="_blank" rel="noopener noreferrer" class="flex items-center gap-3 p-4 bg-emerald-50 border border-emerald-200 rounded-xl hover:bg-emerald-100 transition-colors">
                                    <div class="w-10 h-10 rounded-xl bg-emerald-500 flex items-center justify-center flex-shrink-0">
                                        <i class="fas fa-external-link-alt text-white text-sm"></i>
                                    </div>
                                    <div class="flex-1">
                                        <p class="text-sm font-medium text-emerald-700">Task Link</p>
                                        <p class="text-xs text-emerald-500 truncate">{{ $task->external_link }}</p>
                                    </div>
                                    <i class="fas fa-arrow-right text-emerald-400"></i>
                                </a>
                            </div>
                        @endif
                        @if($task->task_file_data)
                            <div class="mb-6">
                                @if(str_starts_with($task->task_file_type ?? '', 'image/'))
                                    <div class="p-4 bg-blue-50 border border-blue-200 rounded-xl">
                                        <p class="text-sm font-medium text-blue-700 mb-2"><i class="fas fa-image mr-1"></i> Task File</p>
                                        <img src="data:{{ $task->task_file_type }};base64,{{ $task->task_file_data }}" style="max-width:100%;border-radius:8px;" alt="{{ $task->task_file }}">
                                    </div>
                                @else
                                    <a href="data:{{ $task->task_file_type }};base64,{{ $task->task_file_data }}" target="_blank" download="{{ $task->task_file }}" class="flex items-center gap-3 p-4 bg-blue-50 border border-blue-200 rounded-xl hover:bg-blue-100 transition-colors">
                                        <div class="w-10 h-10 rounded-xl bg-blue-500 flex items-center justify-center flex-shrink-0">
                                            <i class="fas fa-file-download text-white text-sm"></i>
                                        </div>
                                        <div class="flex-1">
                                            <p class="text-sm font-medium text-blue-700">Download Task File</p>
                                            <p class="text-xs text-blue-500 truncate">{{ $task->task_file }}</p>
                                        </div>
                                        <i class="fas fa-download text-blue-400"></i>
                                    </a>
                                @endif
                            </div>
                        @endif
                    </div>

                    @if(!auth()->user()->is_activated)
                        <div class="card p-6 mt-6 text-center">
                            <div class="w-14 h-14 rounded-2xl bg-amber-100 flex items-center justify-center mx-auto mb-4">
                                <i class="fas fa-lock text-amber-500 text-2xl"></i>
                            </div>
                            <h3 class="text-lg font-bold text-gray-900">Account Not Activated</h3>
                            <p class="text-sm text-gray-500 mt-1 mb-4">Activate your account to submit tasks.</p>
                            <a href="{{ route('user.activation') }}" class="btn-primary">Activate Now</a>
                        </div>
                    @elseif($alreadySubmitted)
                        <div class="card p-6 lg:p-8 mt-6 text-center">
                            <div class="w-14 h-14 rounded-2xl bg-yellow-100 flex items-center justify-center mx-auto mb-4">
                                <i class="fas fa-clock text-yellow-500 text-2xl"></i>
                            </div>
                            <h2 class="text-lg font-bold text-gray-900 mb-2">Task Submitted</h2>
                            <p class="text-sm text-gray-500 mb-4">Your submission is under review. You cannot submit this task again until it is approved or rejected.</p>
                            <a href="{{ route('user.tasks.my') }}" class="btn-primary">
                                <i class="fas fa-list mr-1"></i> View My Submissions
                            </a>
                        </div>
                    @else
                        <div class="card p-6 lg:p-8 mt-6">
                            <h2 class="text-lg font-bold text-gray-900 mb-5">Submit Your Work</h2>
                            <form method="POST" action="{{ route('user.tasks.submit', $task->id) }}" enctype="multipart/form-data">
                                @csrf
                                <div class="mb-5">
                                    <label class="form-label">Proof Description</label>
                                    <textarea name="proof_text" rows="4" class="form-input resize-none" placeholder="Describe how you completed this task..."></textarea>
                                    <p class="text-xs text-gray-400 mt-1">Describe what you did (optional)</p>
                                </div>
                                <div class="mb-5">
                                    <label class="form-label">Upload Proof</label>
                                    <input type="file" name="proof_file" class="form-input file:text-sm file:border-0 file:bg-emerald-50 file:text-emerald-600 file:font-medium file:rounded-lg file:px-4 file:py-2 file:cursor-pointer" required>
                                    <p class="text-xs text-gray-400 mt-1">Screenshot, image, PDF, or document (max 10MB)</p>
                                </div>
                                <button type="submit" class="btn-primary justify-center">
                                    <i class="fas fa-paper-plane"></i> Submit Task
                                </button>
                            </form>
                        </div>
                    @endif
                </div>

                <div class="space-y-4 lg:space-y-6">
                    <div class="card p-5 lg:p-6">
                        <h3 class="font-semibold text-gray-900 mb-4">Task Info</h3>
                        <div class="space-y-3 text-sm">
                            <div class="flex justify-between">
                                <span class="text-gray-500">Reward</span>
                                <span class="font-bold text-emerald-500">{{ showAmount($task->reward) }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-500">Available Slots</span>
                                <span class="font-medium text-gray-900">{{ $task->remaining_slots ?? 0 }} / {{ $task->total_slots ?? 0 }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-500">Deadline</span>
                                <span class="font-medium text-gray-900">{{ $task->end_date ? showDateTime($task->end_date, 'd M, Y') : 'No deadline' }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-500">Type</span>
                                <span class="font-medium text-gray-900 capitalize">{{ implode(', ', (array) $task->proof_type ?: ['N/A']) }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="card p-5 lg:p-6">
                        <h3 class="font-semibold text-gray-900 mb-4">Your Balance</h3>
                        <p class="text-2xl font-bold text-emerald-500">{{ showAmount(auth()->user()->balance) }}</p>
                    </div>
                </div>
            </div>
        @else
            <div class="card p-12 text-center">
                <div class="w-16 h-16 rounded-2xl bg-gray-100 flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-question-circle text-gray-400 text-2xl"></i>
                </div>
                <h3 class="text-lg font-bold text-gray-900">Task Not Found</h3>
                <p class="text-sm text-gray-500 mt-1">The task you're looking for doesn't exist.</p>
            </div>
        @endisset
    </div>
</section>
@endsection
