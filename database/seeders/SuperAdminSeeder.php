<?php

namespace Database\Seeders;

use App\Enums\DocumentTypeEnum;
use App\Enums\GenderEnum;
use App\Models\Company;
use App\Models\Employee;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $employee = Employee::create([
            'names' => 'Fany',
            'paternal_surname' => 'García',
            'maternal_surname' => 'Farfán',
            'email' => 'fanygarcia@gmail.com',
            'phone' => '9999999', // Assuming a 9-digit phone number
            'birth_date' => '30-05-1998',
            'document_type' => DocumentTypeEnum::DNI,
            'document_number' => fake()->numerify('########'), // 8-digit document number
            'gender' => GenderEnum::F,
            'address' => fake()->address(),
            'company_id' => Company::first()->id,
        ]);
        $superadmin = User::create([
            'name' => 'superadmin',
            'email' => 'fany@superadmin.com',
            'email_verified_at' => now(),
            'password' => \Hash::make('password'),
            'remember_token' => \Str::random(10),
            'employee_id' => $employee->id,
        ]);

        $superadmin->assignRole(config('filament-shield.super_admin.name'));
    }
}
