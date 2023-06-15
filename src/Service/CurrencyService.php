<?php

namespace App\Service;

use App\Api\NbpCurrencyApi;
use App\Currency;
use PDO;

class CurrencyService
{
    private Currency $currency;

    public function __construct(PDO $pdo)
    {
        $this->currency = new Currency($pdo);
        $api = new NbpCurrencyApi();
        $rates = $api->getCurrencyRates();

        // Update the rates in the database
        foreach ($rates as $rate) {
            $this->currency->addOrUpdateRate($rate['code'], $rate['mid'], $rate['currency']);
        }
    }

    /**
     * Convert a given amount from one currency to another.
     *
     * @param float  $amount The amount to convert
     * @param string $from   The currency to convert from
     * @param string $to     The currency to convert to
     *
     * @return float|null The converted amount or null in case of error
     */
    public function convertCurrency(float $amount, string $from, string $to): ?float
    {
        $fromRate = $this->currency->getRate($from);
        $toRate = $this->currency->getRate($to);

        if ($fromRate === null || $toRate === null) {
            return null;
        }

        return ($amount / $fromRate) * $toRate;
    }


    /**
     * Get all currencies from the database.
     *
     * @return array The array of currencies
     */
    public function getAllCurrencies(): array
    {
        return $this->currency->getAllCurrencies();
    }
}
