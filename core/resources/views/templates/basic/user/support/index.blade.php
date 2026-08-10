@extends('templates.basic.layouts.app')

@section('title', 'Support Tickets')

@section('content')
<section class="pt-28 pb-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-8">
            <div>
                <h1 class="text-2xl lg:text-3xl font-bold text-gray-900">Support Tickets</h1>
                <p class="text-gray-500 text-sm mt-1">Manage your support requests</p>
            </div>
            <a href="{{ route('user.ticket.create') }}" class="mt-4 sm:mt-0 btn-primary text-sm !py-2.5 !px-5">
                <i class="fas fa-plus"></i> New Ticket
            </a>
        </div>

        <div class="card overflow-hidden">
            @if(isset($tickets) && $tickets->count())
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="bg-gray-50 border-b border-gray-100">
                                <th class="text-left py-4 px-4 lg:px-6 font-semibold text-gray-600 text-xs uppercase tracking-wider">Subject</th>
                                <th class="text-left py-4 px-4 lg:px-6 font-semibold text-gray-600 text-xs uppercase tracking-wider">Priority</th>
                                <th class="text-left py-4 px-4 lg:px-6 font-semibold text-gray-600 text-xs uppercase tracking-wider">Status</th>
                                <th class="text-left py-4 px-4 lg:px-6 font-semibold text-gray-600 text-xs uppercase tracking-wider">Last Reply</th>
                                <th class="text-left py-4 px-4 lg:px-6 font-semibold text-gray-600 text-xs uppercase tracking-wider">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($tickets as $ticket)
                                <tr class="border-b border-gray-50 hover:bg-gray-50/50 transition-colors">
                                    <td class="py-4 px-4 lg:px-6">
                                        <p class="font-medium text-gray-900">{{ $ticket->subject }}</p>
                                    </td>
                                    <td class="py-4 px-4 lg:px-6">
                                        @if($ticket->priority == 'high')
                                            <span class="badge badge-danger">High</span>
                                        @elseif($ticket->priority == 'medium')
                                            <span class="badge badge-pending">Medium</span>
                                        @else
                                            <span class="badge badge-info">Low</span>
                                        @endif
                                    </td>
                                    <td class="py-4 px-4 lg:px-6">
                                        @if($ticket->status == Status::TICKET_OPEN)
                                            <span class="badge badge-info">Open</span>
                                        @elseif($ticket->status == Status::TICKET_ANSWERED)
                                            <span class="badge badge-success">Answered</span>
                                        @elseif($ticket->status == Status::TICKET_REPLIED)
                                            <span class="badge badge-pending">Replied</span>
                                        @elseif($ticket->status == Status::TICKET_CLOSED)
                                            <span class="badge badge-danger">Closed</span>
                                        @endif
                                    </td>
                                    <td class="py-4 px-4 lg:px-6">
                                        <span class="text-gray-600 text-xs">{{ $ticket->last_reply ? showDateTime($ticket->last_reply) : 'N/A' }}</span>
                                    </td>
                                    <td class="py-4 px-4 lg:px-6">
                                        <a href="{{ route('user.ticket.view', $ticket->id) }}" class="text-sm font-medium text-emerald-500 hover:text-emerald-600">
                                            <i class="fas fa-eye"></i> View
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @if(method_exists($tickets, 'links'))
                    <div class="p-4 lg:p-6 border-t border-gray-100">
                        {{ $tickets->links() }}
                    </div>
                @endif
            @else
                <div class="p-12 text-center">
                    <div class="w-16 h-16 rounded-2xl bg-gray-100 flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-headset text-gray-400 text-2xl"></i>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 mb-1">No Tickets</h3>
                    <p class="text-sm text-gray-500">You haven't created any support tickets yet.</p>
                    <a href="{{ route('user.ticket.create') }}" class="btn-primary mt-5">Create Ticket</a>
                </div>
            @endif
        </div>
    </div>
</section>
@endsection
