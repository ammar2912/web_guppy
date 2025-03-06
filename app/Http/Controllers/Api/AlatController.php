<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Alat;
use App\Models\Kualitas;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Http\Request;

class AlatController extends Controller
{
    public function store(Request $request)
    {
        $client = new Client();

        // Mengambil input dari request
        $suhu = $request->input('suhu');
        $ph = $request->input('ph');
        $tds = $request->input('tds');
        $do = $request->input('do');
        $id_alat = $request->input('id_alat');

        // Perhitungan amonia berdasarkan pH dan suhu
        if ($suhu == 0) {
            return response()->json(['message' => 'Suhu tidak boleh nol'], 400);
        }
        
        if ($ph < 6.5) {
            $amonia = $ph / $suhu * 0.202;
        } elseif ($ph == 7.0) {
            $amonia = $ph / $suhu * 1.131;
        } else {
            $amonia = $ph / $suhu * 3.306;
        }

        try {
            // Simpan data ke tabel alat
            $alat = Alat::create([
                'suhu' => $suhu,
                'ph' => $ph,
                'tds' => $tds,
                'do' => $do,
                'amonia' => $amonia,
                'id_alat' => $id_alat
            ]);

            if ($id_alat == 2) {
                try {
                    // Mengirim request ke API Flask
                    $response = $client->post('http://127.0.0.1:5000/kualitas-air', [
                        'form_params' => [
                            'suhu' => $suhu,
                            'ph' => $ph,
                            'tds' => $tds,
                            'do' => $do,
                            'id_alat' => $id_alat
                        ]
                    ]);

                    // Mengubah response ke bentuk JSON
                    $json = json_decode($response->getBody(), true);

                    if (!isset($json['hasil']) || !isset($json['label'])) {
                        return response()->json([
                            'message' => 'Respon dari API tidak lengkap',
                            'response' => $json
                        ], 500);
                    }

                    // Simpan hasil ke tabel kualitas
                    $kualitas = Kualitas::create([
                        'suhu' => $suhu,
                        'ph' => $ph,
                        'tds' => $tds,
                        'do' => $do,
                        'id_alat' => $id_alat,
                        'hasil' => $json['hasil'],
                        'label' => $json['label']
                    ]);
                } catch (RequestException $e) {
                    return response()->json([
                        'message' => 'Gagal menghubungi API Flask',
                        'error' => $e->getMessage()
                    ], 500);
                }
            }

            return response()->json([
                'message' => 'Data berhasil ditambahkan',
                'db_alat' => $alat,
                'db_kualitas' => $kualitas
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Terjadi kesalahan saat menyimpan data',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}