<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesandPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user1 = User::create([
            'name'      => 'Administrator',
            'email'     => 'admin@email.com',
            'password'  => bcrypt('password')
        ]);

        $user2 = User::create([
            'name'      => 'User',
            'email'     => 'user@email.com',
            'password'  => bcrypt('password')
        ]);

        $admin     = Role::create(['name'  => 'admin']);
        $user    = Role::create(['name'  => 'user']);

        Permission::create(['name'  => 'manage']);
        Permission::create(['name'  => 'view']);

        $admin->givePermissionTo('manage');
        $user->givePermissionTo('view');

        $user1->assignRole($admin);
        $user2->assignRole($user);
    }
}
