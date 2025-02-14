<?php
declare(strict_types=1);

namespace Fivetwofive\KrateCMS\Core\Database;

use mysqli;
use Exception;

class DatabaseConnection
{
    private mysqli $connection;
    
    public function __construct(array $config)
    {
        $this->connect($config);
    }
    
    private function connect(array $config): void
    {
        $this->connection = new mysqli(
            $config['server'],
            $config['user'],
            $config['pass'],
            $config['name']
        );
        
        if ($this->connection->connect_errno) {
            throw new Exception("Database connection failed: " . $this->connection->connect_error);
        }
        
        $this->connection->set_charset('utf8mb4');
    }
    
    public function getConnection(): mysqli
    {
        return $this->connection;
    }
    
    public function query(string $sql): \mysqli_result
    {
        $result = $this->connection->query($sql);
        if ($result === false) {
            throw new Exception("Query failed: " . $this->connection->error);
        }
        return $result;
    }
    
    public function prepare(string $sql): \mysqli_stmt
    {
        $stmt = $this->connection->prepare($sql);
        if ($stmt === false) {
            throw new Exception("Prepare failed: " . $this->connection->error);
        }
        return $stmt;
    }
    
    public function escape(string $string): string
    {
        return $this->connection->real_escape_string($string);
    }
} 