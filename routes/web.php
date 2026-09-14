<?php

use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\WorkspaceMemberController;
use Illuminate\Support\Facades\Route;

// Rota default do Laravel, que retorna a view "welcome" quando o usuário acessa a raiz do site.
Route::get('/', function () {
    return view('welcome');
});

// Projects

Route::get(
    '/workspaces/{workspace}/projects',
    [ProjectController::class, 'index']
)->name('workspaces.projects.index');

Route::get(
    '/projects/{project}/tasks',
    [TaskController::class, 'index']
)->name('projects.tasks.index');

// Fim Projects

// Workspace Members
Route::prefix('workspaces/{workspace}/members')
    ->name('workspaces.members.')
    ->scopeBindings()
    ->group( function() {
        Route::get('/', [WorkspaceMemberController::class, 'index'])
            ->name('index');

        Route::post('/', [WorkspaceMemberController::class, 'store'])
            ->name('store');

        Route::patch('/{user}', [WorkspaceMemberController::class, 'update'])
            ->name('update');

        Route::delete('/{user}', [WorkspaceMemberController::class, 'destroy'])
            ->name('destroy');
    });

// Fim Workspace Members
