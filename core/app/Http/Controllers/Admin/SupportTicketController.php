<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\SupportAttachment;
use App\Models\SupportMessage;
use App\Models\SupportTicket;
use Illuminate\Http\Request;

class SupportTicketController extends Controller
{
    public function tickets()
    {
        $pageTitle = 'Support Tickets';
        $tickets = $this->applySearch(SupportTicket::query())->with('user')->latest()->paginate(getPaginate());
        return view('admin.support.index', compact('pageTitle', 'tickets'));
    }

    public function pending()
    {
        $pageTitle = 'Open Tickets';
        $tickets = $this->applySearch(SupportTicket::open())->with('user')->latest()->paginate(getPaginate());
        return view('admin.support.index', compact('pageTitle', 'tickets'));
    }

    public function closed()
    {
        $pageTitle = 'Closed Tickets';
        $tickets = $this->applySearch(SupportTicket::closed())->with('user')->latest()->paginate(getPaginate());
        return view('admin.support.index', compact('pageTitle', 'tickets'));
    }

    protected function applySearch($query)
    {
        if ($search = request('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('ticket_id', 'like', "%{$search}%")
                    ->orWhere('subject', 'like', "%{$search}%")
                    ->orWhereHas('user', function ($user) use ($search) {
                        $user->where('firstname', 'like', "%{$search}%")
                            ->orWhere('lastname', 'like', "%{$search}%")
                            ->orWhere('username', 'like', "%{$search}%")
                            ->orWhere('email', 'like', "%{$search}%")
                            ->orWhere('mobile', 'like', "%{$search}%");
                    });
            });
        }
        return $query;
    }

    public function view($id)
    {
        $pageTitle = 'Ticket Details';
        $ticket = SupportTicket::with('messages.attachments')->findOrFail($id);
        return view('admin.support.view', compact('pageTitle', 'ticket'));
    }

    public function reply(Request $request, $id)
    {
        $request->validate(['message' => 'required|string']);
        $ticket = SupportTicket::findOrFail($id);
        $message = new SupportMessage();
        $message->support_ticket_id = $ticket->id;
        $message->admin_id = auth()->guard('admin')->id();
        $message->message = $request->message;
        $message->save();
        $ticket->status = 1;
        $ticket->save();
        return back()->with('success', 'Reply sent.');
    }

    public function close($id)
    {
        $ticket = SupportTicket::findOrFail($id);
        $ticket->status = 3;
        $ticket->save();
        return back()->with('success', 'Ticket closed.');
    }
}
