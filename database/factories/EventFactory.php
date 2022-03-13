<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Event>
 */
class EventFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'owner_id' => 1,
            'title' => Str::random(10),
            'description' => Str::random(50),
            'date' => date('Y-m-d H:i'),
            'ticket_price' => rand(1,100),
            'total_tickets' => rand(10,100),
        ];
    }
}
