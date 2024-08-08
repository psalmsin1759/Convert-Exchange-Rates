<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Services\CurrencyConverterService;
use Mockery;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CurrencyConvertControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testConvertSuccess()
    {
       
        $serviceMock = Mockery::mock(CurrencyConverterService::class);
        $serviceMock->shouldReceive('convert')
                    ->once()
                    ->andReturn([
                        'success' => true,
                        'result' => 5.8884,
                    ]);

        $this->app->instance(CurrencyConverterService::class, $serviceMock);

        $data = [
            'from' => 'EUR',
            'to' => 'GBP',
            'amount' => 7.0,
        ];

       
        $response = $this->postJson('/api/currentconvert', $data);

       
        $response->assertStatus(200)
                 ->assertJson([
                     'success' => true,
                     'result' => 5.8884,
                 ]);
    }

    public function testConvertFailure()
    {
        
        $serviceMock = Mockery::mock(CurrencyConverterService::class);
        $serviceMock->shouldReceive('convert')
                    ->once()
                    ->andReturn([
                        'success' => false,
                        'result' => 'unknown-code',
                    ]);

        $this->app->instance(CurrencyConverterService::class, $serviceMock);

        $data = [
            'from' => 'EUR',
            'to' => 'GBP',
            'amount' => 7.0,
        ];

       
        $response = $this->postJson('/api/currentconvert', $data);

        
        $response->assertStatus(200)
                 ->assertJson([
                     'success' => false,
                     'result' => 'unknown-code',
                 ]);
    }
}
