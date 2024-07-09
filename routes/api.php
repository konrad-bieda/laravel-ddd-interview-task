<?php

use App\Modules\Invoices\Infrastructure\Http\Controllers\InvoiceController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::controller(InvoiceController::class)
    ->name('invoice.')
    ->prefix('invoice')
    ->group(static function () {
        Route::get('/{id}', 'show')->name('show');
        Route::get('/{id}/approve', 'approve')->name('approve');
        Route::get('/{id}/reject', 'reject')->name('reject');
    });
