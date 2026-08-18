<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\BeritaController as AdminBeritaController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\DonasiController as AdminDonasiController;
use App\Http\Controllers\Admin\JenisDonasiController;
use App\Http\Controllers\Admin\KurbanController as AdminKurbanController;
use App\Http\Controllers\Admin\LaporanDonasiController as AdminLaporanDonasiController;
use App\Http\Controllers\Admin\PaketKurbanController;
use App\Http\Controllers\Admin\ProfilMasjidController;
use App\Http\Controllers\Admin\SlotSapiController;
use App\Http\Controllers\Public\BeritaController;
use App\Http\Controllers\Public\CekStatusController;
use App\Http\Controllers\Public\DonasiController;
use App\Http\Controllers\Public\HomeController;
use App\Http\Controllers\Public\KontakController;
use App\Http\Controllers\Public\KurbanController;
use App\Http\Controllers\Public\LaporanDonasiController;
use App\Http\Controllers\Public\ProfilController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\LaporanKeuanganController;
use App\Http\Controllers\Admin\PengeluaranController;

Route::get('/debug/clear-donasi-session', function () {
    session()->forget('donasi_pending');
    return 'donasi_pending sudah dihapus. Kembali ke tab upload dan langsung submit (jangan refresh).';
});
/*
|--------------------------------------------------------------------------
| ROUTE PENGUNJUNG (PUBLIC)
|--------------------------------------------------------------------------
*/
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/profil-masjid', [ProfilController::class, 'index'])->name('profil.index');

Route::get('/berita', [BeritaController::class, 'index'])->name('berita.index');
Route::get('/berita/{slug}', [BeritaController::class, 'show'])->name('berita.show');

Route::prefix('donasi')->name('donasi.')->group(function () {
    Route::get('/', [DonasiController::class, 'index'])->name('index');
    Route::post('/', [DonasiController::class, 'store'])->name('store');
    Route::get('/pembayaran', [DonasiController::class, 'payment'])->name('payment');
    Route::post('/upload', [DonasiController::class, 'upload'])->name('upload');
    Route::get('/sukses/{kode}', [DonasiController::class, 'success'])->name('success');
});

Route::prefix('kurban')->name('kurban.')->group(function () {
    Route::get('/', [KurbanController::class, 'index'])->name('index');
    Route::get('/slot/{paket}', [KurbanController::class, 'slot'])->name('slot');
    Route::post('/', [KurbanController::class, 'store'])->name('store');
    Route::get('/pembayaran', [KurbanController::class, 'payment'])->name('payment');
    Route::post('/upload', [KurbanController::class, 'upload'])->name('upload');
    Route::get('/sukses/{kode}', [KurbanController::class, 'success'])->name('success');
});

Route::get('/laporan-donasi', [LaporanDonasiController::class, 'index'])->name('laporan.index');

Route::get('/cek-status', [CekStatusController::class, 'index'])->name('cek-status.index');
Route::post('/cek-status', [CekStatusController::class, 'cek'])->name('cek-status.cek');

Route::get('/hubungi-admin', [KontakController::class, 'index'])->name('kontak.index');

/*
|--------------------------------------------------------------------------
| ROUTE AUTH ADMIN
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
});
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

/*
|--------------------------------------------------------------------------
| ROUTE ADMIN (PROTECTED)
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::controller(AdminDonasiController::class)->prefix('donasi')->name('donasi.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/export-pdf', 'exportPdf')->name('export-pdf');
        Route::get('/{donasi}', 'show')->name('show');
        Route::patch('/{donasi}/verifikasi', 'verifikasi')->name('verifikasi');
        Route::patch('/{donasi}/tolak', 'tolak')->name('tolak');
        Route::delete('/{donasi}', 'destroy')->name('destroy');
    });

    Route::controller(AdminKurbanController::class)->prefix('kurban')->name('kurban.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/export-pdf', 'exportPdf')->name('export-pdf');
        Route::get('/{kurban}', 'show')->name('show');
        Route::patch('/{kurban}/verifikasi', 'verifikasi')->name('verifikasi');
        Route::patch('/{kurban}/tolak', 'tolak')->name('tolak');
        Route::delete('/{kurban}', 'destroy')->name('destroy');
    });

    Route::resource('jenis-donasi', JenisDonasiController::class)->except(['create', 'edit', 'show']);
    Route::resource('paket-kurban', PaketKurbanController::class)->except(['create', 'edit', 'show']);

    Route::controller(SlotSapiController::class)->prefix('slot-sapi')->name('slot-sapi.')->group(function () {
    Route::patch('/{slotSapi}/reset', 'reset')->name('reset');
    });

    Route::resource('berita', AdminBeritaController::class)->except(['show'])->parameters(['berita' => 'berita']);

    Route::get('/profil-masjid', [ProfilMasjidController::class, 'edit'])->name('profil-masjid.edit');
    Route::put('/profil-masjid', [ProfilMasjidController::class, 'update'])->name('profil-masjid.update');

    Route::get('/laporan-keuangan', [LaporanKeuanganController::class, 'index'])->name('laporan-keuangan.index');
    Route::get('/laporan-keuangan/export-pdf', [LaporanKeuanganController::class, 'exportPdf'])->name('laporan-keuangan.export-pdf');

    Route::resource('pengeluaran', PengeluaranController::class)->only(['store', 'update', 'destroy']);

    Route::resource('laporan-donasi', AdminLaporanDonasiController::class)->except(['show']);
});
