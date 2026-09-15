<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\User;
use App\Models\Workspace;

class WorkspacePolicy
{
    public function view(
        User $user,
        Workspace $workspace
    ): bool {
        return $workspace
        ->isOwner($user)
            || $workspace->hasMember($user);
    }

    public function manageMembers(
        User $user,
        Workspace $workspace
    ): bool {
        return $workspace
            ->isOwner($user)
                || $workspace->hasAdmin($user);
    }

    public function manageProjects(
        User $user,
        Workspace $workspace
    ): bool
    {
        return $workspace
            ->isOwner($user)
                || $workspace->hasAdmin($user);
    }
}
