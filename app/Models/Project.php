<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['workspace_id', 'name', 'description', 'status','due_date'])]
class Project extends Model
{
    /**
     * Todo projeto pertence a um Workspace
     * BelongsTo: Define uma relação consultavél de muitos para um entre o modelo Project e o modelo Workspace.
     *
     * @return BelongsTo
     */
    public function workspace(): BelongsTo
    {
        return $this->belongsTo(Workspace::class);
    }

    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class);
    }
}
