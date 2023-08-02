<?php

namespace App\Services\CurrencyConverter;

interface AmountFormatter
{
    /**
     * @param string $amount
     * @return string
     */
    public function process(string $amount): string;
}
