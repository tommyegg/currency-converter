<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CurrencyConvertControllerTest extends TestCase
{
    public function testConvertSuccessful(): void
    {
        $response = $this->get('/api/convert?amount=$100&source=TWD&target=JPY');
        $response->assertStatus(200);
        $response->assertJson([
            'msg' => 'success',
            'amount' => '$366.90'
        ]);
    }

    public function testWrongSourceCurrency(): void
    {
        $response = $this->get('/api/convert?amount=$100&source=EUR&target=JPY');
        $response->assertStatus(422);
        $response->assertJson([
            'msg' => 'fail',
            'error' => 'source currency not found'
        ]);
    }

    public function testWrongTargetCurrency(): void
    {
        $response = $this->get('/api/convert?amount=$100&source=TWD&target=EUR');
        $response->assertStatus(422);
        $response->assertJson([
            'msg' => 'fail',
            'error' => 'target currency not found'
        ]);
    }

    public function testWrongAmountFormat(): void
    {
        $response = $this->get('/api/convert?amount=abc&source=TWD&target=JPY');
        $response->assertStatus(422);
        $response->assertJson([
            'msg' => 'fail',
            'error' => [
                'amount' => [
                    'The amount field format is invalid.'
                ]
            ]
        ]);
    }
}
