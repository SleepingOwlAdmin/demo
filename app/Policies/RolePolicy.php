<?php

namespace App\Policies;

use App\User;
use App\Role;
use Illuminate\Auth\Access\HandlesAuthorization;

class RolePolicy
{

    use HandlesAuthorization;

    /**
     * @param User   $user
     * @param string $ability
     *
     * @param Role   $item
     *
     * @return bool
     */
    public function before(User $user, $ability, Role $item)
    {
        if ($user->isSuperAdmin()) {
            if ($ability != 'display' && $ability != 'create' && $item->id <= 2) {
                return false;
            }

            return true;
        }
    }

    /**
     * @param User $user
     * @param Role $item
     *
     * @return bool
     */
    public function display(User $user, Role $item)
    {
        return $user->isSuperAdmin();
    }

    /**
     * @param User $user
     * @param Role $item
     *
     * @return bool
     */
    public function edit(User $user, Role $item)
    {
        return $item->id > 2;
    }

    /**
     * @param User $user
     * @param Role $item
     *
     * @return bool
     */
    public function delete(User $user, Role $item)
    {
        return $item->id > 2;
    }
}
