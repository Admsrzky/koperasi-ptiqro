<?php

use App\Http\Controllers\KaryawanController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\PenggajianController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController; // Tambahkan controller untuk dashboard
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth', 'verified'])->group(function () {
    // Dashboard Route
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Profile Routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Karyawan Routes
    Route::resource('karyawan', KaryawanController::class);

    // Peminjaman Routes
    Route::resource('peminjaman', PeminjamanController::class);
    Route::patch('peminjaman/{peminjaman}/approve', [PeminjamanController::class, 'approve'])->name('peminjaman.approve');
    Route::patch('peminjaman/{peminjaman}/reject', [PeminjamanController::class, 'reject'])->name('peminjaman.reject');
    Route::patch('peminjaman/{peminjaman}/disburse', [PeminjamanController::class, 'disburse'])->name('peminjaman.disburse');
    Route::get('peminjaman/{peminjaman}/print', [PeminjamanController::class, 'printPengajuan'])->name('peminjaman.print');
    Route::get('report/peminjam', [PeminjamanController::class, 'reportPeminjam'])->name('report.peminjam');
    Route::get('/peminjaman/{peminjaman}/cetak', [PeminjamanController::class, 'cetakLaporan'])->name('peminjaman.cetak');


    // Penggajian Routes
    Route::resource('penggajian', PenggajianController::class);
    Route::get('penggajian/{penggajian}/slip', [PenggajianController::class, 'printSlip'])->name('penggajian.slip');

    // Chart Data Routes
    Route::get('/dashboard/revenue-data', [DashboardController::class, 'revenueData'])->name('dashboard.revenue-data');
    Route::get('/dashboard/member-growth-data', [DashboardController::class, 'memberGrowthData'])->name('dashboard.member-growth-data');
});

require __DIR__ . '/auth.php';