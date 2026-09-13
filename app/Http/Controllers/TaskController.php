<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\View\View;

class TaskController extends Controller
{
    public function index(Project $project): View
    {
        $tasks = $project
            ->tasks()
            ->latest()
            ->paginate(15);

        return view('tasks.index', [
            'project' => $project,
            'tasks' => $tasks,
        ]);
    }
}
