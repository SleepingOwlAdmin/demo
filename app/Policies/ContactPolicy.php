<?php

namespace App\Policies;

use App\User;
use App\Model\Contact;
use Illuminate\Auth\Access\HandlesAuthorization;

class ContactPolicy
{
    use HandlesAuthorization;


    /**
     * @param User    $user
     * @param Contact $contact
     *
     * @return bool
     */
    public function display(User $user, Contact $contact)
    {
        return true;
    }

    /**
     * @param User    $user
     * @param Contact $contact
     *
     * @return bool
     */
    public function create(User $user, Contact $contact)
    {
        return true;
    }


    /**
     * @param User    $user
     * @param Contact $contact
     *
     * @return bool
     */
    public function edit(User $user, Contact $contact)
    {
        return true;
    }
    /**
     * @param User    $user
     * @param Contact $contact
     *
     * @return bool
     */
    public function restore(User $user, Contact $contact)
    {
        return $contact->id % 2;
    }

    /**
     * @param User    $user
     * @param Contact $contact
     *
     * @return bool
     */
    public function delete(User $user, Contact $contact)
    {
        return $contact->id % 2;
    }
}
