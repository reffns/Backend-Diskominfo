<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});



Route::prefix('admin')->middleware(['auth'])->group(function () {
    Route::get('dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('users', [AdminController::class, 'users'])->name('admin.users');
});



// Route::middleware('auth:admin')->group(function() {
//     // Semua rute admin di sini
//     Route::get('/admin', [AdminController::class, 'index'])->name('admin.dashboard');
// });

// Route::get('/admin/login', [AdminController::class, 'showLoginForm'])->name('admin.login');

// // Rute untuk menangani login admin
// Route::post('/admin/login', [AdminController::class, 'login'])->name('admin.login.submit');

// // Rute untuk halaman dashboard admin
// Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard')->middleware('admin');

// // Rute untuk menerima permohonan
// Route::post('/admin/requests/{id}/accept', [AdminController::class, 'acceptRequest'])->name('admin.requests.accept');

// // Rute untuk menolak permohonan
// Route::post('/admin/requests/{id}/reject', [AdminController::class, 'rejectRequest'])->name('admin.requests.reject');

// // Rute untuk menghapus permohonan
// Route::delete('/admin/requests/{id}', [AdminController::class, 'deleteRequest'])->name('admin.requests.delete');

// Route::middleware(['auth:admin'])->group(function () {
//     Route::get('/admin', [AdminController::class, 'index'])->name('admin.dashboard');
//     Route::post('/admin/accept/{id}', [AdminController::class, 'acceptRequest'])->name('admin.accept');
//     Route::post('/admin/reject/{id}', [AdminController::class, 'rejectRequest'])->name('admin.reject');
//     Route::delete('/admin/delete/{id}', [AdminController::class, 'deleteRequest'])->name('admin.delete');
// });

// routes/web.php (Laravel)
// Route::get('/api/admin/requests', [AdminController::class, 'index']);
// Route::post('/api/admin/accept/{id}', [AdminController::class, 'acceptRequest']);
// Route::post('/api/admin/reject/{id}', [AdminController::class, 'rejectRequest']);
// Route::delete('/api/admin/delete/{id}', [AdminController::class, 'deleteRequest']);



Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
