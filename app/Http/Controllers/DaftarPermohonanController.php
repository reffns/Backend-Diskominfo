<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FormHosting;
use App\Models\FormZoom;
use App\Models\Form;

class DaftarPermohonanController extends Controller
{
    public function getAllRequests()
    {
        // Ambil data dari tabel FormHosting
        $hostingRequests = FormHosting::all()->map(function ($item) {
            return [
                'id' => $item->id,
                'nama' => $item->name,
                'tanggal' => $item->date,
                'kategori' => 'Hosting',
                'kodeUnik' => $item->unique_code, // Ambil kode unik
                'fileBukti' => $item->file_proof_url, // Ganti dengan kolom file bukti yang sesuai
                'keterangan' => $item->description,
                'status' => $item->status,
            ];
        });

        // Ambil data dari tabel FormZoom
        $zoomRequests = FormZoom::all()->map(function ($item) {
            return [
                'id' => $item->id,
                'nama' => $item->name,
                'tanggal' => $item->date,
                'kategori' => 'Zoom Meeting',
                'kodeUnik' => $item->unique_code, // Ambil kode unik
                'fileBukti' => $item->file_proof_url, // Ganti dengan kolom file bukti yang sesuai
                'keterangan' => $item->description,
                'status' => $item->status,
            ];
        });

        // Ambil data dari tabel Form
        $troubleshootRequests = Form::all()->map(function ($item) {
            return [
                'id' => $item->id,
                'nama' => $item->name,
                'tanggal' => $item->date,
                'kategori' => 'Troubleshoot',
                'kodeUnik' => $item->unique_code, // Ambil kode unik
                'fileBukti' => $item->file_proof_url, // Ganti dengan kolom file bukti yang sesuai
                'keterangan' => $item->description,
                'status' => $item->status,
            ];
        });

        // Gabungkan semua data
        $allRequests = $hostingRequests->merge($zoomRequests)->merge($troubleshootRequests);

        return response()->json($allRequests);
    }
}
