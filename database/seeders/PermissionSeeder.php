<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Permission::insert([
            // User
            ['name' => 'user-add', 'guard_name' => 'web'],
            ['name' => 'user-list', 'guard_name' => 'web'],
            ['name' => 'user-edit', 'guard_name' => 'web'],
            ['name' => 'user-delete', 'guard_name' => 'web'],
            //Role
            ['name' => 'role-add', 'guard_name' => 'web'],
            ['name' => 'role-list', 'guard_name' => 'web'],
            ['name' => 'role-edit', 'guard_name' => 'web'],
            ['name' => 'role-delete', 'guard_name' => 'web'],
            //Role
            ['name' => 'permission-add', 'guard_name' => 'web'],
            ['name' => 'permission-list', 'guard_name' => 'web'],
            ['name' => 'permission-edit', 'guard_name' => 'web'],
            ['name' => 'permission-delete', 'guard_name' => 'web'],
        ]);
    }
}
