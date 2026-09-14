<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable(['name', 'email', 'password'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function workspacesOwned(): HasMany
    {
        // workspaces.owner_id -> users.id
        return $this->hasMany(Workspace::class, 'owner_id');
    }

    public function assignedTasks(): HasMany
    {
        // tasks.assignee_id -> users.id
        return $this->hasMany(Task::class, 'assignee_id');
    }

    public function workspaces(): BelongsToMany
    {
        // user_workspace.user_id -> users.id
        // user_workspace.workspace_id -> workspaces.id
        return $this->belongsToMany(Workspace::class, 'user_workspace')
            ->withPivot([
                'role',
                'joined_at',
            ])->withTimestamps();
    }
}
