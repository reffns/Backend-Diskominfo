<?php

namespace App\Http\Controllers;

use App\Models\Request; // Sesuaikan dengan model Anda
use App\Models\RequestForm;
use Illuminate\Http\Request as HttpRequest;

class RequestDisplayController extends Controller
{
    public function index()
    {
        // Ambil semua permohonan dari database
        $requests = RequestForm::all();

        // Opsional: Periksa struktur data
        // dd($requests); // Hapus komentar pada baris ini untuk melihat struktur output

        // Periksa apakah data memang sebuah array
        if (is_array($requests)) {
            return response()->json($requests);
        } else {
            return response()->json(['error' => 'Format data tidak terduga.'], 500);
        }
    }
}
