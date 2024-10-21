<?php

namespace App\Http\Controllers;

use App\Models\RequestForm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    // Method untuk menampilkan semua permohonan
    public function index()
    {
        $requests = RequestForm::all();
        return response()->json($requests);
    }
    
    public function acceptRequest($id)
    {
        $requestForm = RequestForm::findOrFail($id);
        $requestForm->status = 'Diterima';
        $requestForm->save();
    
        return response()->json(['message' => 'Permohonan diterima.']);
    }
    
    public function rejectRequest($id)
    {
        $requestForm = RequestForm::findOrFail($id);
        $requestForm->status = 'Ditolak';
        $requestForm->save();
    
        return response()->json(['message' => 'Permohonan ditolak.']);
    }
    
    public function deleteRequest($id)
    {
        $requestForm = RequestForm::findOrFail($id);
        $requestForm->delete();
    
        return response()->json(['message' => 'Permohonan dihapus.']);
    }
    public function showLoginForm()
    {
        return view('admin.login'); // Pastikan Anda memiliki view ini
    }
    
    // Proses login admin
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
    
        if (Auth::guard('admin')->attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('admin/dashboard'); // Arahkan ke halaman dashboard admin
        }
    
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }

}
