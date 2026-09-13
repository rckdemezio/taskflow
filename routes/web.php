<?php

use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get(
    '/workspaces/{workspace}/projects',
    [ProjectController::class, 'index']
)->name('workspaces.projects.index');

Route::get(
    '/projects/{project}/tasks',
    [TaskController::class, 'index']
)->name('projects.tasks.index');
