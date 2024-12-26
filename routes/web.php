<?php

use App\Http\Controllers\CriteriaController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\WPController;
use App\Models\Criteria;
use App\Models\Employee;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('dashboard');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        $employee = Employee::count();
        $criteria = Criteria::count();
        return view('dashboard', compact('employee', 'criteria'));
    })->name('dashboard');

    Route::get('/criteria/sync', [CriteriaController::class, 'sync'])->name('criteria.sync');
    Route::resource('criteria', CriteriaController::class);
    Route::resource('employee', EmployeeController::class);
    Route::get('/wp', [WPController::class, 'index'])->name('wp.index');
    Route::get('/wp/print', [WPController::class, 'print'])->name('wp.print');
});
