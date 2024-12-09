<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\FormZoom;

class FormZoomController extends Controller
{
    public function index()
    {
        $forms = FormZoom::all();
        return response()->json($forms);
    }

    public function submitRequest(Request $request)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'date' => 'required|date',
            'category' => 'required|string',
            'codeOffice' => 'required|string|max:100',
            'description' => 'nullable|string', // Keterangan opsional
            'proof' => 'nullable|file|mimes:jpg,png,pdf,doc,xlsx|max:2048', // File opsional
        ]);
    
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors(),
            ], 422);
        }
    
        // Simpan data permohonan ke dalam tabel form_zoom
        $formZoom = new FormZoom();
        $formZoom->name = $request->name;
        $formZoom->date = $request->date;
        $formZoom->category = $request->category;
        $formZoom->code_office = $request->codeOffice;
        $formZoom->description = $request->description;
    
        // Cek jika ada file yang di-upload
        if ($request->hasFile('proof')) {
            $file = $request->file('proof');
            $filePath = $file->store('public/proofs'); // Simpan di folder `public/proofs`
            $formZoom->proof = $filePath;
        }
    
        // Generate kode unik
        $latestRequest = FormZoom::latest('id')->first();
        $nextNumber = $latestRequest ? ((int)substr($latestRequest->unique_code, -5)) + 1 : 1;
        $uniqueCode = 'ZM-' . str_pad($nextNumber, 5, '0', STR_PAD_LEFT);
        $formZoom->unique_code = $uniqueCode;
    
        // Set status default menjadi "Terkirim"
        $formZoom->status = 'Terkirim';
    
        // Simpan data ke dalam database
        $formZoom->save();
    
        // Return success response
        return response()->json([
            'status' => 'success',
            'message' => 'Permohonan berhasil diterima',
            'unique_code' => $uniqueCode,
        ], 201);
    }
    
    

    public function checkStatus(Request $request)
    {
        $uniqueCode = $request->query('uniqueCode');
        $form = FormZoom::where('unique_code', $uniqueCode)->first();

        if (!$form) {
            return response()->json(['status' => 'error', 'message' => 'Kode unik tidak ditemukan'], 404);
        }

        return response()->json([
            'status' => 'success',
            'unique_code' => $form->unique_code,
            'status' => $form->status,
            'created_at' => $form->created_at,
            'description' => $form->description,
        ]);
    }
}
