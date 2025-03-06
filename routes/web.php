<?php

use App\Exports\AmmoniaExport;
use App\Exports\DOExport;
use App\Exports\PHExport;
use App\Exports\TDSExport;
use App\Exports\TemperatureExport;
use App\Http\Controllers\ChartsController;
use App\Http\Controllers\dashboardController;
use App\Http\Controllers\RiwayatController;
use App\Http\Controllers\HistoryController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Maatwebsite\Excel\Facades\Excel;

Route::get('/', function () {
    return redirect('/login');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('dashboard', [dashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard/data/{id_alat}', [DashboardController::class, 'fetchData'])->name('dashboard.data');
    Route::controller(RiwayatController::class)->prefix('/dashboard')->group(function () {
        Route::view('detail/1', 'dashboard/detaildashboard1')->name('detail.dashboard1');
        Route::view('detail/2', 'dashboard/detaildashboard2')->name('detail.dashboard2');
        Route::view('detail/3', 'dashboard/detaildashboard3')->name('detail.dashboard3');
        Route::view('detail/4', 'dashboard/detaildashboard4')->name('detail.dashboard4');
    });
    Route::get('chartdioksida/{id}', [ChartsController::class, 'dioksida'])->name('api.chartdioksida');
    Route::get('chartamonia/{id}', [ChartsController::class, 'amonia'])->name('api.chartamonia');
    Route::get('chartmetana/{id}', [ChartsController::class, 'metana'])->name('api.chartmetana');
    Route::get('charthumidity/{id}', [ChartsController::class, 'humidity'])->name('api.charthumidity');
    Route::get('charttemperature/{id}', [ChartsController::class, 'temperature'])->name('api.charttemperature');
    Route::view('karyawan', 'karyawan')->name('karyawan');
    Route::view('blog', 'blog')->name('blog');
    Route::view('addblog', 'addblog')->name('addblog');
    Route::view('profile', 'profile')->name('profile');

    Route::controller(RiwayatController::class)->prefix('/dashboard')->group(function () {
        Route::get('riwayat-temperature', 'riwayatTemperature')->name('riwayat.temperature');

        Route::get('history', [HistoryController::class, 'index'])->name('history');

        Route::get('riwayat-ph', 'riwayatPH')->name('riwayat.ph');
        Route::get('riwayat-tds', 'riwayatTDS')->name('riwayat.tds');
        Route::get('riwayat-do', 'riwayatDO')->name('riwayat.do');
        Route::get('riwayat-amonia', 'riwayatAmonia')->name('riwayat.amonia');

        Route::post('/data/amonia', 'getAmoniaData')->name('data.riwayatamonia');
        Route::post('/data/temperature', 'getTemperatureData')->name('data.riwayattemperature');
        Route::post('/data/tds', 'getTDSData')->name('data.riwayattds');
        Route::post('/data/ph', 'getPHData')->name('data.riwayatph');
        Route::post('/data/do', 'getDOData')->name('data.riwayatdo');

    });
    Route::get('export/ammonia', function (Request $request) {
        $startDate = $request->query('createFrom');
        $endDate = $request->query('createTo');
        return Excel::download(new AmmoniaExport($startDate, $endDate), 'ammonia_data.xlsx');
    })->name('export.ammonia');

    Route::get('export/temperature', function (Request $request) {
        $startDate = $request->input('createFrom');
        $endDate = $request->input('createTo');

        return Excel::download(new TemperatureExport($startDate, $endDate), 'temperature_data.xlsx');
    })->name('export.temperature');

    Route::get('export/ph', function (Request $request) {
        $startDate = $request->input('createFrom');
        $endDate = $request->input('createTo');

        return Excel::download(new PHExport($startDate, $endDate), 'ph_data.xlsx');
    })->name('export.ph');

    Route::get('export/tds', function (Request $request) {
        $startDate = $request->input('createFrom');
        $endDate = $request->input('createTo');

        return Excel::download(new TDSExport($startDate, $endDate), 'tds_data.xlsx');
    })->name('export.tds');

    Route::get('export/do', function (Request $request) {
        $startDate = $request->input('createFrom');
        $endDate = $request->input('createTo');

        return Excel::download(new DOExport($startDate, $endDate), 'do_data.xlsx');
    })->name('export.do');
});

require __DIR__.'/auth.php';
