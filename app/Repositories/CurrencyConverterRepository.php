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
        return json_decode(Storage::get('exchange_rates.json'), true);
    }
}
