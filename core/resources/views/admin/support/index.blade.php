@extends('admin.layouts.master')
@section('content')
<div class="card">
    <div class="card-header">
        <div class="d-flex align-items-center justify-content-between">
            <span>{{ $pageTitle }}</span>
            <form action="" method="GET" class="d-flex gap-2">
                <div class="input-group input-group-sm" style="width:250px">
                    <input type="text" name="search" class="form-control" placeholder="Ticket ID, subject, user or phone" value="{{ request('search') }}">
                    <button class="btn btn-outline-primary" type="submit"><i class="fas fa-search"></i></button>
                </div>
            </form>
        </div>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th>Ticket ID</th>
                        <th>User</th>
                        <th>Subject</th>
                        <th>Priority</th>
                        <th>Status</th>
                        <th>Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($tickets as $t)
                    <tr>
                        <td><span class="fw-bold">#{{ $t->ticket_id }}</span></td>
                        <td>{{ $t->user?->fullname() ?? 'N/A' }}</td>
                        <td>{{ strLimit($t->subject, 40) }}</td>
                        <td>
                            @if($t->priority == 'high')
                                <span class="badge bg-soft-danger">High</span>
                            @elseif($t->priority == 'medium')
                                <span class="badge bg-soft-warning">Medium</span>
                            @else
                                <span class="badge bg-soft-info">Low</span>
                            @endif
                        </td>
                        <td>
                            @if($t->status == 0)
                                <span class="badge bg-soft-warning">Open</span>
                            @elseif($t->status == 1)
                                <span class="badge bg-soft-info">Replied</span>
                            @elseif($t->status == 2)
                                <span class="badge bg-soft-success">Closed</span>
                            @else
                                <span class="badge bg-soft-danger">Resolved</span>
                            @endif
                        </td>
                        <td>{{ showDateTime($t->created_at) }}</td>
                        <td>
                            <a href="{{ route('admin.ticket.view', $t->id) }}" class="btn btn-sm btn-outline-info" title="View">
                                <i class="fas fa-eye"></i>
                            </a>
                            <form action="{{ route('admin.ticket.close', $t->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Close this ticket?')">
                                @csrf
                                <button class="btn btn-sm btn-outline-danger" title="Close"><i class="fas fa-times"></i></button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-4 text-muted">No tickets found</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($tickets->hasPages())
    <div class="card-footer">
        {{ $tickets->links() }}
    </div>
    @endif
</div>
@endsection
