<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TicketController;

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/tickets', [TicketController::class, 'index'])->name('admin.tickets.index');
});
