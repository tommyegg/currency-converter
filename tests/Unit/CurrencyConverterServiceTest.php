<?php

namespace Tests\Unit;

use App\Repositories\CurrencyConverterRepository;
use App\Services\CurrencyConverter\CurrencyConverterService;
use App\Services\CurrencyConverter\Exceptions\CurrencyConvertException;
use App\Services\CurrencyConverter\FormattedAmountFormatter;
use App\Services\CurrencyConverter\RoundedAmountFormatter;
use Tests\TestCase;

class CurrencyConverterServiceTest extends TestCase
{
    protected CurrencyConverterService $currencyConverterService;
    protected function setUp(): void
    {
        parent::setUp();
        // Mock the CurrencyConverterRepository
        $currencyConverterRepository = $this->createMock(CurrencyConverterRepository::class);
        $currencyConverterRepository->method('getExchangeRates')->willReturn([
            'currencies' => [
                'TWD' => [
                    'TWD' => 1,
                    'JPY' => 3.669,
                    'USD' => 0.03281
                ],
                'JPY' => [
                    'TWD' => 0.26956,
                    'JPY' => 1,
                    'USD' => 0.00885
                ],
                'USD' => [
                    'TWD' => 30.444,
                    'JPY' => 111.801,
                    'USD' => 1
                ]
            ]
        ]);
        // Create an instance of CurrencyConverterService
        $this->currencyConverterService = new CurrencyConverterService($currencyConverterRepository);
        $this->currencyConverterService->pushFormatter(new RoundedAmountFormatter(), new FormattedAmountFormatter());
    }
    public function testConvertCurrencyWithValidCurrencies(): void
    {
        $amount = 100;
        $sourceCurrency = 'TWD';
        $targetCurrency = 'JPY';
        $convertedAmount = $this->currencyConverterService->convert($amount, $sourceCurrency, $targetCurrency);
        $this->assertEquals('366.90', $convertedAmount);
    }
    public function testConvertCurrencyWithInvalidSourceCurrency(): void
    {
        $this->expectException(CurrencyConvertException::class);
        $this->expectExceptionCode(1001);
        $amount = 100;
        $sourceCurrency = 'EUR'; // Invalid currency
        $targetCurrency = 'JPY';
        $this->currencyConverterService->convert($amount, $sourceCurrency, $targetCurrency);
    }
    public function testConvertCurrencyWithInvalidTargetCurrency(): void
    {
        $this->expectException(CurrencyConvertException::class);
        $this->expectExceptionCode(1002);
        $amount = 100;
        $sourceCurrency = 'TWD';
        $targetCurrency = 'EUR'; // Invalid currency
        $this->currencyConverterService->convert($amount, $sourceCurrency, $targetCurrency);
    }

    public function testConvertCurrencyWithInvalidAmount(): void
    {
        $this->expectException(CurrencyConvertException::class);
        $this->expectExceptionCode(1003);
        $amount = 'hello';
        $sourceCurrency = 'TWD';
        $targetCurrency = 'EUR'; // Invalid currency
        $this->currencyConverterService->convert($amount, $sourceCurrency, $targetCurrency);
    }
}
