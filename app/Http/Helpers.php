<?php

use App\Models\Country;

if (! function_exists('getCurrencyCode')) {
    function getCurrencyCode($code): string
    {
        $countries = config('countries');

        return $countries[$code]['currencyCode'] ?? 'USD';
    }
}

if (! function_exists('currencyCodeByCountryId')) {
    function currencyCodeByCountryId($countryId): string
    {
        if (! $countryId) {
            return 'USD';
        }

        $country = Country::find($countryId);
        $sortname = $country->sortname ?? 'US';
        $currencyCode = getCurrencyCode($sortname);

        $supportedCurrencies = [
            'NGN',
            'GHS',
            'KES',
            'ZAR',
            'XOF',
            'USD',
            'CAD',
            'GBP',
            'EUR',
        ];

        return in_array($currencyCode, $supportedCurrencies, true)
            ? $currencyCode
            : 'USD';
    }
}
