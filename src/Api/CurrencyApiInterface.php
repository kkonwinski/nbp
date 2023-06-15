<?php

namespace App\Api;

interface CurrencyApiInterface
{
    /**
     * Fetch the latest currency rates from the API.
     *
     * @return array The currency rates
     */
    public function getCurrencyRates(): array;

    /**
     * Fetch the latest rate for a specific currency from the API.
     *
     * @param string $code The currency code
     *
     * @return float The currency rate
     */
    public function getRateByCurrencyCode(string $currencyCode): float;
}
