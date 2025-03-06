<?php

namespace App\Http\Controllers;

use App\Models\Amonia;
use App\Models\Dioksida;
use App\Models\Humidity;
use App\Models\Metana;
use App\Models\Temperature;
use Illuminate\Http\Request;

class ChartsController extends Controller
{
    public function index() 
    {
        function getLatestData($id_alat)
        {
            return [
                'Dioksida' => Dioksida::where('id_alat', $id_alat)->limit(1)->latest()->get(),
                'Metana' => Metana::where('id_alat', $id_alat)->limit(1)->latest()->get(),
                'Humidity' => Humidity::where('id_alat', $id_alat)->limit(1)->latest()->get(),
                'Temperature' => Temperature::where('id_alat', $id_alat)->limit(1)->latest()->get(),
                'Amonia' => Amonia::where('id_alat', $id_alat)->limit(1)->latest()->get(),
            ];
        }

        $data1 = getLatestData(1);
        $data2 = getLatestData(2);
        $data3 = getLatestData(3);
        $data4 = getLatestData(4);

        $data = [
            'Dioksida1' => $data1['Dioksida'],
            'Metana1' => $data1['Metana'],
            'Humidity1' => $data1['Humidity'],
            'Temperature1' => $data1['Temperature'],
            'Amonia1' => $data1['Amonia'],

            'Dioksida2' => $data2['Dioksida'],
            'Metana2' => $data2['Metana'],
            'Humidity2' => $data2['Humidity'],
            'Temperature2' => $data2['Temperature'],
            'Amonia2' => $data2['Amonia'],

            'Dioksida3' => $data3['Dioksida'],
            'Metana3' => $data3['Metana'],
            'Humidity3' => $data3['Humidity'],
            'Temperature3' => $data3['Temperature'],
            'Amonia3' => $data3['Amonia'],

            'Dioksida4' => $data4['Dioksida'],
            'Metana4' => $data4['Metana'],
            'Humidity4' => $data4['Humidity'],
            'Temperature4' => $data4['Temperature'],
            'Amonia4' => $data4['Amonia'],
        ];

        return view('dashboard', $data);
    }

    public function dioksida(Request $request, $id)
    {
        try {
            $speeds = Dioksida::where('id_alat', $id)->latest()->take(30)->get()->sortBy('id_dioksida');
            $labels = $speeds->pluck('created_at')->map(function ($date) {
                return $date->format('H:i');
            })->toArray();
            $data = $speeds->pluck('nilai_dioksida')->toArray();

            // Ambil 1 data terakhir
            $latestData = Dioksida::latest()->first();

            return response()->json([
                'labels' => $labels,
                'data' => $data,
                'latest' => [
                    'id_dioksida' => $latestData->id_dioksida,
                    'nilai_dioksida' => $latestData->nilai_dioksida,
                    'created_at' => $latestData->created_at,
                    'updated_at' => $latestData->updated_at,
                ],
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function detaildashboard(Request $request, $id)
    {
        return view('dashboard/detaildashboard');
    }

    public function metana(Request $request, $id)
    {
        try {
            $speeds = Metana::where('id_alat', $id)->latest()->take(30)->get()->sortBy('id_metana');
            $labels = $speeds->pluck('created_at')->map(function ($date) {
                return $date->format('H:i');
            })->toArray();
            $data = $speeds->pluck('nilai_metana')->toArray();

            $latestData = Metana::latest()->first();

            return response()->json([
                'labels' => $labels,
                'data' => $data,
                'latest' => [
                    'id_metana' => $latestData->id_metana,
                    'nilai_metana' => $latestData->nilai_metana,
                    'created_at' => $latestData->created_at,
                    'updated_at' => $latestData->updated_at,
                ],
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function humidity(Request $request, $id)
    {
        try {
            $speeds = Humidity::where('id_alat', $id)->latest()->take(30)->get()->sortBy('id_humidity');
            $labels = $speeds->pluck('created_at')->map(function ($date) {
                return $date->format('H:i');
            })->toArray();
            $data = $speeds->pluck('nilai_humidity')->toArray();

            $latestData = Humidity::latest()->first();

            return response()->json([
                'labels' => $labels,
                'data' => $data,
                'latest' => [
                    'id_humidity' => $latestData->id_humidity,
                    'nilai_humidity' => $latestData->nilai_humidity,
                    'created_at' => $latestData->created_at,
                    'updated_at' => $latestData->updated_at,
                ],
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function temperature(Request $request, $id)
    {
        try {
            $speeds = Temperature::where('id_alat', $id)->latest()->take(30)->get()->sortBy('id_temp');
            $labels = $speeds->pluck('created_at')->map(function ($date) {
                return $date->format('H:i');
            })->toArray();
            $data = $speeds->pluck('nilai_suhu')->toArray();

            $latestData = Temperature::latest()->first();

            return response()->json([
                'labels' => $labels,
                'data' => $data,
                'latest' => [
                    'id_temp' => $latestData->id_temp,
                    'nilai_suhu' => $latestData->nilai_suhu,
                    'created_at' => $latestData->created_at,
                    'updated_at' => $latestData->updated_at,
                ],
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function amonia(Request $request, $id)
    {
        try {
            $speeds = Amonia::where('id_alat', $id)->latest()->take(30)->get()->sortBy('id_amonia');
            $labels = $speeds->pluck('created_at')->map(function ($date) {
                return $date->format('H:i');
            })->toArray();
            $data = $speeds->pluck('nilai_amonia')->toArray();

            $latestData = Amonia::latest()->first();

            return response()->json([
                'labels' => $labels,
                'data' => $data,
                'latest' => [
                    'id_amonia' => $latestData->id_amonia,
                    'nilai_amonia' => $latestData->nilai_amonia,
                    'created_at' => $latestData->created_at,
                    'updated_at' => $latestData->updated_at,
                ],
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
