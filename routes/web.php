<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\LaporanPemasukanController;
use App\Http\Controllers\LaporanPengeluaranController;
use App\Http\Controllers\LaporanKeuanganController;
use App\Http\Controllers\PengeluaranController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\PembayaranController;
use App\Http\Controllers\WaliDashboardController;
use App\Http\Controllers\WaliTagihanController;
use App\Http\Controllers\WaliPembayaranController;
use App\Http\Controllers\SantriController;
use App\Http\Controllers\TagihanController;
use App\Http\Controllers\JenisTagihanController;
use App\Http\Controllers\TarifTagihanController;
use App\Http\Controllers\GenerateTagihanController;
use App\Http\Controllers\WaliController;
use App\Http\Controllers\TagihanKhususController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\PasswordController;
use App\Http\Controllers\KuitansiController;
use App\Http\Controllers\RekeningPondokController;


    Route::get('/', function () {
        return redirect()->route('login');
    });

    Route::get('/login', [AuthController::class, 'showLogin'])
        ->name('login');

    Route::post('/login', [AuthController::class, 'login'])
        ->name('login.process');

    Route::post('/logout', [AuthController::class, 'logout'])
        ->name('logout');



    Route::get('/akun', [AccountController::class, 'index'])
        ->name('akun.index');

    Route::get('/akun/password', [PasswordController::class, 'edit'])
        ->name('akun.password.edit');

    Route::post('/akun/password', [PasswordController::class, 'update'])
        ->name('akun.password.update');

    Route::get(
        '/kuitansi/{pembayaran}',
        [KuitansiController::class, 'show']
    )->name('kuitansi.show');

    Route::get(
        '/kuitansi-public/{pembayaran}',
        [KuitansiController::class, 'public']
    )
    ->middleware('signed')
    ->name('kuitansi.public');


