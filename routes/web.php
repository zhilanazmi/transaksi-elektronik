<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminProjectController;
use App\Http\Controllers\ContractController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\PosController;
use App\Http\Controllers\ProjectController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', DashboardController::class)->middleware(['auth', 'verified'])->name('dashboard');
Route::post('/midtrans/notification', [PaymentController::class, 'notification'])
    ->name('midtrans.notification');

Route::middleware('auth')->group(function () {
    Route::resource('projects', ProjectController::class);
    Route::get('/projects/{project}/payments/create', [PaymentController::class, 'create'])->name('payments.create');
    Route::post('/projects/{project}/payments', [PaymentController::class, 'store'])->name('payments.store');
    Route::patch('/payments/{payment}/paid', [PaymentController::class, 'markPaid'])->name('payments.paid');
    Route::get('/contracts/{contract}/download', [ContractController::class, 'download'])->name('contracts.download');
    Route::get('/admin/projects', [AdminProjectController::class, 'index'])->name('admin.projects.index');
    Route::patch('/admin/projects/{project}/approve', [AdminProjectController::class, 'approve'])->name('admin.projects.approve');
    Route::patch('/admin/projects/{project}/reject', [AdminProjectController::class, 'reject'])->name('admin.projects.reject');
    Route::get('/pos', [PosController::class, 'index'])->name('pos.index');
    Route::post('/pos', [PosController::class, 'store'])->name('pos.store');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
