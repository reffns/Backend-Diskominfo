<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FormHosting;
use App\Models\FormZoom;
use App\Models\Form;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class AdminController extends Controller
{
    // Mendapatkan semua permohonan
    public function getAllRequests()
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
                'reply_file_url' => $form->reply_file_url ?? null, // Tambahkan ini
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
                'reply_file_url' => $form->reply_file_url ?? null, // Tambahkan ini
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
                'reply_file_url' => $form->reply_file_url ?? null, // Tambahkan ini
            ];
        }));
    
    
        return response()->json($allForms);
    }

    // Mengirim balasan dengan file
    public function sendReply(Request $request, $id)
    {
        // Validasi hanya untuk file
        $request->validate([
            'file' => 'required|mimes:pdf,docx,doc|max:2048',
        ]);
    
        // Simpan file ke storage
        $filePath = $request->file('file')->store('replies');
        $fileUrl = Storage::url($filePath);
    
        // Cari form di salah satu tabel
        $form = FormHosting::find($id) 
            ?? FormZoom::find($id) 
            ?? Form::find($id);
    
        if ($form) {
            $form->reply_file_url = $fileUrl; // Simpan URL file ke kolom reply_file_url
            $form->status = 'Selesai'; // Ubah status menjadi "Selesai"
            $form->save();
    
            // Logging untuk debugging
            Log::info("Reply sent for ID: $id", [
                'status' => $form->status,
                'reply_file_url' => $fileUrl,
            ]);
    
            return response()->json([
                'message' => 'Balasan berhasil dikirim',
                'file_url' => $fileUrl,
            ]);
        } else {
            Log::error("Form with ID $id not found");
    
            return response()->json([
                'message' => 'Form tidak ditemukan',
            ], 404);
        }
    }
    
    
}
