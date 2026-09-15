<h1>Nova tarefa</h1>

<p>
    Projeto: {{ $project->name }}
</p>

<form
    method="POST"
    action="{{ route('workspaces.projects.tasks.store', [
        'workspace' => $workspace,
        'project' => $project,
    ]) }}"
>
    @csrf

    <div>
        <label for="title">Título</label>

        <input
            id="title"
            name="title"
            type="text"
            value="{{ old('title') }}"
            required
        >

        @error('title')
            <div>{{ $message }}</div>
        @enderror
    </div>


    <div>
        <label for="description">
            Descrição
        </label>

        <textarea
            id="description"
            name="description"
        >{{ old('description') }}</textarea>
    </div>


    <div>
        <label for="status">
            Status
        </label>

        <select id="status" name="status">

            <option
                value="todo"
                @selected(old('status', 'todo') === 'todo')
            >
                A fazer
            </option>

            <option
                value="in_progress"
                @selected(old('status') === 'in_progress')
            >
                Em andamento
            </option>

            <option
                value="done"
                @selected(old('status') === 'done')
            >
                Concluída
            </option>

        </select>
    </div>


    <div>
        <label for="priority">
            Prioridade
        </label>

        <select id="priority" name="priority">

            @foreach (['low', 'medium', 'high'] as $priority)

                <option
                    value="{{ $priority }}"
                    @selected(
                        old('priority', 'medium') === $priority
                    )
                >
                    {{ $priority }}
                </option>

            @endforeach

        </select>
    </div>


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
                        (string) old('assigned_to')
                        === (string) $assignee->id
                    )
                >
                    {{ $assignee->name }}
                    — {{ $assignee->email }}
                </option>

            @endforeach

        </select>

        @error('assigned_to')
            <div>{{ $message }}</div>
        @enderror
    </div>


    <div>
        <label for="due_at">
            Prazo
        </label>

        <input
            id="due_at"
            name="due_at"
            type="datetime-local"
            value="{{ old('due_at') }}"
        >
    </div>


    <button type="submit">
        Criar tarefa
    </button>
</form>
