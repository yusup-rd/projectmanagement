<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\Auth\LoginController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('dashboard');
});

Auth::routes();

Route::middleware(['auth', 'can:view-manager-pages'])->group(function () {
    Route::get('/projects/create', [ProjectController::class, 'create'])->name('projects.create');
    Route::post('/projects', [ProjectController::class, 'store'])->name('projects.store');
    Route::get('/projects/{id}/edit', [ProjectController::class, 'edit'])->name('projects.edit');
    Route::put('/projects/{id}', [ProjectController::class, 'update'])->name('projects.update');
    Route::delete('/projects/{id}', [ProjectController::class, 'destroy'])->name('projects.destroy');
});

Route::middleware(['auth', 'can:view-developer-pages'])->group(function () {
    Route::get('/projects/{id}/update-progress', [ProjectController::class, 'showUpdateProgressForm'])->name('projects.update-progress-form');
    Route::put('/projects/{id}/update-progress', [ProjectController::class, 'updateProgress'])->name('projects.update-progress');
});

Route::get('/dashboard', [ProjectController::class, 'index'])->name('dashboard')->middleware('auth');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');