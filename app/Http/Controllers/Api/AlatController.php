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

        // Ambil data dari request
        $suhu = $request->input('suhu');
        $ph = $request->input('ph');
        $tds = $request->input('tds');
        $do = $request->input('do');
        $id_alat = $request->input('id_alat');

        // Validasi suhu
        if ($suhu == 0) {
            return response()->json(['message' => 'Suhu tidak boleh nol'], 400);
        }
        
        // Perhitungan amonia
        if ($ph < 6.5) {
            $amonia = $ph / $suhu * 0.202;
        } elseif ($ph == 7.0) {
            $amonia = $ph / $suhu * 1.131;
        } else {
            $amonia = $ph / $suhu * 3.306;
        }

        try {
            // Simpan data ke database
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
                    $response = $client->post('http://127.0.0.1:5000/kualitas-air', [
                        'form_params' => [
                            'suhu' => $suhu,
                            'ph' => $ph,
                            'tds' => $tds,
                            'do' => $do,
                            'id_alat' => $id_alat
                        ]
                    ]);

                    $json = json_decode($response->getBody(), true);

                    if (!isset($json['label'])) {
                        return response()->json(['message' => 'Respon tidak lengkap'], 500);
                    }

                    // Simpan hasil ke database
                    Kualitas::create([
                        'suhu' => $suhu,
                        'ph' => $ph,
                        'tds' => $tds,
                        'do' => $do,
                        'id_alat' => $id_alat,
                        'hasil' => $json['hasil'],
                        'label' => $json['label'],
                    ]);

                    // Kembalikan response label untuk ESP32
                    return response()->json([
                        'message' => 'Data berhasil ditambahkan',
                        'label' => $json['label']
                    ], 201);
                } catch (RequestException $e) {
                    return response()->json(['message' => 'Gagal ke Flask', 'error' => $e->getMessage()], 500);
                }
            }

            return response()->json([
                'message' => 'Data berhasil ditambahkan',
                'label' => "Tidak Ada" // Jika alat bukan ID 2
            ], 201);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Kesalahan saat menyimpan', 'error' => $e->getMessage()], 500);
        }
    }
}
