<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether user can make transfers
     * @param User $user
     * @return bool
     */
    public function transfer(User $user)
    {
        return $user->can('make transfers');
    }

    /**
     * Determine whether user can receive transfers
     * @param User $user
     * @return bool
     */
    public function receiveTransfer(User $user)
    {
        return $user->can('receive transfers');
    }
}
