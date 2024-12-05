<?php
// db.php: Database connection file using PDO

// Database configuration
$host = 'localhost'; // Database host (typically 'localhost' for local servers)
$dbname = 'furniture_store'; // Database name
$username = 'root'; // Database username (replace with your actual DB username)
$password = ''; // Database password (replace with your actual DB password)

// Set the DSN (Data Source Name) string
$dsn = "mysql:host=$host;dbname=$dbname;charset=utf8";

// Set PDO options (to throw exceptions on error)
$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, // Enable exceptions on errors
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, // Default fetch mode (associative array)
    PDO::ATTR_EMULATE_PREPARES => false, // Disable emulated prepared statements
];

try {
    // Create a new PDO instance and connect to the database
    $pdo = new PDO($dsn, $username, $password, $options);
    // Optional: If you want to check connection success
    // echo "Connected to the database successfully!";
} catch (PDOException $e) {
    // Handle any connection errors
    echo "Connection failed: " . $e->getMessage();
    exit; // Stop execution if the connection fails
}
?>
