<?php

namespace Database\Seeders;
use App\Models\User;
use App\Models\Category;
use App\Models\Ticket;
use App\Models\TicketMessage;


// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory()->count(10)->create();
        // Category::factory()->count(10)->create();
        Ticket::factory()->count(10)->create();
        TicketMessage::factory()->count(10)->create();
    }
}
