<?php

use App\Http\Controllers\CustomerController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('customers/trash', [CustomerController::class, 'trash'])->name('customers.trash');
Route::patch('customers/restore/{customer}', [CustomerController::class, 'restore'])
    ->name('customers.restore')
    ->withTrashed();
Route::delete('customers/force-delete/{customer}', [CustomerController::class, 'forceDelete'])
    ->name('customers.force-delete')
    ->withTrashed();

Route::resource('customers', CustomerController::class);
