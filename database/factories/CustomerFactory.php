<?php

namespace Database\Factories;

use App\Enums\CustomerGender;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Customer>
 */
class CustomerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'phone' => $this->faker->phoneNumber(),
            'gender' => $this->faker->randomElement(CustomerGender::cases()),
            'birth_date' => $this->faker->dateTimeBetween('-70 years', '-18 years'),
        ];
    }
}
