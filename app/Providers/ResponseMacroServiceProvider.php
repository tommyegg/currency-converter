<?php

namespace App\Providers;

use Illuminate\Support\Facades\Response;
use Illuminate\Support\ServiceProvider;

class ResponseMacroServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $customResponseFail = function (string|array $failMsg, int $httpCode = 422) {
            return Response::json([
                'msg' => 'fail',
                'error' => $failMsg
            ], $httpCode);
        };

        $customResponseSuccess = function (string $amount) {
            return Response::json([
                'msg' => 'success',
                'amount' => $amount
            ], 200);
        };

        Response::macro('currencyConvertSuccess', $customResponseSuccess);
        Response::macro('currencyConvertFail', $customResponseFail);
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
