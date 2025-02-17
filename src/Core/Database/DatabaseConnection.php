<?php
declare(strict_types=1);

namespace Fivetwofive\KrateCMS\Core\Database;

use mysqli;
use Exception;

class DatabaseConnection
{
    private mysqli $connection;
    
    // Constructor to initialize the database connection using the provided configuration

    /**
     * @throws Exception
     */
    public function __construct(array $config)
    {
        // Log the instantiation of the DatabaseConnection class
        error_log("DatabaseConnection class instantiated: " . __CLASS__);
        error_log("Attempting database connection with config: " . print_r([
            'server' => $config['server'],
            'user' => $config['user'],
            'name' => $config['name']
        ], true));
        
        $this->connect($config);
    }
    
    // Establish a connection to the database
    private function connect(array $config): void
    {
        // Create a new mysqli connection
        $this->connection = new mysqli(
            $config['server'],
            $config['user'],
            $config['pass'],
            $config['name']
        );
        
        // Check for connection errors
        if ($this->connection->connect_errno) {
            // Log the connection error and throw an exception
            error_log("Database connection failed: " . $this->connection->connect_error);
            throw new Exception("Database connection failed: " . $this->connection->connect_error);
        }
        
        // Set the character set for the connection
        error_log("Database connection successful");
        $this->connection->set_charset('utf8mb4');
    }
    
    // Get the current database connection
    public function getConnection(): mysqli
    {
        return $this->connection;
    }
    
    /**
     * Execute a SQL query and return the result
     * 
     * @param string $sql The SQL query to execute
     * @return \mysqli_result The result of the query
     * @throws Exception if the query fails
     */
    public function query(string $sql): \mysqli_result
    {
        // Log the query execution
        error_log("Executing query: " . $sql);
        $result = $this->connection->query($sql);
        if ($result === false) {
            error_log("Query failed: " . $this->connection->error);
            throw new Exception("Query failed: " . $this->connection->error);
        }
        return $result;
    }
    
    /**
     * Prepare a SQL statement for execution
     * 
     * @param string $sql The SQL statement to prepare
     * @return \mysqli_stmt The prepared statement
     * @throws Exception if preparation fails
     */
    public function prepare(string $sql): \mysqli_stmt
    {
        // Prepare the SQL statement
        $stmt = $this->connection->prepare($sql);
        if ($stmt === false) {
            throw new Exception("Prepare failed: " . $this->connection->error);
        }
        return $stmt;
    }
    
    /**
     * Escape a string for safe use in a SQL query
     * 
     * @param string $string The string to escape
     * @return string The escaped string
     */
    public function escape(string $string): string
    {
        return $this->connection->real_escape_string($string);
    }
    
    /**
     * Get the number of rows in a result set
     * 
     * @param mixed $result The result set to check
     * @return int The number of rows, or 0 if the result is invalid
     */
    public function get_num_rows($result): int {
        // Check if the result is a valid mysqli_result instance
        if ($result instanceof \mysqli_result) {
            return mysqli_num_rows($result);
        }
        return 0; // Return 0 if the result is not valid
    }
    
    /**
     * Free the memory associated with a result set
     * 
     * @param mixed $result The result set to free
     */
    public function free_result($result): void {
        // Free the result if it is a valid mysqli_result instance
        if ($result instanceof \mysqli_result) {
            mysqli_free_result($result);
        }
    }

    // Get the last error message from the connection
    public function error()
    {
        return $this->connection->error;
    }

    public function num_rows($result): int
    {
        return mysqli_num_rows($result); // Assuming you're using MySQLi
    }
} 