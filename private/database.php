<?php

require_once('db_credentials.php');

function db_connect()
{
    try {
        $connection = new mysqli(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
        if ($connection->connect_error) {
            throw new Exception("Database connection failed: " . $connection->connect_error);
        }
        return $connection;
    } catch (Exception $e) {
        // Optionally log $e->getMessage() to a log file
        exit('Database connection failed. Please try again later.');
    }
}

function db_disconnect($connection)
{
    if (isset($connection)) {
        $connection->close();
    }
}

function db_escape($connection, $string)
{
    return $connection->real_escape_string($string);
}

// This function is no longer needed if exceptions are used in db_connect()
// function confirm_db_connect() { }

function confirm_result_set($result_set)
{
    if (!$result_set) {
        exit("Database query failed.");
    }
}

?>
