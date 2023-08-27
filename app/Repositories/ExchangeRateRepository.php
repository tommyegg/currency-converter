<?php

namespace App\Repositories;

use App\Repositories\Interface\ExchangeRateInterface;
use Illuminate\Support\Facades\Storage;

class ExchangeRateRepository implements ExchangeRateInterface
{
    /**
     * @return array
     */
    public function getExchangeRates() : array
    {
        return json_decode(file_get_contents(base_path('exchange_rates.json')), true);
    }
}
