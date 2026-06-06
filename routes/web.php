<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Livewire\ManageCategories;
use App\Livewire\TransactionReports;
use Illuminate\Support\Facades\Route;
use App\Livewire\ManageBudgets;
use App\Livewire\ManageUsers; // Hubungkan class ke routing

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/manage-budgets', ManageBudgets::class)->name('manage-budgets');
    
    // Tambahkan baris baru ini
    Route::get('/manage-users', ManageUsers::class)->name('manage-users');
});

Route::redirect('/', '/login', 301);

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Tambahkan Route Baru Ini
    Route::get('/manage-budgets', ManageBudgets::class)->name('manage-budgets');
    Route::get('/manage-categories', ManageCategories::class)->name('manage-categories');
    Route::get('/transaction-reports', TransactionReports::class)->name('transaction-reports');
});

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');
Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
            ->name('logout'); // <-- Pastikan ada ->name('logout') ini

require __DIR__.'/auth.php';
