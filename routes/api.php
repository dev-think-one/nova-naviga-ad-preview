<?php

use Illuminate\Support\Facades\Route;

Route::post('/list-request', \NovaNavigaAdPreview\Http\Controllers\ListRequestController::class)
    ->name('nova-naviga-ad-preview.api.list');
Route::post('/direct-request', \NovaNavigaAdPreview\Http\Controllers\DirectRequestController::class)
    ->name('nova-naviga-ad-preview.api.direct');
