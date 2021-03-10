<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->createPermission('make transfers');
        $this->createPermission('receive transfers');
    }

    protected function createPermission($name, $guard = 'api')
    {
        Permission::create([
            'name' => $name,
            'guard_name' => $guard,
        ]);
    }
}
