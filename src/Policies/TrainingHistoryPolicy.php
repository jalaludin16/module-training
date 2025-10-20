<?php

namespace Module\Training\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Module\System\Models\User;
use Module\Training\Models\TrainingHistory;

class TrainingHistoryPolicy
{
    use HandlesAuthorization;

    /**
     * Perform pre-authorization checks.
     *
     * @param  \Module\System\Models\User  $user
     * @return void|bool
     */
    public function before(User $user, $ability)
    {
        if ($user->name === 'superadmin' || $user->hasAbility('profile-administrator')) {
            return true;
        }
    }

    /**
     * Determine whether the user can show the model.
     *
     * @param  \Module\System\Models\User  $user
     * @param  \Module\Training\Models\TrainingHistory  $trainingHistory
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function show(User $user, TrainingHistory $trainingHistory)
    {
        return $user->hasAnyPermission(
            'show-training-history'
        );
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \Module\System\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user)
    {
        return $user->hasAnyPermission(
            'view-training-history'
        );
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \Module\System\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        return $user->hasAnyPermission(
            'create-training-history'
        );
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \Module\System\Models\User  $user
     * @param  \Module\Training\Models\TrainingHistory  $trainingHistory
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, TrainingHistory $trainingHistory)
    {
        return $user->hasAnyPermission(
            'update-training-history'
        );
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \Module\System\Models\User  $user
     * @param  \Module\Training\Models\TrainingHistory  $trainingHistory
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, TrainingHistory $trainingHistory)
    {
        return $user->hasAnyPermission(
            'delete-training-history'
        );
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \Module\System\Models\User  $user
     * @param  \Module\Training\Models\TrainingHistory  $trainingHistory
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, TrainingHistory $trainingHistory)
    {
        return $user->hasAnyPermission(
            'restore-training-history'
        );
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \Module\System\Models\User  $user
     * @param  \Module\Training\Models\TrainingHistory  $trainingHistory
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function destroy(User $user, TrainingHistory $trainingHistory)
    {
        return $user->hasAnyPermission(
            'destroy-training-history'
        );
    }
}
