<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Request as UserRequest;
use App\Models\RequestForm;

class RequestController extends Controller
{
    public function index()
    {
        $forms = RequestForm::all(); // Mengambil semua data dari tabel 'requests'
        return response()->json($forms);
    }

    public function updateStatus(Request $request, $id)
    {
        // Cari permohonan berdasarkan ID
        $requests = RequestForm::find($id);
        if (!$requests) {
            return response()->json(['message' => 'Permohonan tidak ditemukan'], 404);
        }
    
        $requests->status = $request->status;
        $requests->save();
    
        return response()->json(['message' => 'Status diperbarui'], 200);
    }

    public function submitRequest(Request $request)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'date' => 'required|date',
            'category' => 'required|string',
            'codeOffice' => 'required|string',
            'description' => 'nullable|string', // Mengubah menjadi opsional
            'file' => 'nullable|mimes:pdf,doc,docx|max:2048', // Mengubah menjadi opsional
        ]);
    
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors(),
            ], 422);
        }
    
        // Simpan data permohonan
        $userRequest = new UserRequest($request->all());
    
        // Generate kode unik
        $latestRequest = UserRequest::latest('id')->first();
        $nextNumber = $latestRequest ? ((int)substr($latestRequest->unique_code, -5)) + 1 : 1;
        $uniqueCode = 'PM-' . str_pad($nextNumber, 5, '0', STR_PAD_LEFT);
        $userRequest->unique_code = $uniqueCode;
    
        // Cek jika ada file yang di-upload
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $filePath = $file->store('public/uploads'); // Simpan di folder `public/uploads`
            $userRequest->file_path = $filePath; // Simpan path file ke dalam database
        }
    
        $userRequest->save();
    
        // Return success response
        return response()->json([
            'status' => 'success',
            'message' => 'Permohonan berhasil diterima',
            'unique_code' => $uniqueCode,
        ], 200);
    }
    
    

    public function checkStatus(Request $request)
    {
        // Ambil kode unik dari query parameter
        $uniqueCode = $request->query('uniqueCode');

        // Cari permohonan berdasarkan kode unik
        $form = RequestForm::where('unique_code', $uniqueCode)->first();

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
        $requests = RequestForm::all(); // Mengambil semua data permohonan
        return response()->json($requests);
    }

    public function getStatistics()
    {
        $totalRequests = RequestForm::count();
        $completedRequests = RequestForm::where('status', 'Selesai')->count();
        $pendingRequests = RequestForm::where('status', '!=', 'Selesai')->count();
    
        return response()->json([
            'totalRequests' => $totalRequests,
            'completedRequests' => $completedRequests,
            'pendingRequests' => $pendingRequests,
        ]);
    }
    
    
}
