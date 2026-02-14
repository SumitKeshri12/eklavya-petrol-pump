<?php

use App\Http\Controllers\API\RcaController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    Route::match(['get', 'post'], '/rca/analyze', [RcaController::class, 'analyze']);
});
