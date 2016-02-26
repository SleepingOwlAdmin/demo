<?php

namespace App\Policies;

use App\Model\Contact;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ContactPolicy
{
    use HandlesAuthorization;

    /**
     * @param User   $user
     * @param string $ability
     *
     * @return bool
     */
    public function before(User $user, $ability)
    {
        if ($user->isSuperAdmin()) {
            return true;
        }
    }

    /**
     * @param User    $user
     * @param Contact $contact
     *
     * @return bool
     */
    public function viewItem(User $user, Contact $contact)
    {
        return $user->isManager() && $contact->isAuthor($user);
    }

    /**
     * @param User    $user
     * @param Contact $contact
     *
     * @return bool
     */
    public function display(User $user, Contact $contact)
    {
        return $user->isManager();
    }

    /**
     * @param User    $user
     * @param Contact $contact
     *
     * @return bool
     */
    public function create(User $user, Contact $contact)
    {
        return $user->isManager();
    }

    /**
     * @param User    $user
     * @param Contact $contact
     *
     * @return bool
     */
    public function edit(User $user, Contact $contact)
    {
        return $user->isManager() && $contact->isAuthor($user);
    }
    /**
     * @param User    $user
     * @param Contact $contact
     *
     * @return bool
     */
    public function restore(User $user, Contact $contact)
    {
        return $user->isManager() && $contact->isAuthor($user);
    }

    /**
     * @param User    $user
     * @param Contact $contact
     *
     * @return bool
     */
    public function delete(User $user, Contact $contact)
    {
        return $user->isManager() && $contact->isAuthor($user);
    }
}
