<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CurrencyConvertController;



Route::post("currencyconvert", [CurrencyConvertController::class, "convert"]);

