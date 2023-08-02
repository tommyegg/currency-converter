<?php

namespace App\Services\CurrencyConverter\Exceptions;

/**
 * @method static sourceCurrencyNotFound()
 * @method static targetCurrencyNotFound()
 * @method static inputAmountFormatError()
 */
class CurrencyConvertException extends \Exception
{
    const errorList = [
        'sourceCurrencyNotFound' => [1001, 'source currency not found'],
        'targetCurrencyNotFound' => [1002, 'target currency not found'],
        'inputAmountFormatError' => [1003, 'input amount format error'],
    ];

    public static function __callStatic($name, $arguments)
    {
        if (isset(static::errorList[$name])) {
            return new static(
                static::errorList[$name][1],
                static::errorList[$name][0]
            );
        }
        throw new \BadFunctionCallException();
    }
}
