<?php

namespace App\Api;

use Exception;
use CurlHandle;

class NbpCurrencyApi implements CurrencyApiInterface
{
    private const API_URL = 'http://api.nbp.pl/api/exchangerates/tables/a/?format=json';

    /**
     * {@inheritdoc}
     */
    public function getCurrencyRates(): array
    {
        return $this->fetchDataFromApi(self::API_URL)[0]['rates'];
    }

    /**
     * {@inheritdoc}
     */
    public function getRateByCurrencyCode(string $currencyCode): float
    {
        $url = 'http://api.nbp.pl/api/exchangerates/rates/a/' . $currencyCode . '/?format=json';
        $data = $this->fetchDataFromApi($url);
        return $data['rates'][0]['mid'];
    }

    /**
     * Fetch data from the API.
     *
     * @param string $url The API url
     *
     * @return array The data
     */
    private function fetchDataFromApi(string $url): array
    {
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $content = curl_exec($curl);
        curl_close($curl);

        if ($content === false) {
            throw new Exception('Failed to fetch data from the API.');
        }

        return json_decode($content, true);
    }
}
