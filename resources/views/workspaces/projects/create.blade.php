<h1>
    Novo projeto
</h1>

<p>
    Workspace: {{ $workspace->name }}
</p>

<a href="{{ route('workspaces.projects.index', $workspace) }}">
    Voltar
</a>

<hr>

<form
    method="POST"
    action="{{ route('workspaces.projects.store', $workspace) }}"
>
    @csrf

    <div>
        <label for="name">
            Nome
        </label>

        <input
            id="name"
            name="name"
            type="text"
            value="{{ old('name') }}"
            maxlength="120"
            required
            autofocus
        >

        @error('name')
            <div>
                {{ $message }}
            </div>
        @enderror
    </div>

    <button type="submit">
        Criar projeto
    </button>
</form>
