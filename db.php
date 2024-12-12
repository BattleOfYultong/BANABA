<?php
$host = 'localhost';
$user = 'root';
$password = '';
$database = 'barangay_management';

$conn = new mysqli($host, $user, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$host = 'localhost'; // Database host
$dbname = 'barangay_management'; // Database name
$username = 'root'; // Database username
$password = ''; // Database password (leave empty for XAMPP default)

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}


?>
