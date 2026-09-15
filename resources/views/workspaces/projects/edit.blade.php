<h1>
    Editar projeto
</h1>

<p>
    Workspace: {{ $workspace->name }}
</p>

<a href="{{ route('workspaces.projects.index', $workspace) }}">
    Voltar
</a>

<hr>

<form method="POST"
    action="{{ route('workspaces.projects.update', [
        'workspace' => $workspace,
        'project' => $project,
    ]) }}">
    @csrf
    @method('PATCH')

    <div>
        <label for="name">
            Nome
        </label>

        <input id="name" name="name" type="text" value="{{ old('name', $project->name) }}" maxlength="120"
            required autofocus>

        @error('name')
            <div>
                {{ $message }}
            </div>
        @enderror
    </div>

    <button type="submit">
        Salvar alterações
    </button>
</form>
