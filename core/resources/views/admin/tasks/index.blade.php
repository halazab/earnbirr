@extends('admin.layouts.master')
@section('content')
<div class="card">
    <div class="card-header">
        {{ $pageTitle }}
        <div class="float-end d-flex gap-2">
            <form action="{{ route('admin.tasks.regenerate.prices') }}" method="POST" onsubmit="return confirm('Regenerate ALL task prices? This will overwrite current rewards with random values between {{ gs("task_reward_min") ?? 30 }}–{{ gs("task_reward_max") ?? 50 }} ETB.')">
                @csrf
                <button class="btn btn-sm btn-warning" type="submit"><i class="fas fa-random"></i> Regenerate Prices</button>
            </form>
            <a href="{{ route('admin.tasks.create') }}" class="btn btn-sm btn-primary">
                <i class="fas fa-plus"></i> Add New
            </a>
        </div>
    </div>
    <div class="card-body p-0">
        <ul class="nav nav-tabs px-3 pt-3">
            <li class="nav-item">
                <a class="nav-link {{ !request('status') ? 'active' : '' }}" href="{{ route('admin.tasks.index') }}">All</a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request('status') == 'pending' ? 'active' : '' }}" href="{{ route('admin.tasks.index', ['status' => 'pending']) }}">Pending</a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request('status') == 'active' ? 'active' : '' }}" href="{{ route('admin.tasks.index', ['status' => 'active']) }}">Active</a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request('status') == 'completed' ? 'active' : '' }}" href="{{ route('admin.tasks.index', ['status' => 'completed']) }}">Completed</a>
            </li>
        </ul>
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Category</th>
                        <th>Type</th>
                        <th>Reward</th>
                        <th>Slots</th>
                        <th>Status</th>
                        <th>End Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($tasks as $t)
                    <tr>
                        <td><strong>{{ strLimit($t->title, 30) }}</strong></td>
                        <td>{{ $t->category?->name ?? 'N/A' }}</td>
                        <td><span class="badge bg-soft-info">{{ ucwords(str_replace('_', ' ', $t->task_type)) }}</span></td>
                        <td>{{ showAmount($t->reward) }}</td>
                        <td>
                            <span class="text-nowrap">{{ $t->total_slots - $t->remaining_slots }}/{{ $t->total_slots }}</span>
                            @if($t->remaining_slots <= 0)
                                <span class="badge bg-soft-danger">Full</span>
                            @endif
                        </td>
                        <td>
                            @if($t->status == 0)
                                <span class="badge bg-soft-warning">Pending</span>
                            @elseif($t->status == 1)
                                <span class="badge bg-soft-success">Active</span>
                            @elseif($t->status == 2)
                                <span class="badge bg-soft-info">Completed</span>
                            @else
                                <span class="badge bg-soft-danger">Cancelled</span>
                            @endif
                        </td>
                        <td>{{ $t->end_date ? showDateTime($t->end_date) : 'N/A' }}</td>
                        <td>
                            <div class="d-flex gap-1">
                                <a href="{{ route('admin.tasks.edit', $t->id) }}" class="btn btn-sm btn-outline-primary" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.tasks.delete', $t->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger"><i class="fas fa-trash"></i></button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center py-4 text-muted">No tasks found</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($tasks->hasPages())
    <div class="card-footer">
        {{ $tasks->links() }}
    </div>
    @endif
</div>
@endsection
