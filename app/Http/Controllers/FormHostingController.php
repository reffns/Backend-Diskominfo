<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\FormHosting;
use App\Models\Request as UserRequest;
use App\Models\RequestForm;

class FormHostingController extends Controller
{
    public function index()
    {
        $forms = FormHosting::all(); // Mengambil semua data dari tabel 'formhosting'
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
            'description' => 'nullable|string', // Opsional
            'proof' => 'nullable|file|mimes:jpg,png,pdf|max:2048', // Opsional
        ]);
    
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors(),
            ], 422);
        }
    
        // Simpan data permohonan ke dalam tabel form_hosting
        $formHosting = new FormHosting();
        $formHosting->name = $request->name;
        $formHosting->date = $request->date;
        $formHosting->category = $request->category;
        $formHosting->code_office = $request->codeOffice; // Sesuaikan dengan nama kolom di database
        $formHosting->description = $request->description;
    
        // Cek jika ada file yang di-upload
        if ($request->hasFile('proof')) {
            $file = $request->file('proof');
            $filePath = $file->store('public/proofs'); // Simpan di folder `public/proofs`
            $formHosting->proof = $filePath; // Simpan path file ke dalam database
        }
    
        // Generate kode unik
        $latestRequest = FormHosting::latest('id')->first();
        $nextNumber = $latestRequest ? ((int)substr($latestRequest->unique_code, -5)) + 1 : 1;
        $uniqueCode = 'HS-' . str_pad($nextNumber, 5, '0', STR_PAD_LEFT);
        $formHosting->unique_code = $uniqueCode;
    
        // Set status default menjadi "Terkirim"
        $formHosting->status = 'Terkirim';
    
        // Simpan data ke dalam database
        $formHosting->save();
    
        // Return success response
        return response()->json([
            'status' => 'success',
            'message' => 'Permohonan berhasil diterima',
            'unique_code' => $uniqueCode,
        ], 201);
    }
    
    
    
    public function checkStatus(Request $request)
    {
        // Ambil kode unik dari query parameter
        $uniqueCode = $request->query('uniqueCode');

        // Cari permohonan berdasarkan kode unik
        $form = FormHosting::where('unique_code', $uniqueCode)->first();

        if (!$form) {
            return response()->json(['status' => 'error', 'message' => 'Kode unik tidak ditemukan'], 404);
        }

        // Jika ditemukan, kembalikan data status permohonan
        return response()->json([
            'status' => 'success',
            'unique_code' => $form->unique_code,
            'status' => $form->status,  // Status terbaru
            'created_at' => $form->created_at,
            'description' => $form->description,
        ]);
    }

    public function getAllRequests()
    {
        $requests = FormHosting::all(); // Mengambil semua data permohonan
        return response()->json($requests);
    }

    public function getStatistics()
    {
        $totalRequests = FormHosting::count();
        $completedRequests = FormHosting::where('status', 'Selesai')->count();
        $pendingRequests = FormHosting::where('status', '!=', 'Selesai')->count();
    
        return response()->json([
            'totalRequests' => $totalRequests,
            'completedRequests' => $completedRequests,
            'pendingRequests' => $pendingRequests,
        ]);
    }
}
