<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\SupportAttachment;
use App\Models\SupportMessage;
use App\Models\SupportTicket;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    public function index()
    {
        $pageTitle = 'Support Tickets';
        $tickets = auth()->user()->supportTickets()->latest()->paginate(getPaginate());
        return view('templates.basic.user.support.index', compact('pageTitle', 'tickets'));
    }

    public function create()
    {
        $pageTitle = 'New Ticket';
        return view('templates.basic.user.support.create', compact('pageTitle'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
            'priority' => 'required|in:low,medium,high',
        ]);

        $user = auth()->user();
        $ticketId = 'TK' . time() . rand(1000, 9999);

        $ticket = new SupportTicket();
        $ticket->user_id = $user->id;
        $ticket->ticket_id = $ticketId;
        $ticket->name = $user->fullname();
        $ticket->email = $user->email;
        $ticket->subject = $request->subject;
        $ticket->message = $request->message;
        $ticket->priority = $request->priority == 'low' ? 0 : ($request->priority == 'medium' ? 1 : 2);
        $ticket->status = 0;
        $ticket->save();

        return redirect()->route('user.ticket.view', $ticket->id)->with('success', 'Ticket created successfully.');
    }

    public function view($id)
    {
        $pageTitle = 'Ticket Details';
        $ticket = auth()->user()->supportTickets()->with('messages.attachments')->findOrFail($id);
        return view('templates.basic.user.support.view', compact('pageTitle', 'ticket'));
    }

    public function reply(Request $request, $id)
    {
        $request->validate(['message' => 'required|string']);
        $ticket = auth()->user()->supportTickets()->findOrFail($id);
        if ($ticket->status == 3) {
            return back()->withErrors(['Ticket is closed.']);
        }
        $message = new SupportMessage();
        $message->support_ticket_id = $ticket->id;
        $message->message = $request->message;
        $message->save();
        $ticket->status = 2;
        $ticket->save();
        return back()->with('success', 'Reply sent.');
    }

    public function close($id)
    {
        $ticket = auth()->user()->supportTickets()->findOrFail($id);
        $ticket->status = 3;
        $ticket->save();
        return back()->with('success', 'Ticket closed.');
    }
}
