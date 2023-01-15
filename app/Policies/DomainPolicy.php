<?php

namespace App\Policies;

use App\Models\Domain;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class DomainPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param \App\Models\User $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\Domain $domain
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, Domain $domain)
    {
        return $user->id === $domain->user_id;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param \App\Models\User $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\Domain $domain
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, Domain $domain)
    {
        return $user->id === $domain->user_id;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\Domain $domain
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Domain $domain)
    {
        return $user->id === $domain->user_id;
    }

}
