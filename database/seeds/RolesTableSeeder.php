<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $commonUserRole = Role::create([
            'name' => 'user',
            'guard_name' => 'api'
        ]);

        $shopkeeperRole = Role::create([
            'name' => 'shopkeeper',
            'guard_name' => 'api'
        ]);

        $commonUserRole->syncPermissions($this->commonUserPermissions());
        $shopkeeperRole->syncPermissions($this->shopkeeperPermissions());
    }

    protected function commonUserPermissions()
    {
        return Permission::where('guard_name', 'api')->get();
    }

    protected function shopkeeperPermissions()
    {
        return Permission::where('guard_name', 'api')
            ->where('name', 'receive transfers')
            ->first();
    }
}
