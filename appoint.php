<?php
session_start();
include 'db.php';  // Include your database connection

// Check if the admin is logged in
if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php"); // Redirect to login if not logged in
    exit();
}

// Approve or Reject an appointment
if (isset($_GET['action']) && isset($_GET['appointment_id'])) {
    $appointment_id = $_GET['appointment_id'];
    $action = $_GET['action'];  // 'approve' or 'reject'

    if ($action == 'approve') {
        // Approve the appointment
        $query = "UPDATE blotter_appointments SET status = 'Approved' WHERE id = ?";
    } elseif ($action == 'reject') {
        // Reject the appointment by deleting the record
        $query = "DELETE FROM blotter_appointments WHERE id = ?";
    }

    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $appointment_id);
    $stmt->execute();
    
    // Redirect back to the dashboard after approval or rejection
    header("Location: admin_dashboard.php");
    exit();
}

// Fetch pending appointments
$query = "SELECT * FROM blotter_reports WHERE status = 'Pending'";
$stmt = $conn->prepare($query);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

<h2>Admin Dashboard - Blotter Appointment Requests</h2>

<table>
    <thead>
        <tr>
            <th>Name</th>
            <th>Appointment Date</th>
            <th>Appointment Time</th>
            <th>Reason</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($appointment = $result->fetch_assoc()): ?>
            <tr>
                <td><?php echo htmlspecialchars($appointment['complainant_name']); ?></td>
                <td><?php echo htmlspecialchars($appointment['incident_date']); ?></td>
                <td><?php echo htmlspecialchars($appointment['incident_time']); ?></td>
                <td><?php echo htmlspecialchars($appointment['incident_details']); ?></td>
                <td class="action-buttons">
                    <a href="admin_dashboard.php?action=approve&appointment_id=<?php echo $appointment['id']; ?>" class="approve">Approve</a>
                    <a href="admin_dashboard.php?action=reject&appointment_id=<?php echo $appointment['id']; ?>" class="reject">Reject</a>
                </td>
            </tr>
        <?php endwhile; ?>
    </tbody>
</table>

</body>
</html>
