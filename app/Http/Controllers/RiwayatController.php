<?php

namespace App\Http\Controllers;

use App\Exports\ExportRiwayat;
use App\Models\alat;
use App\Models\Kualitas;
use Excel;
use Illuminate\Http\Request;

class RiwayatController extends Controller
{
    public function riwayatTemperature()
    {
        return view('riwayat/temperature');
    }

    public function riwayatPH()
    {
        return view('riwayat/ph');
    }

    public function riwayatAmonia(Request $request)
    {
        return view('riwayat/amonia');
    }

    public function riwayatDO()
    {
        return view('riwayat/do');
    }

    public function riwayatTDS()
    {
        return view('riwayat/tds');
    }


    public function getAmoniaData(Request $request)
    {
        $start_date = $request->input('createFrom') ?? now()->subDays(7)->format('Y-m-d');
        $end_date = $request->input('createTo') ?? now()->format('Y-m-d');

        // Query untuk mendapatkan data suhu rata-rata antara dua tanggal
        $data = alat::selectRaw('DATE(created_at) as date, round(AVG(amonia), 0) as avg_amonia')
            ->whereBetween('created_at', [$start_date, $end_date])
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // Format data untuk Chart.js
        $labels = $data->pluck('date');
        $values = $data->pluck('avg_amonia');

        return response()->json([
            'labels' => $labels,
            'data' => $values,
        ]);
    }

    public function getTemperatureData(Request $request)
    {
        $start_date = $request->input('createFrom') ?? now()->subDays(7)->format('Y-m-d');
        $end_date = $request->input('createTo') ?? now()->format('Y-m-d');

        // Query untuk mendapatkan data suhu rata-rata antara dua tanggal
        $data = alat::selectRaw('DATE(created_at) as date, round(AVG(suhu), 0) as avg_temperature')
            ->where('id_alat', 2)
            ->whereBetween('created_at', [$start_date, $end_date])
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // Format data untuk Chart.js
        $labels = $data->pluck('date');
        $values = $data->pluck('avg_temperature');

        return response()->json([
            'labels' => $labels,
            'data' => $values,
        ]);
    }

    public function getTDSData(Request $request)
    {
        $start_date = $request->input('createFrom') ?? now()->subDays(7)->format('Y-m-d');
        $end_date = $request->input('createTo') ?? now()->format('Y-m-d');

        // Query untuk mendapatkan data suhu rata-rata antara dua tanggal
        $data = alat::selectRaw('DATE(created_at) as date, round(AVG(tds), 0) as avg_tds')
            ->whereBetween('created_at', [$start_date, $end_date])
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // Format data untuk Chartb.js
        $labels = $data->pluck('date');
        $values = $data->pluck('avg_tds');

        return response()->json([
            'labels' => $labels,
            'data' => $values,
        ]);
    }

    public function getDOData(Request $request)
    {
        $start_date = $request->input('createFrom') ?? now()->subDays(7)->format('Y-m-d');
        $end_date = $request->input('createTo') ?? now()->format('Y-m-d');

        // Query untuk mendapatkan data suhu rata-rata antara dua tanggal
        $data = alat::selectRaw('DATE(created_at) as date, round(AVG(do), 0) as avg_do')
            ->whereBetween('created_at', [$start_date, $end_date])
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // Format data untuk Chart.js
        $labels = $data->pluck('date');
        $values = $data->pluck('avg_do');

        return response()->json([
            'labels' => $labels,
            'data' => $values,
        ]);
    }

    public function getPHData(Request $request)
    {
        $start_date = $request->input('createFrom') ?? now()->subDays(7)->format('Y-m-d');
        $end_date = $request->input('createTo') ?? now()->format('Y-m-d');

        // Query untuk mendapatkan data suhu rata-rata antara dua tanggal
        $data = alat::selectRaw('DATE(created_at) as date, round(AVG(ph), 0) as avg_ph')
            ->whereBetween('created_at', [$start_date, $end_date])
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // Format data untuk Chart.js
        $labels = $data->pluck('date');
        $values = $data->pluck('avg_ph');

        return response()->json([
            'labels' => $labels,
            'data' => $values,
        ]);
    }
}
