<?php
declare(strict_types=1);

namespace Fivetwofive\KrateCMS\Core\Database;

use RuntimeException;
use mysqli;

class DatabaseService
{
    private DatabaseConnection $connection;

    public function __construct(DatabaseConnection $connection)
    {
        $this->connection = $connection;
    }

    public function escape(string $string): string
    {
        return $this->connection->escape($string);
    }

    public function confirmResultSet($result): void
    {
        if (!$result) {
            throw new RuntimeException("Database query failed.");
        }
    }
} 