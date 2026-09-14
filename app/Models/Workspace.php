<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;


#[Fillable(['owner_id', 'name', 'slug'])]
class Workspace extends Model
{

    public function owner(): BelongsTo
    {
        // workspace.owner_id -> users.id
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function isOwner(User $user): bool
    {
        return $this->owner_id === $user->id;
    }

    public function hasMember(User $user): bool
    {
        return $this
            ->users()
            ->whereKey($user->id)
            ->exists();
    }

    public function hasAdmin(User $user): bool
    {
        return $this
            ->users()
            ->whereKey($user->id)
            ->wherePivot('role', 'admin')
            ->exists();
    }

    /**
     * Um Workspace possui vários projetos
     * HasMany: Define uma relação consultavél de um para muitos entre o modelo Workspace e o modelo Project.
     *
     * @return HasMany
     */
    public function projects(): HasMany
    {
        // projects.workspace_id -> workspaces.id
        return $this->hasMany(Project::class);
    }

    public function users(): BelongsToMany
    {
        // user_workspace.workspace_id -> workspaces.id
        // user_workspace.user_id -> users.id
        return $this->belongsToMany(User::class, 'user_workspace')
            ->withPivot([
                'role',
                'joined_at',
            ])->withTimestamps();
    }
}
