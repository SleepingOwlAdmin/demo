<?php

namespace Admin\Policies;

use Admin\Http\Sections\Roles;
use App\User;
use App\Role;
use Illuminate\Auth\Access\HandlesAuthorization;

class RolesSectionModelPolicy
{

    use HandlesAuthorization;

    /**
     * @param User $user
     * @param string $ability
     * @param Roles $section
     * @param Role $item
     *
     * @return bool
     */
    public function before(User $user, $ability, Roles $section, Role $item)
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
     * @param Roles $section
     * @param Role $item
     *
     * @return bool
     */
    public function display(User $user, Roles $section, Role $item)
    {
        return $user->isSuperAdmin();
    }

    /**
     * @param User $user
     * @param Roles $section
     * @param Role $item
     *
     * @return bool
     */
    public function edit(User $user, Roles $section, Role $item)
    {
        return $item->id > 2;
    }

    /**
     * @param User $user
     * @param Roles $section
     * @param Role $item
     *
     * @return bool
     */
    public function delete(User $user, Roles $section, Role $item)
    {
        return $item->id > 2;
    }
}
