<?php
// Enable error reporting for development
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Database configuration
$host = "localhost";
$user = "root";       // XAMPP default username
$password = "";       // XAMPP default password (empty)
$dbname = "online_store";

// Create database connection
$conn = new mysqli($host, $user, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}

// Set charset to UTF-8
$conn->set_charset("utf8mb4");

// Security recommendations note:
// 1. In production, move credentials to environment variables
// 2. Use limited-privilege database user
// 3. Disable error displaying in production (ini_set('display_errors', 0))
// 4. Implement proper error logging
