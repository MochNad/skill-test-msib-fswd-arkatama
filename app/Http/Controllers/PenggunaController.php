<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pengguna;

class PenggunaController extends Controller
{
    public function showInputForm()
    {
        return view('input_form_pengguna');
    }

    public function processInput(Request $request)
    {
        try {
            $request->validate([
                'data' => 'required|string',
            ]);

            $data = $this->extractData($request->data);

            $pengguna = new Pengguna;
            $pengguna->name = trim($data['nama']);
            $pengguna->age = $data['usia'];
            $pengguna->city = trim($data['kota']);
            $pengguna->created_at = now();
            $pengguna->save();

            return response()->json([
                'status' => 'success',
                'data' => $data,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'failed',
                'message' => $e->getMessage(),
            ]);
        }
    }

    private function extractData($input)
    {
        preg_match('/^([^\d]+)(\d+.+)$/', $input, $matches);

        $nama = strtoupper($matches[1]);
        $info = $matches[2];

        preg_match('/(\d+)/', $info, $ageMatches);
        $usia = isset($ageMatches[1]) ? (int)$ageMatches[1] : null;

        $kota = strtoupper(trim(preg_replace("/\d+/", "", $info)));

        $kota = str_ireplace(['TAHUN', 'THN', 'TH'], '', $kota);

        return [
            'nama' => $nama,
            'usia' => $usia,
            'kota' => $kota,
        ];
    }
}
