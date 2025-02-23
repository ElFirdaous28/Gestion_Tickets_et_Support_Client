<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\TicketMessage;
use Illuminate\Http\Request;

class TicketMessageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $ticketId)
    {
        // Validate the request
        $request->validate([
            'content' => 'required|string|max:1000',
        ]);

        // Find the ticket
        $ticket = Ticket::findOrFail($ticketId);

        // Create the message
        TicketMessage::create([
            'content' => $request->content,
            'user_id' => auth()->id(),
            'ticket_id' => $ticket->id,
        ]);

        // Redirect back with success message
        return back()->with('success', 'Message sent successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(TicketMessage $ticketMessage)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TicketMessage $ticketMessage)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TicketMessage $ticketMessage)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TicketMessage $ticketMessage)
    {
        //
    }
}
