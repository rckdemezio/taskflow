<h1>
    {{ $project->name }}
</h1>

@can('manageTasks', $project)
    <a
        href="{{ route('workspaces.projects.tasks.create', [
            'workspace' => $workspace,
            'project' => $project,
        ]) }}">
        Nova tarefa
    </a>
@endcan
@forelse ($tasks as $task)
    <article>

        <h2>
            {{ $task->title }}
        </h2>

        <p>
            Status: {{ $task->status }}
        </p>

        <p>
            Prioridade: {{ $task->priority }}
        </p>

        <p>
            Responsável:
            {{ $task->assignee?->name ?? 'Não atribuído' }}
        </p>

        <p>
            Prazo:
            {{ $task->due_at?->format('d/m/Y H:i') ?? 'Sem prazo' }}
        </p>

        @can('update', $task)
            <a
                href="{{ route('workspaces.projects.tasks.edit', [
                    'workspace' => $workspace,
                    'project' => $project,
                    'task' => $task,
                ]) }}">
                Editar
            </a>
        @endcan


        @can('delete', $task)
            <form method="POST"
                action="{{ route('workspaces.projects.tasks.destroy', [
                    'workspace' => $workspace,
                    'project' => $project,
                    'task' => $task,
                ]) }}">
                @csrf
                @method('DELETE')

                <button type="submit">
                    Excluir
                </button>
            </form>
        @endcan

    </article>

@empty

    <p>
        Nenhuma tarefa criada.
    </p>
@endforelse

{{ $tasks->links() }}
