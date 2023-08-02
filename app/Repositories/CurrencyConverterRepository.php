<?php

namespace App\Repositories;

use Illuminate\Support\Facades\Storage;

class CurrencyConverterRepository
{
    /**
     * @return array
     */
    public function getExchangeRates() : array
    {
        return json_decode(file_get_contents(base_path('exchange_rates.json')), true);
    }
}
