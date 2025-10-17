<?php

namespace Module\Training\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Module\System\Models\User;
use Module\Training\Models\TrainingRegister;

class TrainingRegisterPolicy
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
        if ($user->name === 'superadmin') {
            return true;
        }
    }

    /**
     * Determine whether the user can show the model.
     *
     * @param  \Module\System\Models\User  $user
     * @param  \Module\Training\Models\TrainingRegister  $trainingRegister
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function show(User $user, TrainingRegister $trainingRegister)
    {
        return $user->hasAnyPermission(
            'show-training-register'
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
            'view-training-register'
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
            'create-training-register'
        );
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \Module\System\Models\User  $user
     * @param  \Module\Training\Models\TrainingRegister  $trainingRegister
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, TrainingRegister $trainingRegister)
    {
        return $user->hasAnyPermission(
            'update-training-register'
        );
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \Module\System\Models\User  $user
     * @param  \Module\Training\Models\TrainingRegister  $trainingRegister
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, TrainingRegister $trainingRegister)
    {
        return $user->hasAnyPermission(
            'delete-training-register'
        );
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \Module\System\Models\User  $user
     * @param  \Module\Training\Models\TrainingRegister  $trainingRegister
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, TrainingRegister $trainingRegister)
    {
        return $user->hasAnyPermission(
            'restore-training-register'
        );
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \Module\System\Models\User  $user
     * @param  \Module\Training\Models\TrainingRegister  $trainingRegister
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function destroy(User $user, TrainingRegister $trainingRegister)
    {
        return $user->hasAnyPermission(
            'destroy-training-register'
        );
    }
}
