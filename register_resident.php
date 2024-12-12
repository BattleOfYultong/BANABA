<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = md5($_POST['password']);
    $valid_id_type = $_POST['valid_id_type'];
    $valid_id_number = $_POST['valid_id_number'];
    $barangay_id = $_POST['barangay_id'];
    $photo = $_POST['photo']; // Base64 encoded image data

    // Check if the photo is not empty
    if (empty($photo)) {
        echo "Please capture a photo before registering.";
        exit;  // Stop the registration process
    }

    $query = "INSERT INTO users (name, email, password, role, valid_id_type, valid_id_number, barangay_id, is_verified, photo) 
              VALUES (?, ?, ?, 'resident', ?, ?, ?, 0, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sssssis", $name, $email, $password, $valid_id_type, $valid_id_number, $barangay_id, $photo);

    if ($stmt->execute()) {
        echo "Registration successful. Please wait for admin approval.";
    } else {
        echo "Registration failed.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register as Resident</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f7fc;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        .registration-container {
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            padding: 40px;
            width: 400px;
            text-align: center;
            box-sizing: border-box;
        }

        h2 {
            color: #003366;
            margin-bottom: 25px;
            font-size: 24px;
        }

        label {
            display: block;
            margin: 10px 0 5px;
            font-size: 14px;
            color: #333;
        }

        input[type="text"],
        input[type="email"],
        input[type="password"],
        input[type="number"] {
            width: 100%;
            padding: 12px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 14px;
            box-sizing: border-box;
        }

        button {
            width: 100%;
            padding: 14px;
            background-color: #003366;
            color: white;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        button:hover {
            background-color: #002244;
        }

        button:disabled {
            background-color: #cccccc;
            cursor: not-allowed;
        }

        #videoElement {
            width: 100%;
            border-radius: 8px;
            border: 1px solid #ddd;
            margin-bottom: 20px;
        }

        #capturedImage {
            width: 100%;
            border-radius: 8px;
            margin-top: 10px;
            display: none;
        }

        #captureButton,
        #deleteButton {
            width: 100%;
            padding: 10px;
            background-color: #003366;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            margin-top: 10px;
            transition: background-color 0.3s;
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

        .form-footer {
            margin-top: 20px;
            font-size: 14px;
        }

        .form-footer a {
            color: #003366;
            text-decoration: none;
        }

        .form-footer a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="registration-container">
        <form method="POST" enctype="multipart/form-data" id="registrationForm">
            <h2>Resident Registration</h2>
            
            <label for="name">Full Name:</label>
            <input type="text" name="name" required>

            <label for="email">Email:</label>
            <input type="email" name="email" required>

            <label for="password">Password:</label>
            <input type="password" name="password" required>

            <label for="barangay_id">Barangay ID:</label>
            <input type="text" name="barangay_id" required>

            <label for="valid_id_type">Valid ID Type:</label>
            <input type="text" name="valid_id_type" required>

            <label for="valid_id_number">Valid ID Number:</label>
            <input type="text" name="valid_id_number" required>



            <!-- Camera Capture Section -->
            <label for="photo">Capture your photo:</label>
            <video id="videoElement" autoplay></video>
            <button type="button" id="captureButton">Capture Photo</button>
            <canvas id="canvas" style="display:none;"></canvas><br>
            <img id="capturedImage" alt="Captured Image"/>
            <button type="button" id="deleteButton" style="display:none;">Delete Photo</button><br>

            <!-- Hidden field to store the photo -->
            <input type="hidden" name="photo" id="photo">

            <button type="submit">Register</button>

            <div class="form-footer">
                <p><a href="login.php">Back to Login</a></p>
            </div>
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
