<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;


#[Fillable(['name', 'slug'])]
class Workspace extends Model
{

    public function owner(): BelongsTo
    {
        // workspace.owner_id -> users.id
        return $this->belongsTo(User::class, 'owner_id');
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
}
