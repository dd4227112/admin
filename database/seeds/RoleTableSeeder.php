<?php

use Illuminate\Database\Seeder;
use App\Model\Role;
class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role = [
            [
                'name' => 'admin',
                'display_name' => 'System Administrator',
                'description' => 'System Admin can perform all system level tasks'
            ],
            [
                'name' => 'marketing',
                'display_name' => 'Marketing Agent',
                'description' => 'User can perform all marketing related duties'
            ],
            [
                'name' => 'sales',
                'display_name' => 'Sales Agent',
                'description' => 'User can perform all sales related duties'
            ]

        ];

        foreach ($role as $key => $value) {
            Role::create($value);
        }
    }
}
