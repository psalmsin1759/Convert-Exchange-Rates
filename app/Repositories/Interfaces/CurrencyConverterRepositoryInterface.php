<?php

namespace App\Repositories\Interfaces;

interface CurrencyConverterRepositoryInterface {
    public function convert(array $data);
}
