<?php

namespace App;

use PDO;
use PDOException;

class Currency
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function getRate(string $currencyCode): ?float
    {
        try {
            $stmt = $this->pdo->prepare("SELECT `rate` FROM `currencies` WHERE `code` = :code");
            $stmt->execute([':code' => $currencyCode]);

            $rate = $stmt->fetchColumn();

            if ($rate !== false) {
                return (float)$rate;
            }
        } catch (PDOException $e) {
            error_log($e->getMessage());
        }

        return null;
    }

    public function addOrUpdateRate(string $currencyCode, float $newRate, string $currency): bool
    {
        try {
            $stmt = $this->pdo->prepare(
                "INSERT INTO currencies (code, rate, currency) VALUES (:code, :rate, :currency) 
             ON DUPLICATE KEY UPDATE rate = :rate"
            );
            $stmt->execute([':rate' => $newRate, ':code' => $currencyCode, ':currency' => $currency]);

            return true;
        } catch (PDOException $e) {
            error_log($e->getMessage());
        }

        return false;
    }

    /**
     * Get all currencies from the database.
     *
     * @return array The array of currencies
     */
    public function getAllCurrencies(): array
    {
        try {
            $stmt = $this->pdo->prepare("SELECT * FROM `currencies`");
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log($e->getMessage());
        }

        return [];
    }
}
