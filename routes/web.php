<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\Config\HakAksesController;
use App\Http\Controllers\Home\DashboardController;
use App\Http\Controllers\Laporan\KeuanganController;
use App\Http\Controllers\Laporan\LaporanTransaksiController;
use App\Http\Controllers\Laporan\PendapatanKaryawanController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Redirect;
use App\Http\Controllers\Master\MasterCustomerController;
use App\Http\Controllers\Master\MasterJenisMobilController;
use App\Http\Controllers\Master\MasterKaryawanController;
use App\Http\Controllers\Master\MasterPresentaseController;
use App\Http\Controllers\Master\MasterSnackController;
use App\Http\Controllers\Transaksi\TransaksiController;
use App\Http\Controllers\Transaksi\TransaksiSnackController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/login', [AuthController::class, 'index'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::middleware(['cors','cek_login'])->group(function () {
    Route::get('/', function(){
        return Redirect::Route('dashboard');
    });

    Route::prefix('dashboard')->group(function(){
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
        Route::get('/get-data', [DashboardController::class, 'get_data']);
    });
    
    Route::prefix('master')->group(function(){
        Route::prefix('customer')->group(function(){
            Route::get('/', [MasterCustomerController::class, 'index'])->name('master.customer');
            Route::get('/detail/{id}', [MasterCustomerController::class, 'detail']);
            Route::get('/datatables', [MasterCustomerController::class, 'datatables']);
            Route::post('/store-update', [MasterCustomerController::class, 'store_update']);
            Route::delete('/delete/{id}', [MasterCustomerController::class, 'delete']);
        });
    
        Route::prefix('karyawan')->group(function(){
            Route::get('/', [MasterKaryawanController::class, 'index'])->name('master.karyawan');
            Route::get('/detail/{id}', [MasterKaryawanController::class, 'detail']);
            Route::get('/datatables', [MasterKaryawanController::class, 'datatables']);
            Route::post('/store-update', [MasterKaryawanController::class, 'store_update']);
            Route::delete('/delete/{id}', [MasterKaryawanController::class, 'delete']);
        });
    
        Route::prefix('jenis-mobil')->group(function(){
            Route::get('/', [MasterJenisMobilController::class, 'index'])->name('master.jenis_mobil');
            Route::get('/detail/{id}', [MasterJenisMobilController::class, 'detail']);
            Route::get('/datatables', [MasterJenisMobilController::class, 'datatables']);
            Route::post('/store-update', [MasterJenisMobilController::class, 'store_update']);
            Route::delete('/delete/{id}', [MasterJenisMobilController::class, 'delete']);
        });
    
        Route::prefix('presentase')->group(function(){
            Route::get('/', [MasterPresentaseController::class, 'index'])->name('master.presentase');
            Route::get('/detail/{id}', [MasterPresentaseController::class, 'detail']);
            Route::get('/datatables', [MasterPresentaseController::class, 'datatables']);
            Route::post('/store-update', [MasterPresentaseController::class, 'store_update']);
            Route::delete('/delete/{id}', [MasterPresentaseController::class, 'delete']);
        });


        Route::prefix('snack')->group(function(){
            Route::get('/', [MasterSnackController::class, 'index'])->name('master.snack');
            Route::get('/detail/{id}', [MasterSnackController::class, 'detail']);
            Route::get('/datatables', [MasterSnackController::class, 'datatables']);
            Route::post('/store-update', [MasterSnackController::class, 'store_update']);
            Route::delete('/delete/{id}', [MasterSnackController::class, 'delete']);
        });
    });
    
    Route::prefix('main')->group(function(){
        Route::prefix('transaksi')->group(function(){
            Route::get('/', [TransaksiController::class, 'index'])->name('main.transaksi');
            Route::post('/store', [TransaksiController::class, 'store']);
            Route::get('/suggestion-plat/{input}', [TransaksiController::class, 'suggestion_plat']);
        });
        
        Route::prefix('transaksi-snack')->group(function(){
            Route::get('/', [TransaksiSnackController::class, 'index'])->name('main.transaksi_snack');
            Route::get('/datatables', [TransaksiSnackController::class, 'datatables_snack']);
            Route::post('/store', [TransaksiSnackController::class, 'store']);
        });
    });

    Route::prefix('laporan')->group(function(){
        Route::prefix('transaksi')->group(function(){
            Route::get('/', [LaporanTransaksiController::class, 'index'])->name('laporan.transaksi');
            Route::get('/detail/{id}', [LaporanTransaksiController::class, 'detail']);
            Route::get('/datatables', [LaporanTransaksiController::class, 'datatables']);
            Route::get('/change-date', [LaporanTransaksiController::class, 'change_date']);
            Route::delete('/delete/{id}', [TransaksiController::class, 'delete']);
        });
        
        Route::prefix('pendapatan-karyawan')->group(function(){
            Route::get('/', [PendapatanKaryawanController::class, 'index'])->name('laporan.pendapatan_karyawan');
            Route::get('/detail', [PendapatanKaryawanController::class, 'detail']);
            Route::get('/datatables', [PendapatanKaryawanController::class, 'datatables']);
            Route::get('/change-date', [PendapatanKaryawanController::class, 'change_date']);
        });

        Route::prefix('keuangan')->group(function(){
            Route::get('/', [KeuanganController::class, 'index'])->name('laporan.keuangan');
            Route::get('/datatables', [KeuanganController::class, 'datatables']);
            Route::get('/change-date', [KeuanganController::class, 'change_date']);
        });
    });

    Route::prefix('config')->group(function(){
        Route::prefix('hak-akses')->group(function(){
            Route::get('/', [HakAksesController::class, 'index'])->name('config.hak_akses');
            Route::get('/detail/{id}', [HakAksesController::class, 'detail']);
            Route::get('/datatables', [HakAksesController::class, 'datatables']);
            Route::post('/store-update', [HakAksesController::class, 'store_update']);
            Route::delete('/delete/{id}', [HakAksesController::class, 'delete']);
        });
    });
    

    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
});

