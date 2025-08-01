<?php

use Illuminate\Support\Facades\Route;

Auth::routes();

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/kanban', [App\Http\Controllers\HomeController::class, 'kanban'])->name('kanban');

Route::group(['middleware' => 'auth'], function () {
    Route::resource('task', App\Http\Controllers\TaskController::class)->except(['edit', 'create']);
    Route::put('task/{task}/update-status', [App\Http\Controllers\TaskController::class, 'updateStatus']);
    //Route::get()
});
