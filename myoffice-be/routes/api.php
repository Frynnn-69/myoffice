<?php

use App\Http\Controllers\API\BookingTransactionController;
use App\Http\Controllers\API\CityController;
use App\Http\Controllers\API\OfficeSpaceController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

    Route::get('/city/{city:slug}', [CityController::class, 'show']);
    Route::apiResource('/cities', CityController::class); //alternatif route untuk endpoint cities (api resource udah handle CRUD)

    Route::get('/office/{officeSpace:slug', [OfficeSpaceController::class, 'show']);
    Route::apiResource('/office', OfficeSpaceController::class); 

    Route::post('/booking-transcation', [BookingTransactionController::class, 'store']); 
    Route::post('/check-booking', [BookingTransactionController::class, 'booking_details']);
