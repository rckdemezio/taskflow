<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\WorkspaceMemberController;
use Illuminate\Support\Facades\Route;

// Rota default do Laravel, que retorna a view "welcome" quando o usuário acessa a raiz do site.
Route::get('/', function () {
    return view('welcome');
});

// Autenticação
Route::middleware('guest')->group(function () {
    Route::get(
        '/login',
        [AuthenticatedSessionController::class, 'create']
    )->name('login');

    Route::post(
        '/login',
        [AuthenticatedSessionController::class, 'store']
    )->name('login.store');
});

// Logout
Route::post(
    '/logout',
    [AuthenticatedSessionController::class, 'destroy']
)
    ->middleware('auth')
    ->name('logout');

// Projects

Route::middleware('auth')->group(function () {
    Route::get(
        '/workspaces/{workspace}/projects',
        [ProjectController::class, 'index']
    )->name('workspaces.projects.index');

    Route::get(
        '/projects/{project}/tasks',
        [TaskController::class, 'index']
    )->name('projects.tasks.index');
});

// Fim Projects

// Workspace Members
Route::middleware('auth')->prefix('workspaces/{workspace}/members')
    ->name('workspaces.members.')
    ->scopeBindings()
    ->group(function () {
        /**
         * Qualquer participante do Workspace pode visualizar a lista
         */
        Route::get('/', [WorkspaceMemberController::class, 'index'])
            ->can('view', 'workspace')
            ->name('index');

        /**
         * Somente owner/admin
         */
        Route::post('/', [WorkspaceMemberController::class, 'store'])
            ->can('manageMembers', 'workspace')
            ->name('store');

        Route::patch('/{user}', [WorkspaceMemberController::class, 'update'])
            ->can('manageMembers', 'workspace')
            ->name('update');

        Route::delete('/{user}', [WorkspaceMemberController::class, 'destroy'])
            ->can('manageMembers', 'workspace')
            ->name('destroy');
    });

// Fim Workspace Members
