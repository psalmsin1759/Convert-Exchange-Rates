<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Services\CurrencyConverterService;
use App\Repositories\CurrencyConverterRepositoryInterface;
use Mockery;

class CurrencyConverterServiceTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }


    public function testConvertSuccess()
    {
       
        $repositoryMock = Mockery::mock(CurrencyConverterRepositoryInterface::class);
        $repositoryMock->shouldReceive('convert')
                       ->once()
                       ->andReturn([
                           'success' => true,
                           'result' => 5.8884,
                       ]);

        $service = new CurrencyConverterService($repositoryMock);
        $data = [
            'from' => 'EUR',
            'to' => 'GBP',
            'amount' => 7.0,
        ];

       
        $result = $service->convert($data);

       
        $this->assertTrue($result['success']);
        $this->assertEquals(5.8884, $result['result']);
    }

    public function testConvertFailure()
    {
       
        $repositoryMock = Mockery::mock(CurrencyConverterRepositoryInterface::class);
        $repositoryMock->shouldReceive('convert')
                       ->once()
                       ->andReturn([
                           'success' => false,
                           'result' => 'unknown-code',
                       ]);

        $service = new CurrencyConverterService($repositoryMock);
        $data = [
            'from' => 'EUR',
            'to' => 'GBP',
            'amount' => 7.0,
        ];

        
        $result = $service->convert($data);

       
        $this->assertFalse($result['success']);
        $this->assertEquals('unknown-code', $result['result']);
    }
}
