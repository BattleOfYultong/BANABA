<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "barangay_management";


use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'phpmailer/src/Exception.php';
require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';


$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$id = $_POST['id'];
$status = $_POST['status'];

$sql = "UPDATE blotter_reports SET status = ? WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('si', $status, $id);

$sqlfetchEmail = "SELECT *FROM blotter_reports WHERE id = $id";
$sqlfetchResult = mysqli_query($conn, $sqlfetchEmail);


if($sqlfetchResult){
    if(mysqli_num_rows($sqlfetchResult) > 0){
        $row = mysqli_fetch_assoc($sqlfetchResult);
        $email = $row['email'];
    }
}
if ($stmt->execute()) {
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
                $mail->Subject = 'Blotter Report';
                $mail->Body = 'proceed  to barangay hall for immediate actions';
                $mail->send();
            } catch (Exception $e) {
                $error = "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            } 
    echo "Blotter status updated successfully.";
} else {
    echo "Error updating status: " . $conn->error;
}

$stmt->close();
$conn->close();
?>
