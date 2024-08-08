<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\CurrencyConverterService;
use App\Http\Requests\ConvertRequest;

class CurrencyConvertController extends Controller
{
    protected $currencyConverterService;

    public function __construct (CurrencyConverterService $currencyConverterService ){
        $this->currencyConverterService = $currencyConverterService;
    }

    public function convert(ConvertRequest $request){


       $validatedData =  $request->validated();

       $result = $this->currencyConverterService->convert($validatedData);

       return response()->json($result, 200); 

    }


}
