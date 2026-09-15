<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\StoreProjectRequest;
use App\Http\Requests\UpdateProjectRequest;
use App\Models\Project;
use App\Models\Workspace;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ProjectController extends Controller
{
    /**
     * Exibe os projetos de um workspace.
     */
    public function index(Workspace $workspace): View
    {

        $projects = $workspace
            ->projects()
            ->withCount('tasks')
            ->latest()
            ->paginate(12);

        return view('workspaces.projects.index', [
            'workspace' => $workspace,
            'projects' => $projects,
        ]);
    }

    public function create(Workspace $workspace): View
    {
        return view('workspaces.projects.create', [
            'workspace' => $workspace,
        ]);
    }

    /**
     * Cria um Project dentro do Workspace.
     */
    public function store(
        StoreProjectRequest $request,
        Workspace $workspace
    ): RedirectResponse
    {
        $data = $request->validated();
        $workspace
            ->projects()
            ->create([
                'name' => $data['name'],
            ]);
        return redirect()
            ->route('workspaces.projects.index', $workspace)
            ->with('success', 'Projeto criado com sucesso.');
    }

    /**
     * Exibe o formulário de edição.
     */
    public function edit(
        Workspace $workspace,
        Project $project
    ): View
    {
        return view('workspaces.projects.edit', [
            'workspace' => $workspace,
            'project' => $project,
        ]);
    }

    /**
     * Atualiza o Project.
     */
    public function update(
        UpdateProjectRequest $request,
        Workspace $workspace,
        Project $project
    ): RedirectResponse {
        $data = $request->validated();

        $project->update([
            'name' => $data['name'],
        ]);

        return redirect()
            ->route('workspaces.projects.index', $workspace)
            ->with(
                'success',
                'Projeto atualizado com sucesso.'
            );
    }

    /**
     * Exclui o Project.
     */
    public function destroy(
        Workspace $workspace,
        Project $project
    ): RedirectResponse {
        $project->delete();

        return redirect()
            ->route('workspaces.projects.index', $workspace)
            ->with(
                'success',
                'Projeto excluído com sucesso.'
            );
    }
}
