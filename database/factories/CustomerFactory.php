<?php

namespace Database\Factories;

use App\Enums\DocumentTypeEnum;
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
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'phone' => $this->faker->numerify('9########'), // Assuming a 9-digit phone number
            'document_type' => $this->faker->randomElement(DocumentTypeEnum::cases())->value,
            'document_number' => $this->faker->numerify('########'), // 8-digit document number
            'address' => $this->faker->address(),
        ];
    }
}
