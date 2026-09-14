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
        if ($workspace->owner_id === $user->id) {
            return true;
        }

        return $workspace
            ->users()
            ->whereKey($user->id)
            ->exists();
    }

    public function manageMembers(
        User $user,
        Workspace $workspace
    ): bool {
        if ($workspace->owner_id === $user->id) {
            return true;
        }

        return $workspace
            ->users()
            ->whereKey($user->id)
            ->wherePivot('role', 'admin')
            ->exists();
    }
}
