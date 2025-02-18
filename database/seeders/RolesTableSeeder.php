<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $super_admin = config('filament-shield.super_admin.name');
        DB::table('roles')->insert(
            [
                'name' => $super_admin,
                'guard_name' => 'web',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );

        // $roles = config('app-roles.roles');
        // foreach ($roles as $role) {
        //     DB::table('roles')->insert(
        //         [
        //             'name' => $role,
        //             'guard_name' => 'web',
        //             'created_at' => now(),
        //             'updated_at' => now(),
        //         ]
        //     );
        // }
    }
}
