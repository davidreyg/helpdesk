<?php

namespace Database\Factories;

use App\Enums\DocumentTypeEnum;
use App\Enums\GenderEnum;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Employee>
 */
class EmployeeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'names' => $this->faker->firstName(),
            'paternal_surname' => $this->faker->lastName(),
            'maternal_surname' => $this->faker->lastName(),
            'email' => $this->faker->unique()->safeEmail(),
            'phone' => $this->faker->numerify('9########'), // Assuming a 9-digit phone number
            'birth_date' => $this->faker->date(),
            'document_type' => $this->faker->randomElement(DocumentTypeEnum::cases())->value,
            'document_number' => $this->faker->numerify('########'), // 8-digit document number
            'gender' => $this->faker->randomElement(GenderEnum::cases())->value,
            'address' => $this->faker->address(),
        ];
    }
}
