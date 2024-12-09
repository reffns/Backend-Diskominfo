<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FormHosting;
use App\Models\FormZoom;
use App\Models\Form;

class TechnicianDashboardController extends Controller
{
    public function getAllForms()
    {
        $hostingForms = FormHosting::all();
        $zoomForms = FormZoom::all();
        $troubleshootForms = Form::all();
    
        // Gabungkan semua data dalam satu array
        $allForms = $hostingForms
            ->map(function ($form) {
                return [
                    'id' => $form->id,
                    'name' => $form->name,
                    'date' => $form->date,
                    'category' => 'Hosting',
                    'description' => $form->description,
                    'proof' => $form->proof ?? null,
                    'unique_code' => $form->unique_code,
                    'status' => $form->status,
                ];
            })
            ->merge($zoomForms->map(function ($form) {
                return [
                    'id' => $form->id,
                    'name' => $form->name,
                    'date' => $form->date,
                    'category' => 'Zoom',
                    'description' => $form->description,
                    'proof' => $form->proof ?? null,
                    'unique_code' => $form->unique_code,
                    'status' => $form->status,
                ];
            }))
            ->merge($troubleshootForms->map(function ($form) {
                return [
                    'id' => $form->id,
                    'name' => $form->name,
                    'date' => $form->date,
                    'category' => 'Troubleshoot',
                    'description' => $form->description,
                    'proof' => $form->upload_file_path ?? null,
                    'unique_code' => $form->unique_code,
                    'status' => $form->status,
                ];
            }));
    
        return response()->json($allForms);
    }

    public function updateStatus(Request $request)
    {
        $id = $request->input('id');
        $category = $request->input('category');
        $newStatus = $request->input('status');
    
        // Validasi status yang diperbolehkan
        $allowedStatuses = ['Terkirim', 'Diterima', 'Ditolak', 'Diproses', 'Selesai'];
        if (!in_array($newStatus, $allowedStatuses)) {
            return response()->json(['error' => 'Status tidak valid'], 400);
        }
    
        // Validasi kategori
        $validCategories = ['Hosting', 'Zoom', 'Troubleshoot'];
        if (!in_array($category, $validCategories)) {
            return response()->json(['error' => 'Kategori tidak valid'], 400);
        }
    
        // Cari form berdasarkan kategori
        if ($category === 'Hosting') {
            $form = FormHosting::find($id);
        } elseif ($category === 'Zoom') {
            $form = FormZoom::find($id);
        } elseif ($category === 'Troubleshoot') {
            $form = Form::find($id);
        }
    
        // Periksa apakah form ditemukan
        if (!$form) {
            return response()->json(['error' => 'Form tidak ditemukan'], 404);
        }
    
        // Perbarui status
        $form->status = $newStatus;
        $form->save();
    
        return response()->json(['success' => 'Status berhasil diperbarui']);
    }
    

    public function kirimSuratBalasan(Request $request)
    {
        $validated = $request->validate([
            'unique_code' => 'required|exists:forms,unique_code', // Pastikan tabel `forms` atau sesuaikan
            'file_bukti' => 'required|file|mimes:pdf,docx|max:2048',
            'category' => 'required|in:Hosting,Zoom,Troubleshoot',
        ]);
    
        // Temukan form berdasarkan kategori
        $form = null;
        if ($validated['category'] === 'Hosting') {
            $form = FormHosting::where('unique_code', $validated['unique_code'])->first();
        } elseif ($validated['category'] === 'Zoom') {
            $form = FormZoom::where('unique_code', $validated['unique_code'])->first();
        } elseif ($validated['category'] === 'Troubleshoot') {
            $form = Form::where('unique_code', $validated['unique_code'])->first();
        }
    
        // Pastikan form ditemukan
        if (!$form) {
            return response()->json(['error' => 'Form tidak ditemukan'], 404);
        }
    
        // Simpan file surat balasan
        $filePath = $request->file('file_bukti')->store('surat_balasan', 'public');
        $form->proof = asset('storage/' . $filePath); // Simpan URL file di kolom `proof`
        $form->status = 'Selesai'; // Ubah status menjadi selesai
        $form->save();
    
        return response()->json(['success' => 'Surat balasan berhasil dikirim']);
    }
    
    

}
