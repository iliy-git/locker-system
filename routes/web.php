<?php

use Illuminate\Support\Facades\Route;

Route::get('/dashboard', \App\Livewire\UserDashboard::class)
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::get('/', function () {
    return view('welcome');
})->name('home');

//Route::get('/my-cells', function () {
//    return view('my-cells');
//})->middleware(['auth', 'verified'])->name('my-cells');
//
//Route::get('/history', function () {
//    return view('history');
//})->middleware(['auth', 'verified'])->name('booking-history');


require __DIR__.'/auth.php';
