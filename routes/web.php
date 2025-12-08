<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\TamuController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\MemberDashboardController;
use App\Http\Controllers\Admin\AuthController as AdminAuthController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\TamuController as AdminTamuController;



// ============================================
// =========== HALAMAN PUBLIK =================
// ============================================
Route::get('/', [TamuController::class, 'create'])->name('home');
Route::get('/tambah', [TamuController::class, 'create'])->name('tamus.create');
Route::post('/tamus', [TamuController::class, 'store'])->name('tamus.store');

// ============================================
// =========== REGISTER MEMBER =================
// ============================================
Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');
Route::post('/register', [RegisteredUserController::class, 'store'])->name('register.store');

// ============================================
// =========== LOGIN MEMBER ====================
// ============================================
Route::get('/loginuser', [AuthenticatedSessionController::class, 'create'])->name('loginuser');
Route::post('/loginuser', [AuthenticatedSessionController::class, 'store'])->name('loginuser.store');

// ============================================
// =========== DASHBOARD & LOGOUT MEMBER =======
// ============================================
Route::middleware(['auth'])->group(function () {
    Route::get('/member/dashboard', [MemberDashboardController::class, 'index'])
        ->name('member.dashboard');

    Route::post('/member/dashboard/tamu', [MemberDashboardController::class, 'storeTamu'])
        ->name('member.dashboard.tamu');

    // Logout member
    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
});

// ============================================
// =========== LOGIN & DASHBOARD ADMIN =========
// ============================================
Route::prefix('admin')->group(function () {


    // Login admin
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login.admin');
    Route::post('/login', [AuthController::class, 'login'])->name('login.admin.process');

    // Logout admin
    Route::post('/logout', [AuthController::class, 'logout'])->name('admin.logout');


    // Middleware admin
    // Route ADMIN
    Route::middleware(['auth:admin'])->group(function () {
        // Dashboard admin
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');

        Route::get('/tampil', [AdminTamuController::class, 'index'])->name('tamus.index');
        Route::get('/tamus/export-excel', [AdminTamuController::class, 'exportExcel'])->name('tamus.exportExcel');
        Route::get('/tamus/export-pdf', [AdminTamuController::class, 'exportPDF'])->name('tamus.exportPDF');
        Route::get('/tamus/statistik', [AdminTamuController::class, 'statistik'])->name('tamus.statistik');
        Route::get('/tamus/export/statistik', [AdminTamuController::class, 'exportStatistik'])->name('tamus.exportStatistik');
        // Named route for PDF export used by views
        Route::get('/tamus/export/statistik/pdf', [AdminTamuController::class, 'exportStatistik'])->name('admin.export-statistik-pdf');
        Route::delete('/tamus/{id}', [AdminTamuController::class, 'destroy'])->name('tamus.destroy');
        Route::get('/tamus/edit/{id}', [AdminTamuController::class, 'edit'])->name('tamus.edit');
        Route::post('/tamus/update/{id}', [AdminTamuController::class, 'update'])->name('tamus.update');
    });

});
