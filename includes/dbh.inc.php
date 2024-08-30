<?php
define('HOSTNAME', 'localhost');
define('USERNAME', 'root');
define('PASSWORD', '');
define('DB_NAME', 'kidsgames');

// Function to connect to MySQL and create database structure if it doesn't exist
function connectToDB()
{
    try {
        // Connect to MySQL
        $conn = new mysqli(HOSTNAME, USERNAME, PASSWORD);

        // Check connection
        if ($conn->connect_error) {
            throw new Exception("Connection to MySQL failed: " . $conn->connect_error);
        }

        // Create database if it doesn't exist
        $createDBQuery = "CREATE DATABASE IF NOT EXISTS " . DB_NAME;
        if ($conn->query($createDBQuery) === FALSE) {
            throw new Exception("Failed to create database: " . $conn->error);
        }

        // Select the database
        $conn->select_db(DB_NAME);

        // Check if the database structure exists
        $result = $conn->query("SHOW TABLES LIKE 'player'");
        if ($result->num_rows == 0) {
            // If database structure doesn't exist, create it
            createDBStructureFromSQLFile($conn, "./dbh/db_structure.sql");
        }

        return $conn;
    } catch (Exception $error) {
        die($error->getMessage());
    }
}

function createDBStructureFromSQLFile($conn, $fileName)
{
    try {
        $sql = file_get_contents($fileName);
        if ($conn->multi_query($sql) === FALSE) {
            throw new Exception("Error creating database structure: " . $conn->error);
        }

        // Iterate over each result set to consume them and free the memory
        while ($conn->more_results() && $conn->next_result()) {
            $result = $conn->use_result();
            if ($result instanceof mysqli_result) {
                $result->free();
            }
        }
    } catch (Exception $error) {
        die($error->getMessage());
    }
}

$conn = connectToDB(); // $conn exception solved