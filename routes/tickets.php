<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\TicketMessageController;

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/tickets', [TicketController::class, 'index'])->name('admin.tickets.index');
    Route::put('/tickets/{ticket}/assign', [TicketController::class, 'assign'])->name('tickets.assign');
});

Route::middleware(['auth', 'role:client'])->group(function () {
    Route::get('/client/tickets', [TicketController::class, 'clientTickets'])->name('client.tickets.index');
    Route::get('/tickets/create', [TicketController::class, 'create'])->name('tickets.create');
    Route::post('/tickets', [TicketController::class, 'store'])->name('tickets.store');

    Route::get('/tickets/{ticket}/edit', [TicketController::class, 'edit'])->name('tickets.edit');
    Route::put('/tickets/{ticket}', [TicketController::class, 'update'])->name('tickets.update');

    Route::delete('/tickets/{ticket}', [TicketController::class, 'destroy'])->name('tickets.destroy');
    Route::post('/tickets/{ticket}/close', [TicketController::class, 'close'])->name('tickets.close');
});

Route::middleware(['auth', 'role:agent'])->group(function () {
    Route::get('/agent/tickets', [TicketController::class, 'agentAssignedTickets'])->name('agent.tickets.index');
    Route::post('/tickets/{ticket}/status/{newStatus}', [TicketController::class, 'changeStatus'])->name('tickets.changeStatus');
});

// Show Ticket (must be last to avoid conflicts)
Route::get('/tickets/{ticket}', [TicketController::class, 'show'])->name('ticket.details');
Route::post('/tickets/{ticket}/messages', [TicketMessageController::class, 'store'])->name('messages.store');
