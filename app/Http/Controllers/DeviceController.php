<?php

namespace App\Http\Controllers;

use App\Models\Amonia;
use App\Models\Dioksida;
use App\Models\Humidity;
use App\Models\Metana;
use App\Models\Temperature;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DeviceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function dioksida(Request $request)
    {
        try {
            $date = Carbon::now();
            $data = Dioksida::create([
                'id_alat' => $request->id_alat,
                'nilai_dioksida' => $request->nilai,
                'created_at' => $date,
            ]);

            return response()->json(['Data Berhasil Ditambahkan', 'data' => $data]);
        } catch (\Throwable $th) {
            return response()->json('Data Gagal Ditambahkan');
        }
    }

    public function amonia(Request $request)
    {
        try {
            $date = Carbon::now();
            Amonia::create([
                'id_alat' => $request->id_alat,
                'nilai_amonia' => $request->nilai,
                'created_at' => $date,
            ]);

            return response()->json(['Data Berhasil Ditambahkan', 'data' => $data]);
        } catch (\Throwable $th) {
            return response()->json('Data Gagal Ditambahkan');
        }
    }

    public function metana(Request $request)
    {
        try {
            $date = Carbon::now();
            Metana::create([
                'id_alat' => $request->id_alat,
                'nilai_metana' => $request->nilai,
                'created_at' => $date,
            ]);

            return response()->json(['Data Berhasil Ditambahkan', 'data' => $data]);
        } catch (\Throwable $th) {
            return response()->json('Data Gagal Ditambahkan');
        }
    }

    public function temperature(Request $request)
    {
        try {
            $date = Carbon::now();
            Temperature::create([
                'id_alat' => $request->id_alat,
                'nilai_suhu' => $request->nilai,
                'created_at' => $date,
            ]);

            return response()->json(['Data Berhasil Ditambahkan', 'data' => $data]);
        } catch (\Throwable $th) {
            return response()->json('Data Gagal Ditambahkan');
        }
    }

    public function humidity(Request $request)
    {
        try {
            $date = Carbon::now();
            Humidity::create([
                'id_alat' => $request->id_alat,
                'nilai_humidity' => $request->nilai,
                'created_at' => $date,
            ]);

            return response()->json(['Data Berhasil Ditambahkan', 'data' => $data]);
        } catch (\Throwable $th) {
            return response()->json('Data Gagal Ditambahkan');
        }
    }
}
