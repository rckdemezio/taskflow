<?php

namespace App\Http\Controllers;

use App\Models\Workspace;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(Request $request): View
    {
        $user = $request->user();

        $workspaces = Workspace::query()
            ->accessibleTo($user)
            ->withCount([
                'projects',
                'users'
            ])
            ->latest()
            ->get();
        return view('dashboard', [
            'workspaces' => $workspaces,
        ]);
    }
}
