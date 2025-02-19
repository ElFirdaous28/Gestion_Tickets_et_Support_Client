<?php

namespace Database\Seeders;
use App\Models\Category;
use App\Models\Ticket;


// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Category::factory()->count(10)->create();
        Ticket::factory()->count(10)->create();
    }
}
