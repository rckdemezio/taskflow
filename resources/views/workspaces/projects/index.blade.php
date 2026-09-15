<h1>
    Projetos de {{ $workspace->name }}
</h1>

<a href="{{ route('dashboard') }}">
    Dashboard
</a>

@can('manageProjects', $workspace)
    <a href="{{ route('workspaces.projects.create', $workspace) }}">
        Novo projeto
    </a>
@endcan


@if (session('success'))
    <div>
        {{ session('success') }}
    </div>
@endif


<hr>


@forelse ($projects as $project)
    <article>

        <h2>
            {{ $project->name }}
        </h2>

        <p>
            {{ $project->tasks_count }}
            tarefa(s)
        </p>

        <a
            href="{{ route('workspaces.projects.tasks.index', [
                'workspace' => $workspace,
                'project' => $project,
            ]) }}">
            Ver tarefas
        </a>


        @can('manageProjects', $workspace)
            <a
                href="{{ route('workspaces.projects.edit', [
                    'workspace' => $workspace,
                    'project' => $project,
                ]) }}">
                Editar
            </a>


            <form method="POST"
                action="{{ route('workspaces.projects.destroy', [
                    'workspace' => $workspace,
                    'project' => $project,
                ]) }}">
                @csrf
                @method('DELETE')

                <button type="submit">
                    Excluir
                </button>
            </form>
        @endcan

    </article>

    <hr>

@empty

    <p>
        Nenhum projeto criado ainda.
    </p>
@endforelse


{{ $projects->links() }}
