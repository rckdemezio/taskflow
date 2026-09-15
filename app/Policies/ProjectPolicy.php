<?php

namespace App\Policies;

use App\Models\Project;
use App\Models\User;
use App\Models\Workspace;

class ProjectPolicy
{

    /**
     * Decide se o usuário pode visualizar este Project.
     */
    public function view(
        User $user,
        Project $project
    ): bool
    {
        $workspace = $project->workspace;

        return $workspace->isOwner($user) || $workspace->hasMember($user);
    }

    /**
     * Decide se o usuário pode alterar este Project.
     *
     * Por enquanto a regra será:
     * somente owner ou admin.
     */
    public function update(User $user, Project $project): bool
    {
        $workspace = $project->workspace;

        return $workspace->isOwner($user) || $workspace->hasAdmin($user);
    }

    public function delete(
        User $user,
        Project $project
    ): bool {
        $workspace = $project->workspace;

        return $workspace->isOwner($user)
            || $workspace->hasAdmin($user);
    }

    public function manageTasks(
        User $user,
        Project $project
    ): bool
    {
        $workspace = $project->workspace;

        return $workspace->isOwner($user)
            || $workspace->hasMember($user);
    }
}
