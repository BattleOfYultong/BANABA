<?php
session_start();
include 'db.php';  // Include your database connection

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'phpmailer/src/Exception.php';
require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';

// Check if the admin is logged in
if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php"); // Redirect to login if not logged in
    exit();
}

// Approve or Reject a user's registration
if (isset($_GET['action']) && isset($_GET['user_id'])) {
    $user_id = $_GET['user_id'];
    $action = $_GET['action'];  // 'approve' or 'reject'

    $getEmail = "SELECT email FROM users WHERE user_id = $user_id";
    $getEmailResult = mysqli_query($conn, $getEmail);

    if($getEmailResult){
        if(mysqli_num_rows($getEmailResult) > 0){
            $row = mysqli_fetch_assoc($getEmailResult);
            $email = $row['email'];
        }
    }
    else{
        echo 'Email not found';
    }

    if ($action == 'approve') {
        $query = "UPDATE users SET is_verified = 1 WHERE user_id = ?";
        // for emailer //
        $mail = new PHPMailer(true);
            try {
                //Server settings
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = 'managementbarangay@gmail.com'; // Your Gmail email address
                $mail->Password = 'jrzavowajeuogevp'; // Your Gmail password
                $mail->SMTPSecure = 'tls';
                $mail->Port = 587;

                //Recipients
                $mail->setFrom('managementbarangay@gmail.com', 'Barangay Management System');
                $mail->addAddress($email); // Use the found email address
                $mail->addReplyTo('managementbarangay@gmail.com', 'Barangay Management System');

                //Content
                $mail->isHTML(true);
                $mail->Subject = 'Account Verified';
                $mail->Body = 'Your Account Has Been Successfully Verified';
                $mail->send();
            } catch (Exception $e) {
                $error = "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            } 

        
    } elseif ($action == 'reject') {
        // Reject the user registration by deleting the record
        $query = "DELETE FROM users WHERE user_id = ?";
    }

    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    
    // Redirect back to the dashboard after approval or rejection
    header("Location: admin_dashboard.php");
    exit();
}

// Fetch unverified residents and barangay officials
$query = "SELECT * FROM users WHERE is_verified = 0 AND role IN ('resident', 'barangay')";
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
            display: flex;
            flex-direction: column;
            height: 100vh;
        }

        /* Top Navigation Bar */
        .top-nav {
            background-color: #003366;
            color: white;
            padding: 45px 0px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: fixed;
            width: 100%;
            top: 0;
            z-index: 1000;
        }

        .top-nav .logo {
            font-size: 24px;
            font-weight: bold;
        }

        .top-nav .user-actions a {
            color: white;
            text-decoration: none;
            margin: 0 10px;
        }

        /* Dashboard container */
        .dashboard-container {
            width: 80%;
            margin: 180px auto 20px;  /* Adjusted to account for top nav */
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            overflow-y: auto;
        }

        h2 {
            color: #003366;
            margin-bottom: 20px;
            text-align: center;
        }

        table {
            width: 100%;
            margin-top: 20px;
            border-collapse: collapse;
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            padding: 12px;
            text-align: left;
        }

        th {
            background-color: #003366;
            color: white;
        }

        .action-buttons a {
            padding: 5px 10px;
            color: white;
            text-decoration: none;
            border-radius: 4px;
            margin: 0 5px;
            font-size: 14px;
        }

        .approve {
            background-color: #4CAF50;
        }

        .approve:hover {
            background-color: #45a049;
        }

        .reject {
            background-color: #f44336;
        }

        .reject:hover {
            background-color: #e53935;
        }

        .action-buttons i {
            margin-right: 5px; /* Space between the icon and text */
        }

        /* Responsive design for smaller screens */
        @media (max-width: 768px) {
            .top-nav {
                flex-direction: column;
                align-items: flex-start;
                padding: 20px;
            }

            .dashboard-container {
                width: 90%;
                margin: 120px auto 20px;
            }

            .action-buttons a {
                font-size: 12px;
                padding: 4px 8px;
            }
        }
    </style>
</head>
<body>

    <div class="top-nav">
    <div class="logo">Admin Panel</div>
<div class="user-actions">
    <a href="admin_dashboard.php"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
    <a href="admin_announcements.php"><i class="fas fa-bullhorn"></i> Announcements</a>
    <a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
</div>

        </div>
    </div>

    <!-- Dashboard Container -->
    <div class="dashboard-container">
        <h2>Admin Dashboard</h2>
        <p>Welcome, Admin. Here you can approve or reject user registrations.</p>
        
        <table>
            <thead>
                <tr>
                <th><i class="fas fa-user"></i> Name</th>
                    <th><i class="fas fa-id-badge"></i> Role</th>
                    <th><i class="fas fa-cogs"></i> Action</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($user = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($user['name']); ?></td>
                        <td><?php echo htmlspecialchars($user['role']); ?></td>
                        <td class="action-buttons">
                            <a href="admin_dashboard.php?action=approve&user_id=<?php echo $user['user_id']; ?>" class="approve">
                                <i class="fas fa-check-circle"></i>Approve
                            </a>
                            <a href="admin_dashboard.php?action=reject&user_id=<?php echo $user['user_id']; ?>" class="reject">
                                <i class="fas fa-times-circle"></i>Reject
                            </a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

</body>
</html>
