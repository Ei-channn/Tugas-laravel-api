<?php

use App\Http\Controllers\Api\InvoiceController;
use App\Http\Controllers\Api\ItemController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

Route::apiResource('items', ItemController::class);
Route::apiResource('invoice', InvoiceController::class);