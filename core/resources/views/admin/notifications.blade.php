@extends('admin.layouts.master')
@section('content')
<div class="card">
    <div class="card-header">
        {{ $pageTitle }}
        <form action="{{ url('admin/notifications/read-all') }}" method="POST" class="float-end">
            @csrf
            <button class="btn btn-sm btn-primary" type="submit">
                <i class="fas fa-check-double"></i> Mark All as Read
            </button>
        </form>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th>Notification</th>
                        <th>Time</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($notifications as $n)
                    <tr class="{{ !$n->is_read ? 'table-active' : '' }}">
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                @if(!$n->is_read)
                                    <span class="badge bg-primary" style="width:8px;height:8px;border-radius:50%;padding:0;"></span>
                                @endif
                                <div>
                                    <strong>{{ $n->title }}</strong>
                                    <p class="mb-0 text-muted small">{{ strLimit($n->message, 80) }}</p>
                                </div>
                            </div>
                        </td>
                        <td>{{ showDateTime($n->created_at) }}</td>
                        <td>
                            <div class="d-flex gap-1">
                                <a href="{{ route('admin.notification.read', $n->id) }}" class="btn btn-sm btn-outline-info" title="View">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <form action="{{ route('admin.notification.delete', $n->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this notification?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger"><i class="fas fa-trash"></i></button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" class="text-center py-4 text-muted">No notifications</td>
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
