<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\StoreWorkspaceRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Str;
use Illuminate\View\View;

class WorkspaceController extends Controller
{
    public function create(): View
    {
        return view('workspaces.create');
    }

    /**
     * Cria um novo Workspace para usuário autenticado.
     */
    public function store(
        StoreWorkspaceRequest $request,
    ): RedirectResponse {
        $data = $request->validated();

        $baseSlug = Str::slug($data['name']);

        if ($baseSlug === '') {
            $baseSlug = 'workspace';
        }

        $slug = $baseSlug.'-'.Str::lower(
            Str::random(6)
        );

        $workspace = $request
            ->user()
            ->workspacesOwned()
            ->create([
                'name' => $data['name'],
                'slug' => $slug,
            ]);

        return redirect()
            ->route('dashboard')
            ->with(
                'success',
                "Workspace {$workspace->name} criado com sucesso."
            );
    }
}
