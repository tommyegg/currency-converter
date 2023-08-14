<?php

namespace App\Services\CurrencyConverter\AmountFormatter;

use App\Services\CurrencyConverter\AmountFormatter;

class FormattedAmountFormatter implements AmountFormatter
{
    /**
     * @param string $amount
     * @return string
     */
    public function process(string $amount) : string
    {
        // 增加千分位表示
        return number_format($amount, 2, '.', ',');
    }
}
