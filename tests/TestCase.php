<?php

namespace Tests;

use App\Models\User;
use App\Models\Wallet;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Tymon\JWTAuth\Facades\JWTAuth;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected $shopkeeper, $commonUser;

    public function setUp(): void
    {
        // first include all the normal setUp operations
        parent::setUp();

        // now re-register all the roles and permissions (clears cache and reloads relations)
        $this->app->make(\Spatie\Permission\PermissionRegistrar::class)->registerPermissions();

        $this->setupRolesPermissions();
        $this->setupUserRoles();
    }

    public function setupRolesPermissions()
    {
        Permission::findOrCreate('make transfers', 'api');
        Permission::findOrCreate('receive transfers', 'api');

        $commonUserRole = Role::findOrCreate('user', 'api');
        $shopkeeperRole = Role::findOrCreate('shopkeeper', 'api');

        if (
            !($commonUserRole->hasPermissionTo('make transfers')
                || $commonUserRole->hasPermissionTo('receive transfers'))
        ) {
            $commonUserRole->givePermissionTo('make transfers', 'receive transfers');
        }

        if (!$shopkeeperRole->hasPermissionTo('receive transfers')) {
            $shopkeeperRole->givePermissionTo('receive transfers');
        }
    }

    public function setupUserRoles()
    {
        $this->shopkeeper = factory(User::class)->create();
        $this->shopkeeper->assignRole('shopkeeper');

        $this->commonUser = factory(User::class)->create();
        $this->commonUser->assignRole('user');

        Wallet::create([
            'user_id' => $this->commonUser->id,
            'value' => 100.0
        ]);

        Wallet::create([
            'user_id' => $this->shopkeeper->id,
            'value' => 100.0
        ]);
    }

    /**
     * Set the currently logged in user for the application.
     *
     * @param  \Illuminate\Contracts\Auth\Authenticatable $user
     * @param  string|null                                $driver
     * @return $this
     */
    public function actingAs($user, $driver = null)
    {
        $token = JWTAuth::fromUser($user);
        $this->withHeader('Authorization', "Bearer {$token}");
        parent::actingAs($user, $driver);

        return $this;
    }
}
