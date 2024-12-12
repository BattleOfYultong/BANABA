<?php
session_start();
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $query = "SELECT * FROM users WHERE email = ? AND is_verified = 1";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user && md5($password) === $user['password']) {
        $_SESSION['user_id'] = $user['user_id'];
        $_SESSION['role'] = $user['role'];

        if ($user['role'] === 'resident') {
            header("Location: resident_dashboard.php");
        } elseif ($user['role'] === 'barangay') {
            header("Location: barangay_dashboard.php");
        } else {
            header("Location: admin_dashboard.php");
        }
        exit();
    } else {
        $error = "Invalid credentials or account not verified.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        /* Reset and basic styles */
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

        /* Centered login container */
        .login-container {
            background-color: #ffffff;
            padding: 40px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
            text-align: center;
        }

        h2 {
            color: #003366;
            margin-bottom: 20px;
            font-size: 24px;
        }

        label {
            display: block;
            font-size: 14px;
            margin-bottom: 8px;
            text-align: left;
            color: #003366;
        }

        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 12px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 14px;
            box-sizing: border-box;
            transition: border-color 0.3s;
        }

        input[type="email"]:focus,
        input[type="password"]:focus {
            border-color: #003366;
        }

        button {
            width: 100%;
            padding: 12px;
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

        .error {
            color: #f44336;
            font-size: 14px;
            margin-bottom: 10px;
        }

        p {
            font-size: 14px;
            color: #666;
        }

        a {
            color: #003366;
            text-decoration: none;
            transition: text-decoration 0.3s;
        }

        a:hover {
            text-decoration: underline;
        }

        /* Responsive Design */
        @media (max-width: 480px) {
            .login-container {
                padding: 20px;
                width: 90%;
            }

            h2 {
                font-size: 20px;
            }
        }
    </style>
</head>
<body>
    <div class="login-container">
        <form method="POST">
            <h2>Login</h2>
            <?php if (!empty($error)) echo "<p class='error'>$error</p>"; ?>
            
            <label for="email">Email:</label>
            <input type="email" name="email" required>
            
            <label for="password">Password:</label>
            <input type="password" name="password" required>
            
            <button type="submit">Login</button>
            
            <p>
                <a href="register_resident.php">Register as Resident</a> |
                <a href="register_barangay.php">Register as Barangay Official</a>
            </p>
        </form>
    </div>
</body>
</html>
