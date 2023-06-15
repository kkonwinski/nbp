<?php

namespace App\Database;

use Exception;
use PDO;
use PDOException;

/**
 * Class PdoDatabase
 * Class responsible for managing the connection and interaction with the database using PDO.
 *
 * @package App\Database
 */
class PdoDatabase
{
    /**
     * @var PDO Instance of PDO class
     */
    private PDO $pdo;

    /**
     * PdoDatabase constructor.
     *
     * @param string $host Database host
     * @param string $dbname Database name
     * @param string $user Database user
     * @param string $pass Database user password
     *
     * @throws Exception If connection to database fails
     */
    public function __construct(string $host, string $dbname, string $user, string $pass)
    {
        try {
            $this->pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            throw new Exception("Could not connect to the database: " . $e->getMessage());
        }
    }

    /**
     * Get the PDO instance.
     *
     * @return PDO Instance of PDO class
     */
    public function getPdo(): PDO
    {
        return $this->pdo;
    }

    /**
     * Execute a query and return the result.
     *
     * @param string $sql The SQL query
     * @param array $params The parameters for the SQL query
     *
     * @return array The result of the query
     */
    public function query(string $sql, array $params = []): array
    {
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Execute a SQL statement.
     *
     * @param string $sql The SQL statement
     * @param array $params The parameters for the SQL statement
     *
     * @return bool The result of the execution
     */
    public function execute(string $sql, array $params = []): bool
    {
        return $this->pdo->prepare($sql)->execute($params);
    }
}