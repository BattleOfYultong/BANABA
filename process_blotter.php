<?php
include 'db.php'; // Include database connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect form data
    $complainant = $_POST['complainant'];
    $complainant_contact = $_POST['complainant_contact'];
    $complainant_address = $_POST['complainant_address'];
    $respondent = $_POST['respondent'];
    $respondent_contact = $_POST['respondent_contact'] ?? null;
    $respondent_address = $_POST['respondent_address'] ?? null;
    $details = $_POST['details'];
    $incident_date = $_POST['incident_date'];
    $incident_time = $_POST['incident_time'];
    $incident_location = $_POST['incident_location'];
    $witness_name = $_POST['witness_name'] ?? null;
    $witness_contact = $_POST['witness_contact'] ?? null;
    $witness_statement = $_POST['witness_statement'] ?? null;

    // Prepare SQL query
    $sql = "INSERT INTO blotter_reports (
                complainant_name, complainant_contact, complainant_address, 
                respondent_name, respondent_contact, respondent_address, 
                complaint_details, incident_date, incident_time, incident_location, 
                witness_name, witness_contact, witness_statement
            ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param(
        "sssssssssssss",
        $complainant,
        $complainant_contact,
        $complainant_address,
        $respondent,
        $respondent_contact,
        $respondent_address,
        $details,
        $incident_date,
        $incident_time,
        $incident_location,
        $witness_name,
        $witness_contact,
        $witness_statement
    );

    // Execute query and check for success
    if ($stmt->execute()) {
        echo "Blotter report submitted successfully!";
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close connections
    $stmt->close();
    $conn->close();
} else {
    echo "Invalid request.";
}
?>
