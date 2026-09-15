<h1>Criar Workspace</h1>

<a href="{{ route('dashboard') }}">
    Voltar
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

<form method="POST" action="{{ route('workspaces.store') }}">
    @csrf

    <div>
        <label for="name">
            Nome
        </label>

        <input id="name" name="name" type="text" value="{{ old('name') }}" maxlength="100" required autofocus>

        @error('name')
            <div>
                {{ $message }}
            </div>
        @enderror
    </div>

    <button type="submit">
        Criar Workspace
    </button>
</form>