Route::middleware(['auth', 'role:admin'])->group(function () {

    Route::get('/admin/dashboard', [AdminDashboardController::class, 'index'])
        ->name('admin.dashboard');

    Route::get('/admin/pembayaran', [PembayaranController::class, 'index'])
        ->name('admin.pembayaran.index');

    Route::get(
        '/admin/pembayaran/offline',
        [PembayaranController::class, 'createOffline']
    )->name('admin.pembayaran.offline.create');

    Route::post(
        '/admin/pembayaran/offline',
        [PembayaranController::class, 'storeOffline']
    )->name('admin.pembayaran.offline.store');

    Route::get('/admin/pembayaran/{id}', [PembayaranController::class, 'show'])
        ->name('admin.pembayaran.show');

    Route::post('/admin/pembayaran/{id}/terima', [PembayaranController::class, 'terima'])
        ->name('admin.pembayaran.terima');

    Route::post('/admin/pembayaran/{id}/tolak', [PembayaranController::class, 'tolak'])
        ->name('admin.pembayaran.tolak');

    Route::get(
        '/admin/tagihan/generate',
        [GenerateTagihanController::class, 'create']
    )->name('admin.tagihan.generate');

    Route::post(
        '/admin/tagihan/generate',
        [GenerateTagihanController::class, 'store']
    )->name('admin.tagihan.generate.store');

    Route::get(
        '/admin/tagihan',
        [TagihanController::class, 'index']
    )->name('admin.tagihan.index');

    Route::get(
        '/admin/tagihan/{id}',
        [TagihanController::class, 'show']
    )->name('admin.tagihan.show');

    Route::get(
        '/admin/jenis-tagihan',
        [JenisTagihanController::class, 'index']
    )->name('admin.jenis-tagihan.index');

    Route::get(
        '/admin/jenis-tagihan/create',
        [JenisTagihanController::class, 'create']
    )->name('admin.jenis-tagihan.create');

    Route::post(
        '/admin/jenis-tagihan',
        [JenisTagihanController::class, 'store']
    )->name('admin.jenis-tagihan.store');

    Route::get(
        '/admin/jenis-tagihan/{id}/edit',
        [JenisTagihanController::class, 'edit']
    )->name('admin.jenis-tagihan.edit');

    Route::put(
        '/admin/jenis-tagihan/{id}',
        [JenisTagihanController::class, 'update']
    )->name('admin.jenis-tagihan.update');

    Route::get(
        '/admin/tarif-tagihan',
        [TarifTagihanController::class, 'index']
    )->name('admin.tarif-tagihan.index');

    Route::get(
        '/admin/tarif-tagihan/create',
        [TarifTagihanController::class, 'create']
    )->name('admin.tarif-tagihan.create');

    Route::post(
        '/admin/tarif-tagihan',
        [TarifTagihanController::class, 'store']
    )->name('admin.tarif-tagihan.store');

    Route::get('/admin/wali', [WaliController::class, 'index'])
        ->name('admin.wali.index');

    Route::get('/admin/wali/create', [WaliController::class, 'create'])
        ->name('admin.wali.create');

    Route::post('/admin/wali', [WaliController::class, 'store'])
        ->name('admin.wali.store');

    Route::get('/admin/wali/{id}/edit', [WaliController::class, 'edit'])
        ->name('admin.wali.edit');

    Route::put('/admin/wali/{id}', [WaliController::class, 'update'])
        ->name('admin.wali.update');

    Route::patch('/admin/wali/{id}/toggle-status', [WaliController::class, 'toggleStatus'])
        ->name('admin.wali.toggle-status');

    Route::post('/admin/santri', [SantriController::class, 'store'])
        ->name('admin.santri.store');

    Route::get('/admin/santri/create', [SantriController::class, 'create'])
        ->name('admin.santri.create');

    Route::get('/admin/santri/{id}/edit', [SantriController::class, 'edit'])
        ->name('admin.santri.edit');

    Route::put('/admin/santri/{id}', [SantriController::class, 'update'])
        ->name('admin.santri.update');

    Route::get(
        '/admin/santri',
        [SantriController::class, 'index']
    )->name('admin.santri.index');
    
    Route::get('/admin/pengeluaran', [PengeluaranController::class, 'index'])
        ->name('admin.pengeluaran.index');

    Route::get('/admin/pengeluaran/create', [PengeluaranController::class, 'create'])
        ->name('admin.pengeluaran.create');

    Route::post('/admin/pengeluaran', [PengeluaranController::class, 'store'])
        ->name('admin.pengeluaran.store');

    Route::get('/laporan/pemasukan', [LaporanPemasukanController::class, 'index'])
    ->name('laporan.pemasukan');

    Route::get('/laporan/pengeluaran', [LaporanPengeluaranController::class, 'index'])
        ->name('laporan.pengeluaran');

    Route::get('/laporan/keuangan', [LaporanKeuanganController::class, 'index'])
        ->name('laporan.keuangan');

    Route::get(
        '/admin/tagihan-khusus/create',
        [TagihanKhususController::class, 'create']
    )->name('admin.tagihan-khusus.create');

    Route::post(
        '/admin/tagihan-khusus',
        [TagihanKhususController::class, 'store']
    )->name('admin.tagihan-khusus.store');

    Route::get('/admin/wali/{user}/reset-password', function (\App\Models\User $user) {
        if ($user->role !== 'wali') {
            abort(404);
        }

        return view('admin.wali.reset-password', compact('user'));
    })->name('admin.wali.reset-password');

    Route::post('/admin/wali/{user}/reset-password', [PasswordController::class, 'adminReset'])
        ->name('admin.wali.reset-password.update');

    Route::get(
        '/admin/rekening',
        [RekeningPondokController::class, 'index']
    )->name('admin.rekening.index');

    Route::get(
        '/admin/rekening/create',
        [RekeningPondokController::class, 'create']
    )->name('admin.rekening.create');

    Route::post(
        '/admin/rekening',
        [RekeningPondokController::class, 'store']
    )->name('admin.rekening.store');

    Route::get(
        '/admin/rekening/{id}/edit',
        [RekeningPondokController::class, 'edit']
    )->name('admin.rekening.edit');

    Route::put(
        '/admin/rekening/{id}',
        [RekeningPondokController::class, 'update']
    )->name('admin.rekening.update');

    Route::patch(
        '/admin/rekening/{id}/toggle',
        [RekeningPondokController::class, 'toggle']
    )->name('admin.rekening.toggle');

});

Route::middleware(['auth', 'role:wali'])->group(function () {

    Route::get('/wali/dashboard', [WaliDashboardController::class, 'index'])
        ->name('wali.dashboard');

    Route::get(
        '/wali/tagihan',
        [WaliTagihanController::class, 'index']
    )->name('wali.tagihan.index');

    Route::get('/wali/tagihan/{id}', [WaliTagihanController::class, 'show'])
        ->name('wali.tagihan.show');

    Route::get(
        '/wali/tagihan/{id}/bayar',
        [WaliPembayaranController::class, 'create']
    )->name('wali.pembayaran.create');

    Route::post(
        '/wali/tagihan/{id}/bayar',
        [WaliPembayaranController::class, 'store']
    )->name('wali.pembayaran.store');

    Route::get(
        '/wali/pembayaran/{id}',
        [WaliPembayaranController::class, 'show']
    )->name('wali.pembayaran.show');

    Route::get(
        '/wali/riwayat-pembayaran',
        [WaliPembayaranController::class, 'riwayat']
    )->name('wali.pembayaran.riwayat');

    Route::get(
        '/wali/pembayaran/{id}/konfirmasi',
        [PembayaranController::class, 'konfirmasi']
    )->name('wali.pembayaran.konfirmasi');

});





