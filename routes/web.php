<?php

use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');


    Route::get('customers/trash', [CustomerController::class, 'trash'])->name('customers.trash');
    Route::patch('customers/restore/{customer}', [CustomerController::class, 'restore'])
        ->name('customers.restore')
        ->withTrashed();
    Route::delete('customers/force-delete/{customer}', [CustomerController::class, 'forceDelete'])
        ->name('customers.force-delete')
        ->withTrashed();

    Route::resource('customers', CustomerController::class);
});



require __DIR__ . '/auth.php';
