<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CurrencyConvertController;



Route::post("currentconvert", [CurrencyConvertController::class, "convert"]);

