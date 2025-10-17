<?php

namespace Module\Training\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Module\System\Models\User;
use Module\Training\Models\TrainingCluster;

class TrainingClusterPolicy
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
     * @param  \Module\Training\Models\TrainingCluster  $trainingCluster
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function show(User $user, TrainingCluster $trainingCluster)
    {
        return $user->hasAnyPermission(
            'show-training-cluster'
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
            'view-training-cluster'
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
            'create-training-cluster'
        );
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \Module\System\Models\User  $user
     * @param  \Module\Training\Models\TrainingCluster  $trainingCluster
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, TrainingCluster $trainingCluster)
    {
        return $user->hasAnyPermission(
            'update-training-cluster'
        );
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \Module\System\Models\User  $user
     * @param  \Module\Training\Models\TrainingCluster  $trainingCluster
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, TrainingCluster $trainingCluster)
    {
        return $user->hasAnyPermission(
            'delete-training-cluster'
        );
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \Module\System\Models\User  $user
     * @param  \Module\Training\Models\TrainingCluster  $trainingCluster
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, TrainingCluster $trainingCluster)
    {
        return $user->hasAnyPermission(
            'restore-training-cluster'
        );
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \Module\System\Models\User  $user
     * @param  \Module\Training\Models\TrainingCluster  $trainingCluster
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function destroy(User $user, TrainingCluster $trainingCluster)
    {
        return $user->hasAnyPermission(
            'destroy-training-cluster'
        );
    }
}
