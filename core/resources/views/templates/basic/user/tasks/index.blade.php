@extends('templates.basic.layouts.app')

@section('title', 'Available Tasks')

@section('content')
<section class="pt-28 pb-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-8">
            <div>
                <h1 class="text-2xl lg:text-3xl font-bold text-gray-900">Available Tasks</h1>
                <p class="text-gray-500 text-sm mt-1">Browse and complete tasks to earn rewards</p>
            </div>
            <a href="{{ route('user.tasks.my') }}" class="mt-4 sm:mt-0 text-sm font-medium text-emerald-500 hover:text-emerald-600">
                <i class="fas fa-clipboard-list"></i> My Submissions
            </a>
        </div>

        {{-- Task Grid --}}
        @if(isset($tasks) && $tasks->count())
            <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-4 lg:gap-6">
                @foreach($tasks as $task)
                    <div class="card p-5 lg:p-6 hover:-translate-y-1 transition-all">
                        <div class="flex items-start justify-between mb-3">
                            <span class="badge badge-info text-xs">{{ $task->category->name ?? 'General' }}</span>
                            <span class="text-lg font-bold text-emerald-500">{{ showAmount($task->reward) }}</span>
                        </div>
                        <h3 class="font-bold text-gray-900 mb-2 line-clamp-2">{{ $task->title }}</h3>
                        <p class="text-sm text-gray-500 mb-4 line-clamp-2">{{ $task->description }}</p>
                        <div class="flex items-center justify-between text-xs text-gray-400 mb-4">
                            <span><i class="fas fa-users mr-1"></i> {{ $task->slots_remaining ?? 0 }} slots</span>
                            <span><i class="fas fa-clock mr-1"></i> {{ showDateTime($task->deadline, 'd M, Y') }}</span>
                        </div>
                        <a href="{{ route('user.tasks.details', $task->slug) }}" class="btn-primary w-full justify-center text-sm !py-3">
                            <i class="fas fa-eye"></i> View & Submit
                        </a>
                    </div>
                @endforeach
            </div>
            @if(method_exists($tasks, 'links'))
                <div class="mt-8">
                    {{ $tasks->links() }}
                </div>
            @endif
        @else
            <div class="card p-12 text-center">
                <div class="w-16 h-16 rounded-2xl bg-gray-100 flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-inbox text-gray-400 text-2xl"></i>
                </div>
                <h3 class="text-lg font-bold text-gray-900 mb-1">No Tasks Available</h3>
                <p class="text-sm text-gray-500">Check back later for new tasks.</p>
            </div>
        @endif
    </div>
</section>
@endsection
