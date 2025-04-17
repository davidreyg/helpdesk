<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class GiveBasicPermissionToRolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $guard = 'web';
        $rol1 = Role::findByName(config('filament-shield.super_admin.name'), $guard);
        $rol1->givePermissionTo(\DB::table('permissions')->pluck('id')->toArray());

    }
}
