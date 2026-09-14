<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\StoreWorkspaceMemberRequest;
use App\Models\User;
use App\Models\Workspace;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class WorkspaceMemberController extends Controller
{
    /**
     * Lista os membros do workspace
     */
    public function index(Workspace $workspace): View
    {
        $members = $workspace->users()->get();

        return view('workspaces.members.index', [
            'workspace' => $workspace,
            'members' => $members,
        ]);
    }

    /**
     * Adiciona um usuário no workspace
     */
    public function store(
        StoreWorkspaceMemberRequest $request,
        Workspace $workspace
    ): RedirectResponse {
        // Somente dados que passaram pelas regras
        // do StoreWorkspaceMemberRequest.
        $data = $request->validated();

        // O email já foi validado como existente,
        // agora recuperamos o respectivo User.
        $user = User::query()
            ->where('email', $data['email'])
            ->firstOrFail();

        // Verifica no banco se o usuário já está
        // relacionado a este workspace.
        $alreadyMember = $workspace
            ->users()
            ->whereKey($user->id)
            ->exists();
        if ($alreadyMember) {
            return back()
                ->withErrors([
                    'email' => 'Este usuário já pertence ao workspace.',
                ])
                ->withInput();
        }

        // Cria apenas a associação.
        // Não cria outro User nem outro Workspace.
        $workspace->users()->attach(
            $user->id,
            [
                'role' => $data['role'],
                'joined_at' => now(),
            ]
        );

        return redirect()
            ->route('workspaces.members.index', $workspace);
    }

    /**
     * Altera o papel do usuário dentro do workspace
     */
    public function update(Workspace $workspace, User $user): RedirectResponse
    {
        $workspace->users()->updateExistingPivot($user->id, [
            'role' => 'admin',
        ]);

        return redirect()->route('workspaces.members.index', $workspace);
    }

    /**
     * Remove o usuário do workspace
     */
    public function destroy(Workspace $workspace, User $user): RedirectResponse
    {
        $member = $workspace
            ->users()
            ->whereKey($user->id)
            ->firstOrFail();
        if ($member->pivot->role === 'admin') {
            $adminCount = $workspace
                ->users()
                ->wherePivot('role', 'admin')
                ->count();
            if ($adminCount <= 1) {
                return back()
                    ->withErrors([
                        'member' => 'O workspace precisa possuir pelo menos um administrador.',
                    ]);
            }
        }

        $workspace->users()->detach($user->id);

        return redirect()->route('workspaces.members.index', $workspace);
    }
}
