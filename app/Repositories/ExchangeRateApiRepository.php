<?php

namespace App\Repositories;


use App\Repositories\Interfaces\CurrencyConverterRepositoryInterface;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\Log;
use App\Exceptions\CurrencyConversionException;

class ExchangeRateApiRepository implements CurrencyConverterRepositoryInterface
{

    protected $client;
    protected $apiKey;

    public function __construct()
    {
        $this->client = new Client();
        $this->apiKey = env('EXCHANGE_RATE_API_KEY');
    }

    public function convert(array $data)
    {
        $from = $data['from'];
        $to = $data['to'];
        $amount = $data['amount'];

        $url = "https://v6.exchangerate-api.com/v6/{$this->apiKey}/pair/{$from}/{$to}/{$amount}";

        
        try {
            $response = $this->client->get($url);
            $data = json_decode($response->getBody(), true);

            if ($data['result'] === 'success') {
                return ["success" => true, "result" => $data['conversion_result']];
            }

            return ["success" => false, "result" => $data['error-type']];
        } catch (RequestException $e) {
            //Log::error('Currency conversion API request failed: ' . $e->getMessage());
            throw new CurrencyConversionException('Currency conversion API request failed.');
        } catch (\Exception $e) {
            //Log::error('Currency conversion failed: ' . $e->getMessage());
            throw new CurrencyConversionException('Currency conversion failed.');
        }
    }

}
