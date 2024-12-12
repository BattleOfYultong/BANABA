<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'barangay') {
    header("Location: login.php");
    exit();
}

// Database connection (must be included or initialized before any queries)
$servername = "localhost";
$username = "root"; // your db username
$password = ""; // your db password
$dbname = "barangay_management"; // your database name

// Create connection
$con = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}

// Query to count users with the 'resident' role
$users_sql = "SELECT COUNT(*) AS count FROM users WHERE role = 'resident'";  // Corrected SQL query
$users_result = mysqli_query($con, $users_sql); // Using $con here
$users_row = mysqli_fetch_assoc($users_result);
$usersCount = $users_row['count']; // Store the count of residents



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Barangay Dashboard</title>
    <link rel="stylesheet" href="styles.css">
    <!-- Font Awesome CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>

<div class="navbar">
    <div class="navbar-content">
        <h1>Barangay Dashboard</h1>
    </div>
</div>


<div class="container mt-5">
        <div class="row">
            <div class="col-md-3">
                <div class="card1 bg-primary text-white">
                    <div class="card-body">
                    <h3><?php echo $usersCount; ?></h3>
                        <p>Resident</p>
                    </div>
                </div>
            </div>

<!-- Sidebar -->
<div id="mySidebar" class="sidebar">
    <button class="closebtn" onclick="closeNav()">&times;</button>
    <a href="barangay_dashboard.php"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
    <a href="barangay_officials.php"><i class="fas fa-users"></i> Barangay Officials</a>
    <a href="resident_list.php"><i class="fas fa-users"></i> Barangay Residents</a>
    
    <!-- Barangay Services Dropdown -->
    <a href="javascript:void(0);" class="dropdown-btn"><i class="fas fa-cogs"></i> Barangay Services</a>
    <div class="dropdown-container">
        <a href="blotter_report_list.php"><i class="fas fa-clipboard-list"></i> Blotter List</a>
        <a href="view_clearance.php"><i class="fas fa-hands-helping"></i> Clearance List</a>
        <a href="#"><i class="fas fa-gavel"></i> Business Permit List</a>
    </div>
    
    <a href="concern_list.php"><i class="fas fa-clipboard"></i> Barangay Concerns</a>
    <a href="#"><i class="fas fa-chart-line"></i> Reports</a>
    <a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
</div>

<!-- Main content -->
<div id="main">
    <button class="openbtn" onclick="openNav()">&#9776;</button>
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

    // Toggle the dropdown on click
    document.querySelector('.dropdown-btn').addEventListener('click', function() {
        var dropdown = document.querySelector('.dropdown-container');
        dropdown.style.display = (dropdown.style.display === 'block') ? 'none' : 'block';
    });
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
    .navbar {
        width: 100%;
        height: 130px; /* 1 inch height (approximately 60px) */
        background-color: #003366;
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        position: fixed;
        top: 0;
        left: 0;
        z-index: 1001;
    }

    .navbar-content h1 {
        margin: 0;
        font-size: 24px;
    }
    .container {
            max-width: 1200px;
            margin: 20px auto;
            padding: 10px;
            margin-top: -150px;
        }
        .row {
            display: flex;
            flex-wrap: wrap;
            gap: 95px;
            justify-content: space-around;
            margin-top: 300px;
        }
        
        .card1 {
            background-color: #555;
            line-height: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            text-align: center;
            padding: 20px;
            width: 22%; 
            min-width: 200px;
            color: white;
             
        }

    /* Sidebar styles */
    .sidebar {
        height: 100%;
        width: 250px;
        position: fixed;
        top: 0;
        left: -250px;
        background-color: #003366;
        overflow-x: hidden;
        transition: 0.3s;
        padding-top: 20px;
        z-index: 1000;
        margin-top: 130px;
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
        background-color: #575757;
    }

    /* Icons */
    .sidebar a i {
        margin-right: 10px;
    }

    .sidebar .closebtn {
        position: absolute;
        top: 10px;
        right: 25px;
        font-size: 36px;
        color: white;
        background: none;
        border: none;
        cursor: pointer;
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
        margin-top: 120px;
    }

    #main {
        padding: 20px;
        margin-left: 0;
        transition: margin-left 0.3s;
    }

    #main.shift {
        margin-left: 250px;
    }

    /* Dropdown Button */
    .dropdown-btn {
        background-color: #003366;
        color: white;
        padding: 15px 25px;
        text-decoration: none;
        font-size: 18px;
        display: block;
        transition: 0.3s;
        border: none;
        width: 100%;
        text-align: left;
    }

    /* Container for the dropdown menu */
    .dropdown-container {
        display: none;
        background-color: #003366;
        padding-left: 30px;
    }

    /* Dropdown links */
    .dropdown-container a {
        padding: 12px 16px;
        text-decoration: none;
        font-size: 16px;
        color: white;
        display: block;
        transition: 0.3s;
    }

    /* Change color on hover */
    .dropdown-container a:hover {
        background-color: #575757;
    }

    /* Show the dropdown when hovering over the button */
    .sidebar .dropdown-btn:hover + .dropdown-container {
        display: block;
    }
</style>
</html>
