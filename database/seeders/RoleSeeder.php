<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create roles (or get existing ones)
        $superadmin = Role::firstOrCreate(['name' => 'superadmin']);
        $admin = Role::firstOrCreate(['name' => 'admin']);
        $editor = Role::firstOrCreate(['name' => 'editor']);
        $viewer = Role::firstOrCreate(['name' => 'viewer']);

        // Create permissions (optional - add as needed)
        $permissions = [
            'view users',
            'create users',
            'edit users',
            'delete users',
            'view roles',
            'create roles',
            'edit roles',
            'delete roles',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Assign permissions to roles (sync to avoid duplicates)
        $superadmin->syncPermissions(Permission::all());

        $admin->syncPermissions([
            'view users',
            'create users',
            'edit users',
            'delete users',
            'view roles',
        ]);

        $editor->syncPermissions([
            'view users',
            'edit users',
        ]);

        $viewer->syncPermissions([
            'view users',
            'view roles',
        ]);

        $this->command->info('Roles and permissions seeded successfully!');
    }
}
