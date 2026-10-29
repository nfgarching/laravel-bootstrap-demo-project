<?php

namespace Database\Factories;

use App\Enums\ContactStatus;
use App\Models\Contact;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Contact>
 */
class ContactFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'city' => fake()->randomElement(['Musterstadt', 'Beispielhausen', 'Testdorf']),
            'status' => fake()->randomElement(ContactStatus::cases()),
            'newsletter' => fake()->boolean(),
            'memo' => fake()->optional()->sentence(),
        ];
    }
}
