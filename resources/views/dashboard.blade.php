<h1> TaskFlow </h1>

<p> Olá, {{ auth()->user()->name }} </p>

<form
    method="POST"
    action="{{ route('logout') }}"
>
    @csrf

    <button type="submit">
        Sair
    </button>
</form>

<hr>

<h2>Seus Workspaces</h2>

@forelse ($workspaces as $workspace)

    <article>

        <h3>
            {{ $workspace->name }}
        </h3>

        @if ($workspace->isOwner(auth()->user()))
            <p>
                Você é o proprietário.
            </p>
        @endif

        <p>
            Projetos:
            {{ $workspace->projects_count }}
        </p>

        <p>
            Membros:
            {{ $workspace->users_count }}
        </p>

        <nav>
            <a
                href="{{ route(
                    'workspaces.projects.index',
                    $workspace
                ) }}"
            >
                Ver projetos
            </a>

            <a
                href="{{ route(
                    'workspaces.members.index',
                    $workspace
                ) }}"
            >
                Ver membros
            </a>
        </nav>

    </article>

    <hr>

@empty

    <p>
        Você ainda não participa de nenhum Workspace.
    </p>

@endforelse
