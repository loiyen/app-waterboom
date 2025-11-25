<?php

namespace Database\Factories;

use App\Models\Tickes;
use App\Models\TicketCategories;
use Illuminate\Database\Eloquent\Factories\Factory;


/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Ticket_prices>
 */
class TicketPricesFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $startDate = $this->faker->dateTimeBetween('now', '+1 month');
        $endDate = (clone $startDate)->modify('+7 days');

        return [
            'ticket_id' => Tickes::inRandomOrder()->value('id') ?? 1,
            'ticket_category_id' => TicketCategories::inRandomOrder()->value('id') ?? 1,
            'price' => $this->faker->numberBetween(25000, 150000),
            'star_date' => $startDate->format('Y-m-d'),
            'end_date' => $endDate->format('Y-m-d'),
        ];
    }
}
