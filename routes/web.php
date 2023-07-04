<?php

use App\Http\Controllers\BerandaController;
use App\Http\Controllers\GantiPasswordController;
use App\Http\Controllers\JenisPakaianController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\TransaksiController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

Auth::routes();
Route::get('/beranda', [BerandaController::class, 'index'])->name('beranda.index');

Route::middleware(['auth', 'user-access:Administrator'])->group(function () {

    // Pelanggan
    Route::get('/pelanggan', [PelangganController::class, 'index'])->name('pelanggan.index');
    Route::get('/pelanggan/{pelanggan}/edit', [PelangganController::class, 'edit'])->name('pelanggan.edit');
    Route::post('/pelanggan/store', [PelangganController::class, 'store'])->name('pelanggan.store');
    Route::delete('/pelanggan/{pelanggan}', [PelangganController::class, 'destroy'])->name('pelanggan.destroy');

    // Jenis Pakaian
    Route::get('/jenis-pakaian', [JenisPakaianController::class, 'index'])->name('jenisPakaian.index');
    Route::get('/jenis-pakaian/{jenisPakaian}/edit', [JenisPakaianController::class, 'edit'])->name('jenisPakaian.edit');
    Route::post('/jenis-pakaian/store', [JenisPakaianController::class, 'store'])->name('jenisPakaian.store');
    Route::delete('/jenis-pakaian/{jenisPakaian}', [JenisPakaianController::class, 'destroy'])->name('jenisPakaian.destroy');

    // Ganti Password
    Route::get('/ganti-password', [GantiPasswordController::class, 'index'])->name('ganti-password.index');
    Route::post('/ganti-password', [GantiPasswordController::class, 'update'])->name('ganti-password.update');

    // Transaksi
    Route::get('/transaksi', [TransaksiController::class, 'index'])->name('transaksi.index');
    Route::get('/transaksi/tambah', [TransaksiController::class, 'create'])->name('transaksi.create');
    Route::post('/transaksi', [TransaksiController::class, 'store'])->name('transaksi.store');
    Route::get('/transaksi/get-harga', [TransaksiController::class, 'getHarga'])->name('transaksi.get-harga');
    Route::delete('/transaksi/{transaksi}', [TransaksiController::class, 'destroy'])->name('transaksi.destroy');
    Route::post('/transaksi/{transaksi}', [TransaksiController::class, 'update'])->name('transaksi.update');
    Route::get('/transaksi/{id}/print', [TransaksiController::class, 'print'])->name('transaksi.print');

    // Ganti Password
    Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
});
