<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RiskRegisterController;

Route::get('/', [RiskRegisterController::class, 'index']);

Route::get('risks/bulk-upload', [RiskRegisterController::class, 'showBulkForm']);
Route::post('risks/bulk-process', [RiskRegisterController::class, 'processBulkUpload']);

Route::resource('risks', RiskRegisterController::class);
