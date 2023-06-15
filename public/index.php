<?php

require_once '../vendor/autoload.php';

use App\Service\CurrencyService;
use Dotenv\Dotenv;
use App\Database\PdoDatabase;

$dotenv = Dotenv::createImmutable(__DIR__ . '/..');
$dotenv->load();

$dbHost = "mariadb";
$dbName = $_ENV['MARIADB_DATABASE'];
$dbUser = $_ENV['MARIADB_USER'];
$dbPass = $_ENV['MARIADB_PASSWORD'];

$database = new PdoDatabase($dbHost, $dbName, $dbUser, $dbPass);

$currencyService = new CurrencyService($database->getPdo());
$currencies = $currencyService->getAllCurrencies();

// Handle post request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $amount = filter_input(INPUT_POST, 'amount', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
    if ($amount === false) {
        die('Invalid amount provided.');
    }
    $from = filter_input(INPUT_POST, 'from', FILTER_SANITIZE_STRING);
    $to = filter_input(INPUT_POST, 'to', FILTER_SANITIZE_STRING);

    $result = $currencyService->convertCurrency($amount, $from, $to);

    if ($result === null) {
        die("Could not fetch currency rates from the database.");
    }

    $database->execute("INSERT INTO conversions (from_currency, to_currency, amount, result) VALUES (?, ?, ?, ?)", [$from, $to, $amount, $result]);

    header("Location: " . $_SERVER['REQUEST_URI'], true, 303);
    exit;
}

$conversions = $database->query("SELECT * FROM conversions ORDER BY id DESC LIMIT 10");

require '../src/Views/form.php';
require '../src/Views/conversions.php';
