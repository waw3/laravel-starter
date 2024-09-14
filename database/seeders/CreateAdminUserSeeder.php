<?php

namespace Database\Seeders;

use App\Models\Blog;
use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;

class CreateAdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        // Create Roles
        $admin = Role::create(['name' => 'admin']);
        $user = Role::create(['name' => 'user']);

        // Create Permissions
        $permissions = Permission::defaultPermissions();

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        if (app()->runningInConsole()) {
            $this->command->info('Default Permissions added.');
        }

        // ALWAYS GIVE ADMIN ROLE ALL PERMISSIONS
        $admin->givePermissionTo(Permission::all());

        // Assign Permissions to other Roles
        $user->givePermissionTo([
            'backend.index',
            'backend.users.index',
            'backend.users.show',
            'backend.blogs.index',
            'backend.blogs.show',
        ]);

        // Create Admin Test Users
        User::factory()
            ->has(
                Blog::factory()
                    ->count(3)
            )
            ->create([
            'first_name' => 'Admin',
            'last_name' => 'User',
            'email' => 'admin@email.com',
            'password' => 'password',
            'active' => true,
            'email_verified_at' => date_create()->format('Y-m-d H:i:s'),
            ])
            ->assignRole('admin');

        // Create Default Test Users
        User::factory()
            ->create([
                'first_name' => 'Default',
                'last_name' => 'User',
                'email' => 'user@email.com',
                'password' => 'password',
                'active' => true,
                'email_verified_at' => date_create()->format('Y-m-d H:i:s'),
            ])
            ->assignRole('user');

        // Create 5 Test Users
        User::factory()
            ->count(5)
            ->create()
            ->each(function ($user) {
                $user->assignRole('user');
            });

    }
}
