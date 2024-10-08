<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CurrencyConvertController;



Route::get("currencyconvert/{to}/{from}/{amount}", [CurrencyConvertController::class, "convert"]);

