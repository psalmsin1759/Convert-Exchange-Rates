<?php

namespace App\Repositories;


use App\Repositories\Interfaces\CurrencyConverterRepositoryInterface;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\Log;
use App\Exceptions\CurrencyConversionException;

class CurrencyApiRepository implements CurrencyConverterRepositoryInterface
{

    protected $client;
    protected $apiKey;

    public function __construct()
    {
        $this->client = new Client();
        $this->apiKey = env('CURRENCY_API_KEY');
    }

    public function convert(array $data)
    {
        $baseCurrency = $data['from'];
        $targetCurrency = $data['to'];
        $amount = $data['amount'];

        $url = "https://api.currencyapi.com/v3/convert/v3/latest?base_currency={$baseCurrency}&currencies={$targetCurrency}&apikey={$this->apiKey}";

        try {
            $response = $this->client->get($url);
            $responseData = json_decode($response->getBody(), true);

            if (isset($responseData['data'][$targetCurrency])) {
                $conversionRate = $responseData['data'][$targetCurrency]['value'];
                $conversionResult = $amount * $conversionRate;

                return ["success" => true, "result" => $conversionResult];
            }

            return ["success" => false, "result" => 'unknown-code'];
        } catch (RequestException $e) {
           // Log::error('Currency conversion API request failed: ' . $e->getMessage());
            throw new CurrencyConversionException('Currency conversion API request failed.');
        } catch (\Exception $e) {
            //Log::error('Currency conversion failed: ' . $e->getMessage());
            throw new CurrencyConversionException('Currency conversion API request failed.');
        }
    }


}
