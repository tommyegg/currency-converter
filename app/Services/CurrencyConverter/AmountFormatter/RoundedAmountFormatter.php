<?php

namespace App\Services\CurrencyConverter\AmountFormatter;

use App\Services\CurrencyConverter\AmountFormatter;
use BCMathExtended\BC;

class RoundedAmountFormatter implements AmountFormatter
{
    /**
     * @param string $amount
     * @return string
     */
    public function process(string $amount): string
    {
        // 四捨五入到小數點第二位
        return BC::round($amount, 2);
    }
}
