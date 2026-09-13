<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Workspace;
use Illuminate\View\View;

class ProjectController extends Controller
{
    /**
     * Exibe os projetos de um workspace.
     */
    public function index(Workspace $workspace): View
    {
        // Estamos consultando projetos através da relação.
        //
        // Isso garante que a consulta já esteja limitada
        // ao workspace recebido pela URL.
        $projects = $workspace
            ->projects()
            ->latest()
            ->paginate(15);

        return view('projects.index', [
            'workspace' => $workspace,
            'projects' => $projects,
        ]);
    }
}
