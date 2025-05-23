<?php
// Database configuration constants
define('DB_HOST', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'homedhek_db');

// Create a new MySQLi connection
$conn = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);

// Check connection
if ($conn->connect_error) {
    // Log the error to a file or a logging service in a production environment
    // error_log("Connection failed: " . $conn->connect_error);

    // For development, you can display the error, but this should be disabled in production.
    die("Connection failed: " . $conn->connect_error);
}

// Set character set to utf8mb4 for better Unicode support (optional but recommended)
if (!$conn->set_charset("utf8mb4")) {
    // error_log("Error loading character set utf8mb4: " . $conn->error);
    // For development:
    // printf("Error loading character set utf8mb4: %s\n", $conn->error);
}

// The connection $conn is now ready to be used by other parts of the application.
// For example: include 'config/db.php';
// And then use $conn in your queries.
?>
