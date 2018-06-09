<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Role;
use App\Permission;

class UserRolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->delete();

        //1) Create Admin Role
        $role = ['name' => 'admin', 'display_name' => 'Admin', 'description' => 'Full Permission'];
        $role = Role::create($role);

        //2) Set Role Permissions
        // Get all permission, swift through and attach them to the role
        $permission = Permission::get();
        foreach ($permission as $key => $value) {
            $role->attachPermission($value);
        }

        //3) Create Admin User
        $user = ['name' => 'Admin User', 'username' => 'superadministrator','email' => 'adminuser@test.com', 'password' => Hash::make('123456')];
        $user = User::create($user);

         //4) Set User Role
        $user->attachRole($role);
    }
}
