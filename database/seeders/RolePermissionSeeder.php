<?php

namespace Database\Seeders;

// Database\Seeders\RolePermissionSeeder.php
use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    public function run()
    {
        $adminRole = Role::create(['name' => 'admin']);
        $administratorRole = Role::create(['name' => 'administrator']);
        $technicianRole = Role::create(['name' => 'teknisi']);
        $viewerRole = Role::create(['name' => 'viewer']);
        $userRole = Role::create(['name' => 'user']);

        $permission1 = Permission::create(['name' => 'view_dashboard']);
        $permission2 = Permission::create(['name' => 'edit_users']);
        // Tambahkan permission lainnya

        // Berikan permission ke role tertentu
        $adminRole->permissions()->attach([$permission1->id, $permission2->id]);
        $administratorRole->permissions()->attach([$permission1->id]);
    }
}

