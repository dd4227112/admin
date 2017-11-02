<?php
use App\Model\Permission;
use App\Model\Role;
use App\User;
use Illuminate\Database\Seeder;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permission = [

            /*Role Permissions*/
            [
                'name' => 'role-list',
                'display_name' => 'Display Role Listing',
                'description' => 'See only Listing Of Role'
            ],
            [
                'name' => 'role-create',
                'display_name' => 'Create Role',
                'description' => 'Create New Role'
            ],
            [
                'name' => 'role-edit',
                'display_name' => 'Edit Role',
                'description' => 'Edit Role'
            ],
            [
                'name' => 'role-delete',
                'display_name' => 'Delete Role',
                'description' => 'Delete Role'
            ],

        ];
        foreach ($permission as $key => $value) {
            Permission::create($value);
        }

        $permissions = Permission::get();

        $role = Role::where('name','admin')->first();

        $user = User::where('email', '=', 'swillae1@gmail.com')->first();

       // role attach alias
        $user->attachRole($role); // parameter can be an Role object, array, or id



        $role->attachPermissions($permissions);
    }
}