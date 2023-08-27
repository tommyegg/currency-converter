<?php

namespace App\Services\CurrencyConverter;

use App\Repositories\ExchangeRateRepository;
use App\Repositories\Interface\ExchangeRateInterface;
use App\Services\CurrencyConverter\Exceptions\CurrencyConvertException;

class CurrencyConverterService
{
    /**
     * @var array
     */
    protected array $formatterList;

    /**
     * @param ExchangeRateInterface $exchangeRateInterface
     */
    public function __construct(protected ExchangeRateInterface $exchangeRateInterface)
    {
    }

    /**
     * @param AmountFormatter ...$formatter
     * @return $this
     */
    public function pushFormatter(AmountFormatter ...$formatter): self
    {
        $this->formatterList = $formatter;
        return $this;
    }


    /**
     * @param string|int $amount
     * @param string $sourceCurrency
     * @param string $targetCurrency
     * @return string
     * @throws CurrencyConvertException
     */
    private function convertCurrency(string|int $amount, string $sourceCurrency, string $targetCurrency): string
    {
        $rateList = $this->exchangeRateInterface->getExchangeRates();

        if (!isset($rateList['currencies'][$sourceCurrency])) {
            throw CurrencyConvertException::sourceCurrencyNotFound();
        }

        if (!isset($rateList['currencies'][$sourceCurrency][$targetCurrency])) {
            throw CurrencyConvertException::targetCurrencyNotFound();
        }

        // 計算轉換後的金額
        return bcmul($amount, $rateList['currencies'][$sourceCurrency][$targetCurrency], 3);
    }

    /**
     * @param string|int|float $amount
     * @param string $sourceCurrency
     * @param string $targetCurrency
     * @return string
     * @throws CurrencyConvertException
     */
    public function convert(string|int|float $amount, string $sourceCurrency, string $targetCurrency): string
    {
        if (!preg_match('/^[+]?[0-9]*\.?[0-9]+$/', $amount)) {
            throw CurrencyConvertException::inputAmountFormatError();
        }
        $afterConvertAmount = $this->convertCurrency($amount, $sourceCurrency, $targetCurrency);
        return $this->formatAmount($afterConvertAmount);
    }

    protected function formatAmount(string $amount): string
    {
        return array_reduce(
            $this->formatterList,
            function ($amount, $processor) {
                return $processor->process($amount);
            },
            $amount
        );
    }
}
