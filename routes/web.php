<?php

use App\Http\Controllers\CriteriaController;
use App\Http\Controllers\EmployeeController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/criteria/sync', [CriteriaController::class, 'sync'])->name('criteria.sync');
    Route::resource('criteria', CriteriaController::class);
    Route::resource('employee', EmployeeController::class);
    // Route::get('/employee', [CriteriaController::class, 'index'])->name('employee');
    Route::get('/data', [CriteriaController::class, 'index'])->name('all_data');
});
