<?php

namespace App\Policies;

use App\Models\ArticleCategory;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ArticleCategoryPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function index(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\ArticleCategory  $articleCategory
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, ArticleCategory $articleCategory)
    {
        return $user->id === $articleCategory->user_id;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\ArticleCategory  $articleCategory
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, ArticleCategory $articleCategory)
    {
        return $user->id === $articleCategory->user_id;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\ArticleCategory  $articleCategory
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, ArticleCategory $articleCategory)
    {
        return $user->id === $articleCategory->user_id;
    }

}
