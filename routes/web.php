<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PetController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


Route::get('/', DashboardController::class)->name('dashboard');

Route::prefix('/pets')->name('pets.')->group(function () {
   Route::get('/', [PetController::class, 'index'])->name('index');
   Route::get('/create', [PetController::class, 'create'])->name('create');
   Route::post('/store', [PetController::class, 'store'])->name('store');
   Route::get('/{id}/edit', [PetController::class, 'edit'])->name('edit');
   Route::put('/{id}', [PetController::class, 'update'])->name('update');
   Route::delete('/{id}', [PetController::class, 'destroy'])->name('destroy');
});
