<?php
/*
Author: Akshaya Bhandare 
Page: Db connection common Page
Date Created: 19th April 2025
*/

// Server connection details
$host = "localhost";
$dbname = "wb_db";
$username = "root";
$password = "";

try {
    // Used php data object to get the connection with predefined object keys
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
} catch (PDOException $e) {
    // Error handling by php data object
    die("DB Connection failed: " . $e->getMessage());
}
?>