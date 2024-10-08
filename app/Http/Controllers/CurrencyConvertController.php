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
     * @OA\Get(
     *     path="/api/currencyconvert/{to}/{from}/{amount}",
     *     summary="Convert currency from one type to another",
     *     tags={"Currency Conversion"},
     *     @OA\Parameter(
     *         name="to",
     *         in="path",
     *         description="Currency code to convert to (e.g. USD)",
     *         required=true,
     *         @OA\Schema(
     *             type="string",
     *             example="USD"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="from",
     *         in="path",
     *         description="Currency code to convert from (e.g. EUR)",
     *         required=true,
     *         @OA\Schema(
     *             type="string",
     *             example="EUR"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="amount",
     *         in="path",
     *         description="Amount to be converted",
     *         required=true,
     *         @OA\Schema(
     *             type="number",
     *             format="float",
     *             example=100
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
     *         response=400,
     *         description="Bad request or validation error",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="Invalid currency code")
     *         )
     *     )
     * )
     */

    public function convert($to, $from, $amount){


       //$validatedData =  $request->validated();

       $validatedData = [
            "to" => $to,
            "from" => $from,
            "amount" => $amount
       ];

       $result = $this->currencyConverterService->convert($validatedData);

       return response()->json($result, 200); 

    }


}
