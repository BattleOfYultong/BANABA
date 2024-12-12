<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'barangay') {
    header("Location: login.php");
    exit();
}

// Database connection (replace with your own credentials)
$servername = "localhost: 3307"; // Change to your DB host
$username = "root";        // Change to your DB username
$password = "";            // Change to your DB password
$dbname = "barangay_management"; // Change to your DB name

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch the list of barangay officials
$officialsQuery = "SELECT * FROM barangay_officials";
$officialsResult = $conn->query($officialsQuery);

// Handle the form submission for adding a new official
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $position = $_POST['position'];

    // Handle file upload
    $photo = $_FILES['photo']['name'];
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($photo);
    
    // Check if the file is an image
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    $allowed_extensions = ['jpg', 'jpeg', 'png', 'gif'];
    
    if (in_array($imageFileType, $allowed_extensions)) {
        if (move_uploaded_file($_FILES['photo']['tmp_name'], $target_file)) {
            // Insert the new official into the database
            $insertQuery = "INSERT INTO barangay_officials (name, position, photo) VALUES ('$name', '$position', '$photo')";
            if ($conn->query($insertQuery) === TRUE) {
                echo "New official added successfully!";
            } else {
                echo "Error: " . $insertQuery . "<br>" . $conn->error;
            }
        } else {
            echo "Sorry, there was an error uploading the file.";
        }
    } else {
        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Barangay Officials</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

<!-- Sidebar -->
<div id="mySidebar" class="sidebar">
    <button class="closebtn" onclick="closeNav()">&times;</button>
    <a href="#">Dashboard</a>
    <a href="barangay_officials.php">Barangay Officials</a>
    <a href="#">Barangay Staff</a>
    <a href="#">Barangay Residents</a>
    <a href="#">Barangay Services</a>
    <a href="#">Barangay Concerns</a>
    <a href="#">Reports</a>
    <a href="logout.php">Logout</a>
</div>

<!-- Main content -->
<div id="main">
    <button class="openbtn" onclick="openNav()">&#9776;</button>

    <!-- List of Barangay Officials -->
    <h2>Barangay Officials</h2>
    <table>
        <thead>
            <tr>
                <th>Name</th>
                <th>Position</th>
                <th>Photo</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($officialsResult->num_rows > 0) {
                while ($official = $officialsResult->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $official['name'] . "</td>";
                    echo "<td>" . $official['position'] . "</td>";
                    echo "<td><img src='uploads/" . $official['photo'] . "' alt='Photo' width='100' height='100'></td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='3'>No officials found</td></tr>";
            }
            ?>
        </tbody>
    </table>

    <!-- Form to Add New Barangay Official -->
    <h2>Add New Barangay Official</h2>
    <form action="barangay_officials.php" method="POST" enctype="multipart/form-data">
        <label for="name">Name:</label>
        <input type="text" name="name" required><br>

        <label for="position">Position:</label>
        <input type="text" name="position" required><br>

        <label for="photo">Photo:</label>
        <input type="file" name="photo" accept="image/*" required><br>

        <button type="submit">Add Official</button>
    </form>
</div>

<script>
    // Function to open the sidebar
    function openNav() {
        document.getElementById("mySidebar").style.left = "0";
        document.getElementById("main").classList.add("shift");
    }

    // Function to close the sidebar
    function closeNav() {
        document.getElementById("mySidebar").style.left = "-250px";
        document.getElementById("main").classList.remove("shift");
    }
</script>

</body>
<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        font-family: Arial, sans-serif;
        background-color: #f4f4f9;
        margin: 0;
    }

    /* Sidebar styles */
    .sidebar {
        height: 100%;
        width: 250px;
        position: fixed;
        top: 0;
        left: -250px;
        background-color: #003366; /* Dark blue */
        overflow-x: hidden;
        transition: 0.3s;
        padding-top: 20px;
    }

    .sidebar a {
        padding: 15px 25px;
        text-decoration: none;
        font-size: 18px;
        color: white;
        display: block;
        transition: 0.3s;
    }

    .sidebar a:hover {
        color: #f1f1f1;
        background-color: #4c6b8c;
    }

    .openbtn {
        font-size: 20px;
        cursor: pointer;
        background-color: #003366;
        color: white;
        border: none;
        position: fixed;
        top: 20px;
        left: 20px;
        padding: 10px 15px;
    }

    #main {
        padding: 20px;
        margin-left: 0;
        transition: margin-left 0.3s;
    }

    #main.shift {
        margin-left: 250px;
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
        padding: 10px;
        text-align: left;
    }

    th {
        background-color: #f2f2f2;
    }

    form {
        margin-top: 20px;
    }

    form input, form button {
        margin: 10px 0;
        padding: 10px;
        width: 100%;
        box-sizing: border-box;
    }

    form button {
        background-color: #003366;
        color: white;
        cursor: pointer;
    }

    form button:hover {
        background-color: #4c6b8c;
    }
</style>
</html>
