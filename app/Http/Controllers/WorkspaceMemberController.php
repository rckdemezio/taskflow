<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Workspace;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class WorkspaceMemberController extends Controller
{
    /**
     * Lista os membros do workspace
     *
     * @param Workspace $workspace
     * @return View
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
     *
     * @param Workspace $workspace
     * @return RedirectResponse
     */
    public function store(Workspace $workspace): RedirectResponse
    {
        // Temporário.
        $user = User::findOrFail(5);

        $workspace->users()->attach($user->id, [
            'role' => 'member',
            'joined_at' => now(),
        ]);

        return redirect()->route('workspaces.members.index', $workspace);
    }

    /**
     * Altera o papel do usuário dentro do workspace
     *
     * @param Workspace $workspace
     * @param User $user
     * @return RedirectResponse
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
     *
     * @param Workspace $workspace
     * @param User $user
     * @return RedirectResponse
     */
    public function destroy(Workspace $workspace, User $user): RedirectResponse
    {
        $workspace->users()->detach($user->id);

        return redirect()->route('workspaces.members.index', $workspace);
    }
}
