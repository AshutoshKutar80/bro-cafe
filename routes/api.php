<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\RiderLocationController;

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/order/{order}/rider-location', [RiderLocationController::class, 'show']);
});