<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Models\Project;
use App\Models\Task;
use App\Models\Workspace;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Collection;
use Illuminate\View\View;

class TaskController extends Controller
{
    public function index(
        Workspace $workspace,
        Project $project
    ): View {
        $tasks = $project
            ->tasks()
            ->with('assignee')
            ->latest()
            ->paginate(15);

        return view('workspaces.projects.tasks.index', [
            'workspace' => $workspace,
            'project' => $project,
            'tasks' => $tasks,
        ]);
    }

    public function create(
        Workspace $workspace,
        Project $project
    ): View {
        return view('workspaces.projects.tasks.create', [
            'workspace' => $workspace,
            'project' => $project,
            'assignees' => $this->assignees($workspace),
        ]);
    }

    public function store(
        StoreTaskRequest $request,
        Workspace $workspace,
        Project $project
    ): RedirectResponse {
        $data = $request->validated();

        $project
            ->tasks()
            ->create([
                'title' => $data['title'],
                'description' => $data['description'] ?? null,
                'status' => $data['status'],
                'priority' => $data['priority'],
                'assigned_to' => $data['assigned_to'] ?? null,
                'due_at' => $data['due_at'] ?? null,

                /*
                 * completed_at é controlado pelo backend.
                 */
                'completed_at' => $data['status'] === 'done'
                    ? now()
                    : null,
            ]);

        return redirect()
            ->route(
                'workspaces.projects.tasks.index',
                [
                    'workspace' => $workspace,
                    'project' => $project,
                ]
            )
            ->with(
                'success',
                'Tarefa criada com sucesso.'
            );
    }

    public function edit(
        Workspace $workspace,
        Project $project,
        Task $task
    ): View {
        return view('workspaces.projects.tasks.edit', [
            'workspace' => $workspace,
            'project' => $project,
            'task' => $task,
            'assignees' => $this->assignees($workspace),
        ]);
    }

    public function update(
        UpdateTaskRequest $request,
        Workspace $workspace,
        Project $project,
        Task $task
    ): RedirectResponse {
        $data = $request->validated();

        /*
         * Se estava aberta e agora ficou done,
         * registramos a conclusão.
         */
        if (
            $task->status !== 'done'
            && $data['status'] === 'done'
        ) {
            $completedAt = now();

        /*
         * Se estava concluída e foi reaberta,
         * removemos a data de conclusão.
         */
        } elseif ($data['status'] !== 'done') {
            $completedAt = null;

        /*
         * Continua concluída:
         * preservamos a data original.
         */
        } else {
            $completedAt = $task->completed_at;
        }

        $task->update([
            'title' => $data['title'],
            'description' => $data['description'] ?? null,
            'status' => $data['status'],
            'priority' => $data['priority'],
            'assigned_to' => $data['assigned_to'] ?? null,
            'due_at' => $data['due_at'] ?? null,
            'completed_at' => $completedAt,
        ]);

        return redirect()
            ->route(
                'workspaces.projects.tasks.index',
                [
                    'workspace' => $workspace,
                    'project' => $project,
                ]
            )
            ->with(
                'success',
                'Tarefa atualizada com sucesso.'
            );
    }

    public function destroy(
        Workspace $workspace,
        Project $project,
        Task $task
    ): RedirectResponse {
        $task->delete();

        return redirect()
            ->route(
                'workspaces.projects.tasks.index',
                [
                    'workspace' => $workspace,
                    'project' => $project,
                ]
            )
            ->with(
                'success',
                'Tarefa removida com sucesso.'
            );
    }

    private function assignees(
        Workspace $workspace
    ): Collection
    {
        $members = $workspace
            ->users()
            ->orderBy('name')
            ->get();
        return $members
            ->prepend($workspace->owner)
            ->filter()
            ->unique('id')
            ->sortBy('name')
            ->values();
    }
}
