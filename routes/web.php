<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminProjectController;
use App\Http\Controllers\ContractController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\PosController;
use App\Http\Controllers\ProjectController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\MitraApplicationController;
use App\Http\Controllers\Admin\MitraApplicationController as AdminMitraController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', DashboardController::class)->middleware(['auth', 'verified'])->name('dashboard');
Route::post('/midtrans/notification', [PaymentController::class, 'notification'])
    ->name('midtrans.notification');

Route::middleware('auth')->group(function () {
    // Mitra Routes
    Route::middleware('can:is-mitra')->group(function () {
        Route::get('/mitra/applications', [MitraApplicationController::class, 'index'])->name('mitra.applications.index');
        Route::get('/mitra/applications/create', [MitraApplicationController::class, 'create'])->name('mitra.applications.create');
        Route::post('/mitra/applications', [MitraApplicationController::class, 'store'])->name('mitra.applications.store');
        Route::get('/mitra/applications/{application}', [MitraApplicationController::class, 'show'])->name('mitra.applications.show');
    });

    // Admin Mitra Routes
    Route::middleware('can:is-admin')->group(function () {
        Route::get('/admin/mitra', [AdminMitraController::class, 'index'])->name('admin.mitra.index');
        Route::get('/admin/mitra/partners', [AdminMitraController::class, 'partners'])->name('admin.mitra.partners');
        Route::get('/admin/mitra/{application}', [AdminMitraController::class, 'show'])->name('admin.mitra.show');
        Route::patch('/admin/mitra/{application}/approve', [AdminMitraController::class, 'approve'])->name('admin.mitra.approve');
        Route::patch('/admin/mitra/{application}/reject', [AdminMitraController::class, 'reject'])->name('admin.mitra.reject');
    });

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
