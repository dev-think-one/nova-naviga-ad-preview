<?php

use Illuminate\Support\Facades\Route;

Route::post('/list-request', \NovaNavigaAdPreview\Http\Controllers\ListRequestController::class);
Route::post('/direct-request', \NovaNavigaAdPreview\Http\Controllers\DirectRequestController::class);
