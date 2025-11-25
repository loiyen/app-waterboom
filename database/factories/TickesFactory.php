<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Tickes>
 */
class TickesFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
       return [
            'ticket_name' => $this->faker->words(2, true),   // contoh: "Family Pass"
            'description' => $this->faker->sentence(10),     // contoh: "Enjoy a fun day with your family."
        ];
    }
}
