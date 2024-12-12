<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "barangay_management";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$id = $_POST['id'];
$status = $_POST['status'];

$sql = "UPDATE blotter_reports SET status = ? WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('si', $status, $id);

if ($stmt->execute()) {
    echo "Blotter status updated successfully.";
} else {
    echo "Error updating status: " . $conn->error;
}

$stmt->close();
$conn->close();
?>
