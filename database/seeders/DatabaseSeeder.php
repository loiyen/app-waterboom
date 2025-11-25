<?php

namespace Database\Seeders;

use App\Models\Holidays;
use App\Models\Tickes;
use App\Models\Ticket_categories;
use App\Models\Ticket_prices;
use App\Models\TicketCategories;
use App\Models\TicketPrices;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use PHPUnit\Framework\Attributes\Ticket;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();
        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        
          User::factory(5)->create();
          Tickes::factory(5)->create();
          TicketPrices::factory(5)->create();
          TicketCategories::factory(5)->create();
          Holidays::factory(5)->create();

    }
}
