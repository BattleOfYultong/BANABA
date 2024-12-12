<?php
session_start();
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Query to check if the user is an admin
    $query = "SELECT * FROM users WHERE email = ? AND role = 'admin'";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $admin = $result->fetch_assoc();

    if ($admin && md5($password) === $admin['password']) {
        // Store admin details in session
        $_SESSION['admin_id'] = $admin['user_id'];
        header("Location: admin_dashboard.php");
        exit();
    } else {
        $error = "Invalid email or password.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <form method="POST">
        <h2>Admin Login</h2>
        <?php if (!empty($error)) echo "<p>$error</p>"; ?>
        
        <div class="input-group">
    <label for="email"><i class="fas fa-envelope"></i> Email:</label>
    <input type="email" name="email" required>
</div>

<div class="input-group">
    <label for="password"><i class="fas fa-lock"></i> Password:</label>
    <input type="password" name="password" required>
</div>
        
        <button type="submit">Login</button>
    </form>
</body>
<style>
 body {
    
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f7fc;
            background: url(brgys.jpg) no-repeat center center / cover;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        form {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            padding: 20px 30px;
            width: 100%;
            max-width: 400px;
        }

        h2 {
            text-align: center;
            color: #333;
        }

        label {
            display: block;
            margin-bottom: 8px;
            color: #555;
            font-weight: bold;
        }

        input[type="email"], input[type="password"] {
            width: 95%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 16px;
        }

        button {
            width: 100%;
            padding: 10px;
            background-color: darkblue;
            color: #fff;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        button:hover {
            background-color: lightblue;
        }

        p {
            color: red;
            text-align: center;
        }

        @media (max-width: 500px) {
            form {
                padding: 15px;
            }
        }
        
    </style>
</html>
