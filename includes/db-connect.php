<?php
// MedFinder Ethiopia - Database Connection
// Establishes MySQLi connection with error handling

require_once __DIR__ . '/config.php';

// Enable MySQLi error reporting
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

try {
    $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    
    // Check connection
    if ($conn->connect_error) {
        throw new Exception("Connection failed: " . $conn->connect_error);
    }
    
    // Set charset to UTF-8
    $conn->set_charset("utf8mb4");
    
} catch (Exception $e) {
    // Log error and display user-friendly message
    error_log("Database connection error: " . $e->getMessage());
    die("Database connection failed. Please try again later or contact support.");
}
