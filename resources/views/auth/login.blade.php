<h1>Entrar no TaskFlow</h1>

@if ($errors->any())
    <div>
        <ul>
            @foreach ($errors->all() as $error)
                <li> {{ $error }} </li>
            @endforeach
        </ul>
    </div>
@endif

<form
    method="POST"
    action="{{ route('login.store') }}"
>

    @csrf
    <div>
        <label for="email">
            E-mail
        </label>
        <input
            id="email"
            name="email"
            type="email"
            value="{{ old('email') }}"
            required
            autofocus
        >
    </div>

    <div>
        <label for="password">
            Senha
        </label>
        <input
            id="password"
            name="password"
            type="password"
            required
        >
    </div>

    <div>
        <label>
            <input
                type="checkbox"
                name="remember"
            >
            Manter-me conectado.
        </label>
    </div>

    <button type="submit">
        Entrar
    </button>
</form>
