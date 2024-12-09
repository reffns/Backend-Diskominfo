<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FormHosting;
use App\Models\FormZoom;
use App\Models\Form;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        $keyword = $request->query('q'); // Ambil query string `q`

        if (!$keyword) {
            return response()->json(['error' => 'Kata kunci pencarian tidak diberikan'], 400);
        }

        // Cari di tabel FormHosting
        $hostingResults = FormHosting::where('name', 'LIKE', "%$keyword%")
            ->orWhere('description', 'LIKE', "%$keyword%")
            ->orWhere('unique_code', 'LIKE', "%$keyword%")
            ->get(['id', 'name', 'date', 'unique_code', 'description', 'status']);

        // Tambahkan kategori "Hosting" secara manual
        $hostingResults->each(function ($item) {
            $item->category = 'Hosting';
        });

        // Cari di tabel FormZoom
        $zoomResults = FormZoom::where('name', 'LIKE', "%$keyword%")
            ->orWhere('description', 'LIKE', "%$keyword%")
            ->orWhere('unique_code', 'LIKE', "%$keyword%")
            ->get(['id', 'name', 'date', 'unique_code', 'description', 'status']);

        // Tambahkan kategori "Zoom" secara manual
        $zoomResults->each(function ($item) {
            $item->category = 'Zoom';
        });

        // Cari di tabel Form
        $troubleshootResults = Form::where('name', 'LIKE', "%$keyword%")
            ->orWhere('description', 'LIKE', "%$keyword%")
            ->orWhere('unique_code', 'LIKE', "%$keyword%")
            ->get(['id', 'name', 'date', 'unique_code', 'description', 'status']);

        // Tambahkan kategori "Troubleshoot" secara manual
        $troubleshootResults->each(function ($item) {
            $item->category = 'Troubleshoot';
        });

        // Gabungkan semua hasil pencarian
        $results = $hostingResults->merge($zoomResults)->merge($troubleshootResults);

        return response()->json($results);
    }

    public function getStatusByCode($unique_code)
    {
        // Cari di tabel yang relevan (Hosting, Zoom, Troubleshoot)
        $form = FormHosting::where('unique_code', $unique_code)->first()
            ?? FormZoom::where('unique_code', $unique_code)->first()
            ?? Form::where('unique_code', $unique_code)->first();
    
        if (!$form) {
            return response()->json(['error' => 'Permohonan tidak ditemukan'], 404);
        }
    
        // Ambil semua status berdasarkan urutan yang logis
        $timeline = [
            [
                'time' => $form->created_at->format('Y-m-d H:i:s'),
                'status' => 'Terkirim',
                'description' => 'Permohonan Anda sudah terkirim.',
            ],
        ];
    
        // Tambahkan status berikutnya sesuai kondisi
        if (in_array($form->status, ['Diterima', 'Diproses', 'Selesai'])) {
            $timeline[] = [
                'time' => $form->updated_at->format('Y-m-d H:i:s'),
                'status' => 'Diterima',
                'description' => 'Permohonan Anda telah diterima dan sedang diproses.',
            ];
        }
    
        if (in_array($form->status, ['Diproses', 'Selesai'])) {
            $timeline[] = [
                'time' => $form->updated_at->format('Y-m-d H:i:s'),
                'status' => 'Diproses',
                'description' => 'Permohonan Anda sedang dalam proses penyelesaian.',
            ];
        }
    
        if ($form->status === 'Selesai') {
            $timeline[] = [
                'time' => now()->format('Y-m-d H:i:s'),
                'status' => 'Selesai',
                'description' => 'Permohonan Anda telah selesai.',
            ];
        }
    
        return response()->json([
            'status' => $form->status,
            'timeline' => $timeline,
            'currentStatus' => $form->status,
            'reply_file_url' => $form->reply_file_url ? asset($form->reply_file_url) : null, // Tambahkan URL balasan surat jika ada
        ]);
    }
    
    

    // Fungsi untuk mendapatkan deskripsi berdasarkan status
    private function getDescriptionForStatus($status)
    {
        $descriptions = [
            'Menunggu' => 'Permohonan Anda sedang menunggu proses.',
            'Diproses' => 'Permohonan Anda sedang diproses.',
            'Selesai' => 'Permohonan Anda telah selesai.',
        ];

        return $descriptions[$status] ?? 'Status tidak diketahui.';
    }

    public function getReplyByCode($unique_code)
    {
        $form = FormHosting::where('unique_code', $unique_code)->first()
            ?? FormZoom::where('unique_code', $unique_code)->first()
            ?? Form::where('unique_code', $unique_code)->first();
    
        if (!$form || !$form->reply_file_url) {
            return response()->json(['error' => 'Surat balasan tidak ditemukan'], 404);
        }
    
        return response()->json([
            'reply_file_url' => asset($form->reply_file_url),
        ]);
    }

    public function downloadReplyFile($unique_code)
    {
        // Cari form berdasarkan unique_code
        $form = FormHosting::where('unique_code', $unique_code)->first()
            ?? FormZoom::where('unique_code', $unique_code)->first()
            ?? Form::where('unique_code', $unique_code)->first();
    
        if (!$form || !$form->reply_file_url) {
            return response()->json(['error' => 'File tidak ditemukan'], 404);
        }
    
        // Path file
        $filePath = public_path($form->reply_file_url);
    
        if (!file_exists($filePath)) {
            return response()->json(['error' => 'File tidak ditemukan di server'], 404);
        }
    
        // Mengunduh file
        return response()->download($filePath);
    }
    
    
}
