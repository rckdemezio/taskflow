<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;


#[Fillable(['name', 'slug'])]
class Workspace extends Model
{
    /**
     * Um Workspace possui vários projetos
     * HasMany: Define uma relação consultavél de um para muitos entre o modelo Workspace e o modelo Project.
     *
     * @return HasMany
     */
    public function projects(): HasMany
    {
        return $this->hasMany(Project::class);
    }
}
