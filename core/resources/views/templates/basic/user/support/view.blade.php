@extends('templates.basic.layouts.app')

@section('title', 'Ticket #' . ($ticket->ticket ?? ''))

@section('content')
<section class="pt-28 pb-16">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center gap-3 mb-8">
            <a href="{{ route('user.ticket.index') }}" class="w-10 h-10 rounded-lg border border-gray-200 flex items-center justify-center text-gray-500 hover:border-emerald-300 hover:text-emerald-500 transition-colors">
                <i class="fas fa-arrow-left"></i>
            </a>
            <div class="flex-1">
                <div class="flex items-center gap-3">
                    <h1 class="text-2xl lg:text-3xl font-bold text-gray-900">{{ $ticket->subject ?? 'Ticket' }}</h1>
                    <span class="text-xs font-mono text-gray-400">#{{ $ticket->ticket ?? '' }}</span>
                </div>
                <div class="flex items-center gap-3 mt-1">
                    @if($ticket->priority == 'high')
                        <span class="badge badge-danger">High Priority</span>
                    @elseif($ticket->priority == 'medium')
                        <span class="badge badge-pending">Medium Priority</span>
                    @else
                        <span class="badge badge-info">Low Priority</span>
                    @endif
                    @if($ticket->status == Status::TICKET_OPEN)
                        <span class="badge badge-info">Open</span>
                    @elseif($ticket->status == Status::TICKET_ANSWERED)
                        <span class="badge badge-success">Answered</span>
                    @elseif($ticket->status == Status::TICKET_REPLIED)
                        <span class="badge badge-pending">Replied</span>
                    @elseif($ticket->status == Status::TICKET_CLOSED)
                        <span class="badge badge-danger">Closed</span>
                    @endif
                </div>
            </div>
        </div>

        {{-- Messages --}}
        <div class="space-y-4 mb-8">
            @if(isset($messages) && $messages->count())
                @foreach($messages as $msg)
                    <div class="card p-5 lg:p-6 {{ $msg->is_admin ? 'border-l-4 border-emerald-500' : '' }}">
                        <div class="flex items-start justify-between mb-3">
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 rounded-full {{ $msg->is_admin ? 'bg-emerald-100' : 'bg-blue-100' }} flex items-center justify-center">
                                    <i class="fas {{ $msg->is_admin ? 'fa-headset text-emerald-500' : 'fa-user text-blue-500' }} text-sm"></i>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-900">{{ $msg->is_admin ? 'Support Team' : 'You' }}</p>
                                    <p class="text-xs text-gray-400">{{ showDateTime($msg->created_at) }}</p>
                                </div>
                            </div>
                        </div>
                        <p class="text-sm text-gray-600 leading-relaxed">{{ $msg->message }}</p>
                        @if($msg->attachment)
                            <a href="{{ asset($msg->attachment) }}" target="_blank" class="inline-flex items-center gap-2 text-xs text-emerald-500 hover:text-emerald-600 mt-3">
                                <i class="fas fa-paperclip"></i> View Attachment
                            </a>
                        @endif
                    </div>
                @endforeach
            @else
                <div class="card p-8 text-center">
                    <p class="text-sm text-gray-400">No messages yet.</p>
                </div>
            @endif
        </div>

        {{-- Reply Form --}}
        @if($ticket->status != Status::TICKET_CLOSED)
            <div class="card p-6 lg:p-8">
                <h2 class="text-lg font-bold text-gray-900 mb-5">Reply</h2>
                <form method="POST" action="{{ route('user.ticket.reply', $ticket->id) }}" enctype="multipart/form-data">
                    @csrf
                    <div>
                        <textarea name="message" rows="4" class="form-input resize-none" placeholder="Type your reply..." required></textarea>
                    </div>
                    <div class="mt-4">
                        <input type="file" name="attachment" class="form-input file:text-sm file:border-0 file:bg-emerald-50 file:text-emerald-600 file:font-medium file:rounded-lg file:px-4 file:py-2 file:cursor-pointer">
                    </div>
                    <div class="flex items-center gap-3 mt-5">
                        <button type="submit" class="btn-primary">
                            <i class="fas fa-reply"></i> Send Reply
                        </button>
                        @if($ticket->status != Status::TICKET_CLOSED)
                            <a href="{{ route('user.ticket.close', $ticket->id) }}" class="text-sm font-medium text-red-500 hover:text-red-600" onclick="return confirm('Close this ticket?')">
                                <i class="fas fa-times-circle"></i> Close Ticket
                            </a>
                        @endif
                    </div>
                </form>
            </div>
        @else
            <div class="card p-6 text-center">
                <p class="text-sm text-gray-500">This ticket is closed.</p>
                <a href="{{ route('user.ticket.index') }}" class="btn-primary mt-4">Back to Tickets</a>
            </div>
        @endif
    </div>
</section>
@endsection
