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
        error_log("DatabaseConnection class instantiated: " . __CLASS__);
        error_log("Attempting database connection with config: " . print_r([
            'server' => $config['server'],
            'user' => $config['user'],
            'name' => $config['name']
        ], true));
        
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
            error_log("Database connection failed: " . $this->connection->connect_error);
            throw new Exception("Database connection failed: " . $this->connection->connect_error);
        }
        
        error_log("Database connection successful");
        $this->connection->set_charset('utf8mb4');
    }
    
    public function getConnection(): mysqli
    {
        return $this->connection;
    }
    
    public function query(string $sql): \mysqli_result
    {
        error_log("Executing query: " . $sql);
        $result = $this->connection->query($sql);
        if ($result === false) {
            error_log("Query failed: " . $this->connection->error);
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
    
    public function get_num_rows($result): int {
        if ($result instanceof \mysqli_result) {
            return mysqli_num_rows($result);
        }
        return 0; // Return 0 if the result is not valid
    }
    
    public function free_result($result): void {
        if ($result instanceof \mysqli_result) {
            mysqli_free_result($result);
        }
    }

    public function error()
    {
        return $this->connection->error;
    }
} 