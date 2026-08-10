@extends('admin.layouts.master')
@section('content')
<div class="row g-4">
    <div class="col-xl-8">
        <div class="card">
            <div class="card-header">
                {{ $pageTitle }}
                <a href="{{ route('admin.ticket.index') }}" class="btn btn-sm btn-outline-secondary float-end">
                    <i class="fas fa-arrow-left"></i> Back
                </a>
            </div>
            <div class="card-body">
                <div class="mb-4">
                    <h5>{{ $ticket->subject }}</h5>
                    <div class="d-flex gap-3 text-muted small">
                        <span><strong>Ticket:</strong> #{{ $ticket->ticket_id }}</span>
                        <span><strong>User:</strong> {{ $ticket->user?->fullname() ?? 'N/A' }}</span>
                        <span><strong>Priority:</strong>
                            @if($ticket->priority == 'high')
                                <span class="badge bg-soft-danger">High</span>
                            @elseif($ticket->priority == 'medium')
                                <span class="badge bg-soft-warning">Medium</span>
                            @else
                                <span class="badge bg-soft-info">Low</span>
                            @endif
                        </span>
                        <span><strong>Status:</strong>
                            @if($ticket->status == 0)
                                <span class="badge bg-soft-warning">Open</span>
                            @elseif($ticket->status == 1)
                                <span class="badge bg-soft-info">Replied</span>
                            @elseif($ticket->status == 2)
                                <span class="badge bg-soft-success">Closed</span>
                            @else
                                <span class="badge bg-soft-danger">Resolved</span>
                            @endif
                        </span>
                    </div>
                </div>
                <hr>
                <div class="message-container">
                    @forelse($messages as $msg)
                    <div class="d-flex mb-4 {{ $msg->admin_id ? 'justify-content-end' : '' }}">
                        <div class="{{ $msg->admin_id ? 'bg-soft-primary' : 'bg-light' }} rounded-3 p-3" style="max-width:75%;">
                            <div class="d-flex justify-content-between mb-2">
                                <strong>{{ $msg->admin_id ? 'You' : $msg->user?->fullname() }}</strong>
                                <small class="text-muted">{{ showDateTime($msg->created_at) }}</small>
                            </div>
                            <p class="mb-0">{{ $msg->message }}</p>
                            @if($msg->file)
                            <a href="{{ asset('assets/images/tickets/'.$msg->file) }}" target="_blank" class="btn btn-sm btn-outline-info mt-2">
                                <i class="fas fa-paperclip"></i> View Attachment
                            </a>
                            @endif
                        </div>
                    </div>
                    @empty
                    <div class="text-center text-muted py-4">No messages yet</div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-4">
        @if($ticket->status != 2)
        <div class="card">
            <div class="card-header">Reply</div>
            <div class="card-body">
                <form action="{{ route('admin.ticket.reply', $ticket->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Message</label>
                        <textarea name="message" class="form-control" rows="4" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Attachment</label>
                        <input type="file" name="file" class="form-control">
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Send Reply</button>
                </form>
            </div>
        </div>
        @endif
        <div class="card mt-4">
            <div class="card-header">Actions</div>
            <div class="card-body">
                @if($ticket->status != 2)
                <form action="{{ route('admin.ticket.close', $ticket->id) }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-danger w-100" onclick="return confirm('Close this ticket?')">
                        <i class="fas fa-times"></i> Close Ticket
                    </button>
                </form>
                @else
                <span class="text-muted">This ticket is closed.</span>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
