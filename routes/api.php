<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RequestController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\RequestDisplayController;
use App\Http\Controllers\FormController;
use App\Http\Controllers\FormHostingController;
use App\Http\Controllers\FormZoomController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TechnicianDashboardController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\DaftarPermohonanController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/PermohonanZoom', [RequestController::class, 'submitRequest']);

Route::get('/requests', [RequestController::class, 'index']);

Route::put('/requests/{id}', [RequestController::class, 'updateStatus']);

Route::get('/statistics', [RequestController::class, 'getStatistics']);

Route::get('/admin/forms', [RequestController::class, 'index']);

Route::get('/check-status', [RequestController::class, 'checkStatus']);

Route::put('/requests/{id}/status', [RequestController::class, 'updateStatus']);

Route::get('/admin/requests', [RequestController::class, 'getAllRequests']);

Route::post('/hosting-request', [FormHostingController::class, 'submitRequest']);

Route::get('/PermohonanZoom', [FormZoomController::class, 'index']);
Route::post('/PermohonanZoom', [FormZoomController::class, 'submitRequest']);
Route::get('/PermohonanZoom/status', [FormZoomController::class, 'checkStatus']);

Route::get('/users', [UserController::class, 'index']);
Route::post('/users', [UserController::class, 'store']);
Route::put('/users/{id}', [UserController::class, 'update']);
Route::patch('/users/{id}/deactivate', [UserController::class, 'deactivate']);
Route::patch('/users/{id}/reactivate', [UserController::class, 'reactivate']);
Route::delete('/users/{id}', [UserController::class, 'destroy']);


// Route::group(function () {
//     Route::get('/admin/requests', [AdminController::class, 'index']);
// });



Route::get('/technician/requests', [TechnicianDashboardController::class, 'getAllForms']);
Route::post('/technician/update-status', [TechnicianDashboardController::class, 'updateStatus']);
Route::post('/teknisi/kirim-surat-balasan', [TechnicianDashboardController::class, 'kirimSuratBalasan']);



Route::get('/admin/requests', [AdminController::class, 'getAllRequests']);
Route::post('/admin/reply/{id}', [AdminController::class, 'sendReply']);



Route::post('/submit-form', [FormController::class, 'submitForm']);

Route::post('/submit-request', [RequestController::class, 'submitRequest']);


Route::get('/search', [SearchController::class, 'search']);
Route::get('/status/{unique_code}', [SearchController::class, 'getStatusByCode']);
Route::get('/api/reply/{unique_code}', [SearchController::class, 'getReplyByCode']);
Route::get('/download-reply/{unique_code}', [SearchController::class, 'downloadReplyFile']);



Route::get('/daftar-permohonan', [DaftarPermohonanController::class, 'getAllRequests']);
