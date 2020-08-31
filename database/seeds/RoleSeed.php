<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role = Role::create(['name' => 'administrator']);
        $role->givePermissionTo('users_manage');
        $role = Role::create(['name' => 'analyst']);
        $role->givePermissionTo('tracking_manage');
        $role = Role::create(['name' => 'client']);
        $role->givePermissionTo('business_manage');
    }
}
