<style>
    .success {
        border: 2px solid #07d300;
        width: fit-content;
        /* Faz a div encolher para o tamanho do texto */
        padding: 12px 24px;
        border-radius: 8px;
        display: block;
    }

    .error {
        border: 2px solid #fb1717;
        width: fit-content;
        /* Faz a div encolher para o tamanho do texto */
        padding: 12px 24px;
        border-radius: 8px;
        display: block;
    }
</style>
@auth
    <p>
        Olá, {{ auth()->user()->name }}
    </p>

    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit">
            Sair
        </button>
    </form>
@endauth
<h1>
    Workspace {{ $workspace->name }}
</h1>

@if (session('success'))
    <div>
        <span class="success">{{ session('success') }}</span>
    </div>
@endif
@error('member')
    <div>
        <span class="error">{{ $message }}</span>
    </div>
@enderror

<hr />
@can('manageMembers', $workspace)
    <h2>Adicionar novo membro ao {{ $workspace->name }} </h2>
    <div class="form">
        <form method="POST" action={{ route('workspaces.members.store', $workspace) }}>
            @csrf

            <div>
                <label for="email">E-mail</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}">
                @error('email')
                    <div>{{ $message }} </div>
                @enderror
            </div>

            <div>
                <label for="role">Papel</label>
                <select id="role" name="role">
                    <option value="member" @selected(old('role', 'member') === 'member')>
                        Member
                    </option>

                    <option value="admin" @selected(old('role') === 'admin')>
                        Admin
                    </option>
                </select>
                @error('role')
                    <div>{{ $message }} </div>
                @enderror
            </div>

            <button type="submit">Adicionar membro</button>
        </form>
    </div>

    <hr />
@endcan

<h2>Membros</h2>

<table border="1">
    <th>Nome</th>
    <th>E-mail</th>
    <th>Perfil</th>
    <th>Ações</th>
    <tbody>

        @foreach ($members as $member)
            <tr>
                <td>
                    {{ $member->name }}
                </td>

                <td>
                    {{ $member->email }}
                </td>

                <td>
                    {{ $member->pivot->role }}
                </td>

                <td>

                    @can('manageMembers', $workspace)
                        {{-- Alterar role --}}
                        <form method="POST"
                            action="{{ route('workspaces.members.update', [
                                'workspace' => $workspace,
                                'user' => $member,
                            ]) }}">
                            @csrf
                            @method('PATCH')

                            <select name="role">

                                <option value="member" @selected($member->pivot->role === 'member')>
                                    Member
                                </option>

                                <option value="admin" @selected($member->pivot->role === 'admin')>
                                    Admin
                                </option>

                            </select>

                            <button type="submit">
                                Salvar
                            </button>

                        </form>

                        {{-- Remover membership --}}
                        <form method="POST"
                            action="{{ route('workspaces.members.destroy', [
                                'workspace' => $workspace,
                                'user' => $member,
                            ]) }}">
                            @csrf
                            @method('DELETE')

                            <button type="submit">
                                Remover
                            </button>

                        </form>
                    @endcan

                </td>
            </tr>
        @endforeach

    </tbody>
</table>
