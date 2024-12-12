<?php

include_once 'db.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'phpmailer/src/Exception.php';
require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';

if($_SERVER['REQUEST_METHOD'] == 'GET'){
    if(isset($_GET['clearance_id'])){
        $id = $_GET['clearance_id'];

        $sql = "SELECT *FROM barangay_clearance WHERE id = $id";
        $result = mysqli_query($conn, $sql);

        if($result){
            if(mysqli_num_rows($result) > 0){
                $row = mysqli_fetch_assoc($result);
                $email = $row['email'];
            }
        }

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
                $mail->Subject = 'Clearance And Permit Ready To Pick Up';
                $mail->Body = 'Your Clearance Or Permit Are Ready To Pick Up Proceed  To Barangay Hall For Immediate Actions';
                $mail->send();
                header("Location: view_clearance.php");
            } catch (Exception $e) {
                $error = "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            } 

    }
}

