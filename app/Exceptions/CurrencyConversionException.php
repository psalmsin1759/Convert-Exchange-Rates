<?php

namespace App\Exceptions;

use Exception;

class CurrencyConversionException extends Exception
{
    public function __construct($message = "Currency conversion failed.", $code = 0, Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

    public function render()
    {
        return response()->json([
            "success" => false,
            "result" => $this->getMessage(),
        ], 500);
    }
}
