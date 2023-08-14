<?php

namespace App\Http\Controllers;

use App\Http\Requests\CurrencyConvertRequest;
use App\Services\CurrencyConverter\AmountFormatter\FormattedAmountFormatter;
use App\Services\CurrencyConverter\AmountFormatter\RoundedAmountFormatter;
use App\Services\CurrencyConverter\CurrencyConverterService;
use App\Services\CurrencyConverter\Exceptions\CurrencyConvertException;
use Illuminate\Http\JsonResponse;

class CurrencyConverterController extends Controller
{

    /**
     * @param CurrencyConverterService $currencyConverterService
     */
    function __construct(protected CurrencyConverterService $currencyConverterService)
    {
    }

    /**
     * @param CurrencyConvertRequest $currencyConvertRequest
     * @return JsonResponse
     */
    function convert(CurrencyConvertRequest $currencyConvertRequest): JsonResponse
    {
        try {
            $sourceAmount = str_replace(['$', ','], '', $currencyConvertRequest->get('amount'));
            $convertedAmount = $this->currencyConverterService
                ->pushFormatter(new RoundedAmountFormatter(), new FormattedAmountFormatter())
                ->convert(
                    $sourceAmount,
                    $currencyConvertRequest->get('source'),
                    $currencyConvertRequest->get('target')
                );
            return response()->currencyConvertSuccess('$' . $convertedAmount);
        } catch (CurrencyConvertException $e) {
            return response()->currencyConvertFail($e->getMessage());
        }
    }
}
