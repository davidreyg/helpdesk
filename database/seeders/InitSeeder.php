<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class InitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->sedePrincipal();
        $companies = base_path('database/sql/companies.sql');
        if (file_exists($companies)) {
            $sql = file_get_contents($companies);
            \DB::unprepared($sql);
        }
    }
    public function sedePrincipal()
    {
        $data = [
            'name' => 'Master Electronics Perú S.A.C',
            'document_number' => 99999999,
            'address' => 'Calle Los Pepitos S/N',
            'phone' => 955927839,
        ];

        \DB::table('companies')->insert($data);
    }
}
