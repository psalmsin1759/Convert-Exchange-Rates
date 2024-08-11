<?php

namespace App\Services;
use App\Repositories\Interfaces\CurrencyConverterRepositoryInterface;

class CurrencyConverterService {

    private $currencyConverterRepositoryInterface;

    public function __construct(CurrencyConverterRepositoryInterface $currencyConverterRepositoryInterface){
        $this->currencyConverterRepositoryInterface = $currencyConverterRepositoryInterface;
    }

    public function convert(array $data)
    {
        return $this->currencyConverterRepositoryInterface->convert($data);
    }

}
