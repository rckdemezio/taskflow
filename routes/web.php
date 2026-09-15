<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\WorkspaceController;
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

Route::middleware('auth')->group(function () {

    /**
     * Dashboard Routers
     */
    Route::get(
        '/dashboard',
        [DashboardController::class, 'index']
    )->name('dashboard');

    /**
     * Workspace Routers
     */
    Route::get(
        '/workspaces/create',
        [WorkspaceController::class, 'create']
    )->name('workspaces.create');


    Route::post(
        '/workspaces',
        [WorkspaceController::class, 'store']
    )->name('workspaces.store');

    /**
     * Projects Routers
     */
    Route::get(
        '/workspaces/{workspace}/projects',
        [ProjectController::class, 'index']
    )
        ->can('view', 'workspace')
        ->name('workspaces.projects.index');
    /** Fim Projects Routes */

    /**
     * Tasks Routers
     */
    Route::get(
        '/projects/{project}/tasks',
        [TaskController::class, 'index']
    )
        ->can('view', 'project')
        ->name('projects.tasks.index');

    /** Fim Tasks Routers */

    /**
     * Workspace Projects Routers
     */
    Route::prefix('workspaces/{workspace}/projects')
    ->name('workspaces.projects.')
    ->scopeBindings()
    ->group(function () {

        Route::get(
            '/',
            [ProjectController::class, 'index']
        )
            ->can('view', 'workspace')
            ->name('index');


        Route::get(
            '/create',
            [ProjectController::class, 'create']
        )
            ->can('manageProjects', 'workspace')
            ->name('create');


        Route::post(
            '/',
            [ProjectController::class, 'store']
        )
            ->can('manageProjects', 'workspace')
            ->name('store');


        Route::get(
            '/{project}/edit',
            [ProjectController::class, 'edit']
        )
            ->can('update', 'project')
            ->name('edit');


        Route::patch(
            '/{project}',
            [ProjectController::class, 'update']
        )
            ->can('update', 'project')
            ->name('update');


        Route::delete(
            '/{project}',
            [ProjectController::class, 'destroy']
        )
            ->can('delete', 'project')
            ->name('destroy');
    });
    /** Fim Workspace Projects Routers */

    /*
     * Workspace Members
     */
    Route::prefix('workspaces/{workspace}/members')
        ->name('workspaces.members.')
        ->scopeBindings()
        ->group(function () {

            Route::get(
                '/',
                [WorkspaceMemberController::class, 'index']
            )
                ->can('view', 'workspace')
                ->name('index');

            Route::post(
                '/',
                [WorkspaceMemberController::class, 'store']
            )
                ->can('manageMembers', 'workspace')
                ->name('store');

            Route::patch(
                '/{user}',
                [WorkspaceMemberController::class, 'update']
            )
                ->can('manageMembers', 'workspace')
                ->name('update');

            Route::delete(
                '/{user}',
                [WorkspaceMemberController::class, 'destroy']
            )
                ->can('manageMembers', 'workspace')
                ->name('destroy');
        });
    /** Fim Workspace Members Routers */
});
