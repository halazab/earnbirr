@extends('admin.layouts.master')
@section('content')
<div class="card">
    <div class="card-header">
        {{ $pageTitle }}
        <form action="" method="GET" class="float-end d-flex gap-2">
            <div class="input-group input-group-sm" style="width:200px">
                <input type="text" name="search" class="form-control" placeholder="Search user or phone number" value="{{ request('search') }}">
                <button class="btn btn-outline-primary" type="submit"><i class="fas fa-search"></i></button>
            </div>
            <input type="date" name="date" class="form-control form-control-sm" value="{{ request('date') }}" style="width:160px">
        </form>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th>User</th>
                        <th>Notification</th>
                        <th>Type</th>
                        <th>Read</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($notifications as $n)
                    <tr>
                        <td>{{ $n->user?->fullname() ?? 'N/A' }}</td>
                        <td>{{ strLimit($n->message, 50) }}</td>
                        <td>
                            @if($n->type == 'deposit')
                                <span class="badge bg-soft-success">Deposit</span>
                            @elseif($n->type == 'withdraw')
                                <span class="badge bg-soft-danger">Withdraw</span>
                            @elseif($n->type == 'task')
                                <span class="badge bg-soft-info">Task</span>
                            @else
                                <span class="badge bg-soft-warning">{{ ucfirst($n->type) }}</span>
                            @endif
                        </td>
                        <td>
                            @if($n->is_read)
                                <span class="badge bg-soft-success">Read</span>
                            @else
                                <span class="badge bg-soft-warning">Unread</span>
                            @endif
                        </td>
                        <td>{{ showDateTime($n->created_at) }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-4 text-muted">No notifications found</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($notifications->hasPages())
    <div class="card-footer">
        {{ $notifications->links() }}
    </div>
    @endif
</div>
@endsection
