<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\Category;
use App\Models\User;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tickets = Ticket::all();
        $agents = User::where('role', 'agent')->get();
        return view('tickets.index', compact('tickets', 'agents'));
    }

    public function clientTickets()
    {
        $tickets = Ticket::where('user_id', auth()->id())
            ->whereNotIn('status', ['resolved'])
            ->get();

        return view('tickets.index', compact('tickets'));
    }


    public function agentAssignedTickets()
    {
        $tickets = Ticket::where('assigned_to', auth()->id())
            ->whereNotIn('status', ['resolved'])
            ->get();
        return view('tickets.index', compact('tickets'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        return view('tickets.create', compact('categories'));
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:150',
            'description' => 'required|string',
            'category_id' => 'required|exists:categories,id',
        ]);

        Ticket::create([
            'title' => $request->title,
            'description' => $request->description,
            'category_id' => $request->category_id,
            'user_id' => auth()->id(),
        ]);

        return redirect()->route('client.tickets.index')->with('success', 'Ticket created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Ticket $ticket)
    {
        // Ensure only the ticket owner or an admin can edit
        if (auth()->user()->id !== $ticket->user_id) {
            abort(403, 'Unauthorized action.');
        }

        $categories = Category::all();
        return view('tickets.create', compact('ticket', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Ticket $ticket)
    {
        // Ensure only the ticket owner or an admin can update
        if (auth()->user()->id !== $ticket->user_id && auth()->user()->role !== 'admin') {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'title' => 'required|string|max:150',
            'description' => 'required|string',
            'category_id' => 'required|exists:categories,id',
        ]);

        $ticket->update([
            'title' => $request->title,
            'description' => $request->description,
            'category_id' => $request->category_id,
        ]);


        return redirect()->route('client.tickets.index')->with('success', 'Ticket updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */

    public function destroy(Ticket $ticket)
    {
        $ticket->delete();
        return redirect()->route('client.tickets.index')->with('success', 'Ticket deleted successfully.');
    }

    public function changeStatus(Ticket $ticket,$newStatus)
    {

        $ticket->update([
            'status'=>$newStatus,
        ]);


        return redirect()->back()->with('success', 'Ticket updated successfully!');
    }
    public function assign(Request $request, $ticketId)
    {
        $request->validate([
            'agent_id' => 'required|exists:users,id',
        ]);

        $ticket = Ticket::findOrFail($ticketId);

        $ticket->assigned_to = $request->agent_id;
        $ticket->status = 'in_progress';
        $ticket->save();

        return redirect()->back()->with('success', 'Ticket assigned successfully.');
    }
}
