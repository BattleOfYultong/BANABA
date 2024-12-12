<?php
session_start(); 

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "barangay_management";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$complainant_name = $_POST['complainant_name'];
$complainant_address = $_POST['complainant_address'];
$respondent_name = $_POST['respondent_name'];
$respondent_address = $_POST['respondent_address'];
$witnesses = $_POST['witnesses'];
$incident_date = $_POST['incident_date'];
$incident_time = $_POST['incident_time'];
$incident_location = $_POST['incident_location'];
$incident_details = $_POST['incident_details'];
$resident_type = $_POST['resident_type'];
$status = $_POST['status'];

$complainant_name = $conn->real_escape_string($complainant_name);
$complainant_address = $conn->real_escape_string($complainant_address);
$respondent_name = $conn->real_escape_string($respondent_name);
$respondent_address = $conn->real_escape_string($respondent_address);
$witnesses = $conn->real_escape_string($witnesses);
$incident_date = $conn->real_escape_string($incident_date);
$incident_time = $conn->real_escape_string($incident_time);
$incident_location = $conn->real_escape_string($incident_location);
$incident_details = $conn->real_escape_string($incident_details);
$resident_type = $conn->real_escape_string($resident_type);
$status = $conn->real_escape_string($status);

$sql = "INSERT INTO blotter_reports (
            complainant_name, complainant_address, respondent_name, respondent_address, witnesses, 
            incident_date, incident_time, incident_location, incident_details, resident_type, status
        ) VALUES (
            '$complainant_name', '$complainant_address', '$respondent_name', '$respondent_address', '$witnesses',
            '$incident_date', '$incident_time', '$incident_location', '$incident_details', '$resident_type', '$status'
        )";

if ($conn->query($sql) === TRUE) {
    
    $_SESSION['notification'] = "Blotter report submitted successfully!";
} else {
    
    $_SESSION['notification'] = "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();

header("Location: blotter_form.php");
exit;
?>