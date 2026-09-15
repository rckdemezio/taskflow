<h1>Editar tarefa</h1>

<p>
    Workspace: {{ $workspace->name }}
</p>

<p>
    Projeto: {{ $project->name }}
</p>

<a
    href="{{ route('workspaces.projects.tasks.index', [
        'workspace' => $workspace,
        'project' => $project,
    ]) }}"
>
    Voltar para tarefas
</a>

<hr>

@if ($errors->any())
    <div>
        <ul>
            @foreach ($errors->all() as $error)
                <li>
                    {{ $error }}
                </li>
            @endforeach
        </ul>
    </div>
@endif

<form
    method="POST"
    action="{{ route('workspaces.projects.tasks.update', [
        'workspace' => $workspace,
        'project' => $project,
        'task' => $task,
    ]) }}"
>
    @csrf
    @method('PATCH')

    <div>
        <label for="title">
            Título
        </label>

        <input
            id="title"
            name="title"
            type="text"
            value="{{ old('title', $task->title) }}"
            maxlength="160"
            required
            autofocus
        >

        @error('title')
            <div>
                {{ $message }}
            </div>
        @enderror
    </div>

    <br>

    <div>
        <label for="description">
            Descrição
        </label>

        <textarea
            id="description"
            name="description"
            rows="5"
        >{{ old('description', $task->description) }}</textarea>

        @error('description')
            <div>
                {{ $message }}
            </div>
        @enderror
    </div>

    <br>

    <div>
        <label for="status">
            Status
        </label>

        <select
            id="status"
            name="status"
            required
        >
            <option
                value="todo"
                @selected(
                    old('status', $task->status) === 'todo'
                )
            >
                A fazer
            </option>

            <option
                value="in_progress"
                @selected(
                    old('status', $task->status) === 'in_progress'
                )
            >
                Em andamento
            </option>

            <option
                value="done"
                @selected(
                    old('status', $task->status) === 'done'
                )
            >
                Concluída
            </option>
        </select>

        @error('status')
            <div>
                {{ $message }}
            </div>
        @enderror
    </div>

    <br>

    <div>
        <label for="priority">
            Prioridade
        </label>

        <select
            id="priority"
            name="priority"
            required
        >
            <option
                value="low"
                @selected(
                    old('priority', $task->priority) === 'low'
                )
            >
                Baixa
            </option>

            <option
                value="medium"
                @selected(
                    old('priority', $task->priority) === 'medium'
                )
            >
                Média
            </option>

            <option
                value="high"
                @selected(
                    old('priority', $task->priority) === 'high'
                )
            >
                Alta
            </option>
        </select>

        @error('priority')
            <div>
                {{ $message }}
            </div>
        @enderror
    </div>

    <br>

    <div>
        <label for="assigned_to">
            Responsável
        </label>

        <select
            id="assigned_to"
            name="assigned_to"
        >
            <option value="">
                Sem responsável
            </option>

            @foreach ($assignees as $assignee)
                <option
                    value="{{ $assignee->id }}"
                    @selected(
                        (string) old(
                            'assigned_to',
                            $task->assigned_to
                        ) === (string) $assignee->id
                    )
                >
                    {{ $assignee->name }}
                    — {{ $assignee->email }}
                </option>
            @endforeach
        </select>

        @error('assigned_to')
            <div>
                {{ $message }}
            </div>
        @enderror
    </div>

    <br>

    <div>
        <label for="due_at">
            Prazo
        </label>

        <input
            id="due_at"
            name="due_at"
            type="datetime-local"
            value="{{ old(
                'due_at',
                $task->due_at?->format('Y-m-d\TH:i')
            ) }}"
        >

        @error('due_at')
            <div>
                {{ $message }}
            </div>
        @enderror
    </div>

    <br>

    <button type="submit">
        Salvar alterações
    </button>
</form>
