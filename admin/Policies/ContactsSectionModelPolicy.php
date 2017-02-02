<?php

namespace Admin\Policies;

use Admin\Http\Sections\Contacts;
use App\Model\Contact;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ContactsSectionModelPolicy
{
    use HandlesAuthorization;

    /**
     * @param User $user
     * @param string $ability
     * @param Contacts $section
     * @param Contact $contact
     *
     * @return bool
     */
    public function before(User $user, $ability, Contacts $section, Contact $contact)
    {
        if ($user->isSuperAdmin()) {
            return true;
        }
    }

    /**
     * @param User $user
     * @param Contacts $section
     * @param Contact $contact
     *
     * @return bool
     */
    public function display(User $user, Contacts $section, Contact $contact)
    {
        return $user->isManager();
    }

    /**
     * @param User $user
     * @param Contacts $section
     * @param Contact $contact
     *
     * @return bool
     */
    public function create(User $user, Contacts $section, Contact $contact)
    {
        return $user->isManager();
    }

    /**
     * @param User $user
     * @param Contacts $section
     * @param Contact $contact
     *
     * @return bool
     */
    public function edit(User $user, Contacts $section, Contact $contact)
    {
        return $user->isManager() && $contact->isAuthor($user);
    }

    /**
     * @param User $user
     * @param Contacts $section
     * @param Contact $contact
     *
     * @return bool
     */
    public function restore(User $user, Contacts $section, Contact $contact)
    {
        return $user->isManager() && $contact->isAuthor($user);
    }

    /**
     * @param User $user
     * @param Contacts $section
     * @param Contact $contact
     *
     * @return bool
     */
    public function delete(User $user, Contacts $section, Contact $contact)
    {
        return $user->isManager() && $contact->isAuthor($user);
    }
}
