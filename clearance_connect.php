<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "barangay_management"; // Update with your database name

// Create connection
$con = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
