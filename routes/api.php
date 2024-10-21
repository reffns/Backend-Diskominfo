<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RequestController;
use App\Http\Controllers\AdminController;

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

Route::post('/submit-request', [RequestController::class, 'submitRequest']);

Route::get('/admin/forms', [RequestController::class, 'index']);

Route::get('/check-status', [RequestController::class, 'checkStatus']);

Route::put('/requests/{id}/status', [RequestController::class, 'updateStatus']);

Route::get('/admin/requests', [RequestController::class, 'getAllRequests']);

Route::get('/admin/requests', [AdminController::class, 'getRequests']);

// Route::group(function () {
//     Route::get('/admin/requests', [AdminController::class, 'index']);
// });

Route::group(['middleware' => 'auth:admin'], function () {
    Route::get('/admin/requests', [AdminController::class, 'index'])->name('admin.requests');
    Route::post('/admin/requests/accept/{id}', [AdminController::class, 'acceptRequest'])->name('admin.requests.accept');
    Route::post('/admin/requests/reject/{id}', [AdminController::class, 'rejectRequest'])->name('admin.requests.reject');
    Route::delete('/admin/requests/delete/{id}', [AdminController::class, 'deleteRequest'])->name('admin.requests.delete');
});


