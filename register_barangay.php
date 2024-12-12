<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = md5($_POST['password']);
    $barangay_name = $_POST['barangay_name'];
    $contact_number = $_POST['contact_number'];
    $address = $_POST['address'];
    $photo = $_POST['photo']; // Base64 encoded image data

    // Check if the photo is not empty
    if (empty($photo)) {
        echo "Please capture a photo before registering.";
        exit;  // Stop the registration process
    }

    // Insert barangay information
    $barangay_query = "INSERT INTO barangays (barangay_name, contact_number, address) 
                       VALUES (?, ?, ?)";
    $stmt_barangay = $conn->prepare($barangay_query);
    $stmt_barangay->bind_param("sss", $barangay_name, $contact_number, $address);

    if ($stmt_barangay->execute()) {
        // Get the generated barangay ID
        $barangay_id = $stmt_barangay->insert_id;

        // Insert user as barangay official
        $user_query = "INSERT INTO users (name, email, password, role, barangay_id, is_verified, photo) 
                       VALUES (?, ?, ?, 'barangay', ?, 0, ?)";
        $stmt_user = $conn->prepare($user_query);
        $stmt_user->bind_param("sssis", $name, $email, $password, $barangay_id, $photo);

        if ($stmt_user->execute()) {
            echo "Barangay official registration successful. Please wait for admin approval.";
        } else {
            echo "Failed to register barangay official.";
        }
    } else {
        echo "Failed to register barangay.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register as Barangay Official</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f4f7fc;
            margin: 0;
            padding: 0;
        }

        .registration-container {
            background-color: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            max-width: 450px;
            margin: 50px auto;
            text-align: center;
        }

        h2 {
            color: #003366;
            margin-bottom: 20px;
            font-size: 24px;
        }

        h3 {
            color: #003366;
            margin-bottom: 15px;
            font-size: 18px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            color: #003366;
            text-align: left;
        }

        input[type="text"],
        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 12px;
            margin-bottom: 18px;
            border: 1px solid #ddd;
            border-radius: 6px;
            font-size: 14px;
            box-sizing: border-box;
            transition: all 0.3s;
        }

        input[type="text"]:focus,
        input[type="email"]:focus,
        input[type="password"]:focus {
            border-color: #003366;
            outline: none;
        }

        button {
            width: 100%;
            padding: 14px;
            background-color: #003366;
            color: #fff;
            border: none;
            border-radius: 6px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        button:hover {
            background-color: #002244;
        }

        .photo-capture {
            margin-bottom: 20px;
            text-align: center;
        }

        #videoElement {
            width: 100%;
            border-radius: 8px;
            margin-bottom: 15px;
        }

        #capturedImage {
            width: 100%;
            border-radius: 8px;
            margin-top: 15px;
            display: none;
        }

        #captureButton,
        #deleteButton {
            padding: 10px 15px;
            background-color: #003366;
            color: #fff;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 14px;
            transition: background-color 0.3s;
            margin-top: 10px;
        }

        #captureButton:hover,
        #deleteButton:hover {
            background-color: #002244;
        }

        #deleteButton {
            background-color: #d9534f;
        }

        #deleteButton:hover {
            background-color: #c9302c;
        }

        p {
            font-size: 14px;
        }

        a {
            color: #003366;
            text-decoration: none;
            font-weight: 500;
        }

        a:hover {
            text-decoration: underline;
        }

        /* Responsive Design */
        @media (max-width: 600px) {
            .registration-container {
                padding: 20px;
                width: 90%;
            }

            h2 {
                font-size: 20px;
            }

            h3 {
                font-size: 16px;
            }
        }
    </style>
</head>
<body>
    <div class="registration-container">
        <form method="POST" enctype="multipart/form-data" id="registrationForm">
            <h2>Barangay Official Registration</h2>
            
            <label for="name">Full Name:</label>
            <input type="text" name="name" required>

            <label for="email">Email:</label>
            <input type="email" name="email" required>

            <label for="password">Password:</label>
            <input type="password" name="password" required>

            <h3>Barangay Information</h3>
            <label for="barangay_name">Barangay Name:</label>
            <input type="text" name="barangay_name" required>

            <label for="contact_number">Contact Number:</label>
            <input type="text" name="contact_number" required>

            <label for="address">Address:</label>
            <input type="text" name="address" required>

            <div class="photo-capture">
                <label for="photo">Capture your photo:</label>
                <video id="videoElement" autoplay></video>
                <button type="button" id="captureButton">Capture Photo</button>
                <canvas id="canvas" style="display:none;"></canvas><br>
                <img id="capturedImage" alt="Captured Image"/>
                <button type="button" id="deleteButton" style="display:none;">Delete Photo</button><br>
                <!-- Hidden field to store the photo -->
                <input type="hidden" name="photo" id="photo">
            </div>

            <button type="submit">Register</button>
            <p><a href="login.php">Back to Login</a></p>
        </form>
    </div>

    <script>
        const video = document.getElementById('videoElement');
        const captureButton = document.getElementById('captureButton');
        const deleteButton = document.getElementById('deleteButton');
        const canvas = document.getElementById('canvas');
        const capturedImage = document.getElementById('capturedImage');
        const photoInput = document.getElementById('photo');
        const registrationForm = document.getElementById('registrationForm');

        // Start video stream
        navigator.mediaDevices.getUserMedia({ video: true })
            .then(function(stream) {
                video.srcObject = stream;
            })
            .catch(function(err) {
                console.log("Error accessing webcam: " + err);
            });

        // Capture photo
        captureButton.addEventListener('click', function() {
            const context = canvas.getContext('2d');
            context.drawImage(video, 0, 0, canvas.width, canvas.height);
            const imageData = canvas.toDataURL('image/png');
            capturedImage.src = imageData;
            capturedImage.style.display = 'block';
            photoInput.value = imageData;
            deleteButton.style.display = 'inline-block';
        });

        // Delete captured photo
        deleteButton.addEventListener('click', function() {
            capturedImage.style.display = 'none';
            photoInput.value = '';
            deleteButton.style.display = 'none';
        });

        // Prevent form submission if no photo has been captured
        registrationForm.addEventListener('submit', function(event) {
            if (!photoInput.value) {
                alert("Please capture a photo before submitting the form.");
                event.preventDefault();
            }
        });
    </script>
</body>
</html>
