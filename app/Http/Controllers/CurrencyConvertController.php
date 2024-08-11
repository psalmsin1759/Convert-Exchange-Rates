<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\CurrencyConverterService;
use App\Http\Requests\ConvertRequest;


/**
 * @OA\Info(title="ZilliPay Currency Conversion Service", description="Currency exchanges by providing real-time conversion rates. It integrates two currency providers, CurrencyApi and CurrencyExchangeApi", version="1.0.0")
 */

class CurrencyConvertController extends Controller
{
    protected $currencyConverterService;

    public function __construct (CurrencyConverterService $currencyConverterService ){
        $this->currencyConverterService = $currencyConverterService;
    }


    /**
 * @OA\Post(
 *     path="/api/currencyconvert",
 *     summary="Convert currency from one type to another",
 *     tags={"Currency"},
 *     @OA\RequestBody(
 *         @OA\MediaType(
 *             mediaType="application/x-www-form-urlencoded",
 *             @OA\Schema(
 *                 @OA\Property(property="from", type="string", description="Base currency code", example="USD"),
 *                 @OA\Property(property="to", type="string", description="Target currency code", example="EUR"),
 *                 @OA\Property(property="amount", type="number", description="Amount to be converted", example=100.0),
 *                 example={
 *                     "from": "USD",
 *                     "to": "EUR",
 *                     "amount": 100.0
 *                 }
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Successful currency conversion",
 *         @OA\JsonContent(
 *             @OA\Property(property="success", type="boolean", example=true),
 *             @OA\Property(property="result", type="number", example=84.75),
 *             @OA\Examples(example="result", value={"success": true, "result": 84.75}, summary="Conversion result.")
 *         )
 *     ),
 *     @OA\Response(
 *         response=422,
 *         description="Validation error",
 *         @OA\JsonContent(
 *             @OA\Property(property="success", type="boolean", example=false),
 *             @OA\Property(property="message", type="string", example="The from field is required."),
 *             @OA\Examples(example="validation_error", value={"success": false, "message": "The from field is required."}, summary="Validation error.")
 *         )
 *     ),
 *     @OA\Response(
 *         response=500,
 *         description="Internal server error",
 *         @OA\JsonContent(
 *             @OA\Property(property="success", type="boolean", example=false),
 *             @OA\Property(property="message", type="string", example="Currency conversion API request failed."),
 *             @OA\Examples(example="server_error", value={"success": false, "message": "Currency conversion API request failed."}, summary="Internal server error.")
 *         )
 *     )
 * )
 */

    public function convert(ConvertRequest $request){


       $validatedData =  $request->validated();

       $result = $this->currencyConverterService->convert($validatedData);

       return response()->json($result, 200); 

    }


}
