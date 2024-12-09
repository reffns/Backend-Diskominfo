<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use App\Models\Form; // Pastikan model Form sudah sesuai dengan tabel Anda.

class FormController extends Controller
{
    /**
     * Method untuk menangani pengiriman form
     */
    public function submitForm(Request $request)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'date' => 'required|date',
            'category' => 'required|string',
            'uploadFile' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'description' => 'required|string',
        ]);
    
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors(),
            ], 422);
        }
    
        try {
            // Simpan file yang diunggah
            $filePath = null;
            if ($request->hasFile('uploadFile')) {
                $file = $request->file('uploadFile');
                $filePath = $file->store('public/uploads'); // Simpan di folder 'public/uploads'
            }
    
            // Simpan data ke database
            $form = new Form();
            $form->name = $request->name;
            $form->date = $request->date;
            $form->category = $request->category;
            $form->description = $request->description;
            $form->upload_file_path = $filePath; // Simpan path file ke database
    
            // Generate kode unik
            $latestForm = Form::latest('id')->first();
            $nextNumber = $latestForm ? ((int)substr($latestForm->unique_code, -5)) + 1 : 1;
            $uniqueCode = 'TS-' . str_pad($nextNumber, 5, '0', STR_PAD_LEFT);
            $form->unique_code = $uniqueCode;
    
            // Set status default menjadi "Terkirim"
            $form->status = 'Terkirim';
    
            $form->save();
    
            // Return success response
            return response()->json([
                'status' => 'success',
                'message' => 'Form berhasil dikirim.',
                'unique_code' => $uniqueCode,
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan saat menyimpan data.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
    
}
