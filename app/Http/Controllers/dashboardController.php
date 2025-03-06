<?php

namespace App\Http\Controllers;

use App\Models\alat;
use App\Models\Kualitas;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        function getLatestData($id_alat)
        {
            return [
                'ph' => Kualitas::where('id_alat', $id_alat)->orderBy('created_at', 'desc')->pluck('ph')->first() ?? 'No data available',
                'tds' => Kualitas::where('id_alat', $id_alat)->orderBy('created_at', 'desc')->pluck('tds')->first() ?? 'No data available',
                'do' => Kualitas::where('id_alat', $id_alat)->orderBy('created_at', 'desc')->pluck('do')->first() ?? 'No data available',
                'temperature' => Kualitas::where('id_alat', $id_alat)->orderBy('created_at', 'desc')->pluck('suhu')->first() ?? 'No data available',
                'amonia' => alat::where('id_alat', $id_alat)->orderBy('created_at', 'desc')->pluck('amonia')->first() ?? 'No data available',
                'label' => Kualitas::where('id_alat', $id_alat)->orderBy('created_at', 'desc')->pluck('label')->first() ?? 'No data available',
                'created_at_date' => optional(Kualitas::where('id_alat', $id_alat)->orderBy('created_at', 'desc')->pluck('created_at')->first())->format('d-m-Y') ?? 'No Send data',
                'created_at_hour' => optional(Kualitas::where('id_alat', $id_alat)->orderBy('created_at', 'desc')->pluck('created_at')->first())->format('h:i:s') ?? 'No Send data',
            ];
        }

        $data1 = getLatestData(1);
        $data2 = getLatestData(2);

        $data = [
            'ph1' => $data1['ph'],
            'tds1' => $data1['tds'],
            'do1' => $data1['do'],
            'temperature1' => $data1['temperature'],
            'amonia1' => $data1['amonia'],
            'label1' => $data1['label'],
            'created_at_date1' => $data1['created_at_date'],
            'created_at_hour1' => $data1['created_at_hour'],

            'ph2' => $data2['ph'],
            'tds2' => $data2['tds'],
            'do2' => $data2['do'],
            'temperature2' => $data2['temperature'],
            'amonia2' => $data2['amonia'],
            'label2' => $data2['label'],
            'created_at_date2' => $data2['created_at_date'],
            'created_at_hour2' => $data2['created_at_hour'],
        ];

        return view('dashboard', $data);
    }

    public function getLatestData($id_alat)
    {
        $createdAt = Kualitas::where('id_alat', $id_alat)->orderBy('created_at', 'desc')->value('created_at');

            return [
                'ph' => Kualitas::where('id_alat', $id_alat)->orderBy('created_at', 'desc')->pluck('ph')->first() ?? 'No data available',
                'tds' => Kualitas::where('id_alat', $id_alat)->orderBy('created_at', 'desc')->pluck('tds')->first() ?? 'No data available',
                'do' => Kualitas::where('id_alat', $id_alat)->orderBy('created_at', 'desc')->pluck('do')->first() ?? 'No data available',
                'temperature' => Kualitas::where('id_alat', $id_alat)->orderBy('created_at', 'desc')->pluck('suhu')->first() ?? 'No data available',
                'amonia' => alat::where('id_alat', $id_alat)->orderBy('created_at', 'desc')->pluck('amonia')->first() ?? 'No data available',
                'label' => Kualitas::where('id_alat', $id_alat)->orderBy('created_at', 'desc')->pluck('label')->first() ?? 'No data available',
                'created_at_date' => optional(Kualitas::where('id_alat', $id_alat)->orderBy('created_at', 'desc')->pluck('created_at')->first())->format('d-m-Y') ?? 'No Send data',
                'created_at_hour' => optional(Kualitas::where('id_alat', $id_alat)->orderBy('created_at', 'desc')->pluck('created_at')->first())->format('h:i:s') ?? 'No Send data',
                'created_at_date' => optional($createdAt)->format('d-m-Y') ?? 'No Send data',
                'created_at_hour' => optional($createdAt)->format('h:i:s') ?? 'No Send data',
            ];
    }

    public function fetchData($id_alat)
    {
        return response()->json($this->getLatestData($id_alat));
    }
}
