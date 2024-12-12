<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'resident') {
    header("Location: login.php");
    exit();
}

?>

<?php
$servername = "localhost";  
$username = "root";         
$password = "";             
$dbname = "barangay_management"; 

$con = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
} else {
    echo "Connected successfully";
}
$user_id = $_SESSION['user_id']; // Get user ID from session

$sql = "SELECT name FROM users WHERE user_id = ?";  // Use user_id to fetch the name
$stmt = $con->prepare($sql);
$stmt->bind_param("i", $user_id); // Bind user_id as integer
$stmt->execute();
$stmt->bind_result($name);
$stmt->fetch();
$stmt->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reesident Dashboard</title>
    <link rel="stylesheet" href="styles.css">
    <!-- Font Awesome CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>

<div class="navbar">
    <div class="navbar-content">
    <h1>Welcome, <?php echo htmlspecialchars($name); ?> <i class="fas fa-user-circle"></i></h1>    </div>
</div>

<div class="table-container">
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">Position</th>
                    <th scope="col">Image</th>
                    <th scope="col">Name</th>




                </tr>
            </thead>
</div>
            
            <tbody>

            <?php
$sql = "SELECT * FROM `brgy_officials`";
$result = mysqli_query($con, $sql);
if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $position = $row['position'];
        $image = $row['image'];
        $name = $row['name'];
        

        

        echo '<tr>
            <td>' . $position . '</td>
            <td><img src="' . $image . '" alt="Image" width="80" height="100"></td>
            <td>' . $name . '</td>
                        

           
        </tr>';
    }
}
?>


</tbody>
</table>

</div>

<!-- Sidebar -->
<div id="mySidebar" class="sidebar">
    <button class="closebtn" onclick="closeNav()">&times;</button>
    <a href=""><i class="fas fa-tachometer-alt"></i> Dashboard</a>
    <a href="resident_officials.php"><i class="fas fa-users"></i> Barangay Officials</a>
    <!-- Barangay Services Dropdown -->
    <a href="javascript:void(0);" class="dropdown-btn"><i class="fas fa-cogs"></i> Barangay Services</a>
    <div class="dropdown-container">
        <a href="blotter_form.php"><i class="fas fa-clipboard-list"></i> Blotter Form</a>
        <a href="barangay_clearance_form.php"><i class="fas fa-hands-helping"></i> Clearance Forn</a>
        <a href="business_permit.php"><i class="fas fa-gavel"></i> Business Permit Form</a>
        <a href="resident_concerns.php"><i class="fas fa-gavel"></i> Concerns</a> 


    </div>
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

    .table-container {

margin-top: 150px;
margin-left: 500px;
overflow-x: auto; /* Allow horizontal scrolling if needed */
padding: 20px;
height: 600px; /* Set a desired height for the container */
overflow-y: auto; /* Add vertical scroll if content is too large */

}

.table {
width: 70%; /* Table takes full width */
border-collapse: collapse; /* Improved border rendering */
height: 400px;

}

     
.table th,
.table td {
padding: 10px; /* Increased padding for better readability */
border: 1px solid #ddd; /* Lighter border color */
text-align: left; /* Align text to the left */
text-align: center;
height: 130px;




}

.table th {
background-color: #003366; /* Lighter background for header */
color: white;
height: 70px;
width: 200px;
text-align: center;
}

    .image {

            display: block;
  margin-left: auto;
  margin-right: auto;

        }
        .table-width{
            width: 50%; /* You can adjust the width to your preference */
    margin-left: auto;
    margin-right: auto;
        }
        .form-group {
            text-align: center;
        }
        .btns{
            margin-left: auto;  /* Left margin auto */
            margin-right: auto;
            display: block;
            border-radius: 10px;
            height: 8%;
            width: 8%;
        }
        .form-control{
            width: 25%;
            height: 7%;
            margin-left: auto;  /* Left margin auto */
            margin-right: auto;
            display: block;
        }
        .image {

            display: block;
  margin-left: auto;
  margin-right: auto;

        }
        .table-width{
            width: 50%; /* You can adjust the width to your preference */
    margin-left: auto;
    margin-right: auto;
        }
        .form-group {
            text-align: center;
        }
        .btns{
            margin-left: auto;  /* Left margin auto */
            margin-right: auto;
            display: block;
            border-radius: 10px;
            height: 8%;
            width: 8%;
        }
        .form-control{
            width: 25%;
            height: 7%;
            margin-left: auto;  /* Left margin auto */
            margin-right: auto;
            display: block;
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

        .image {

            display: block;
  margin-left: auto;
  margin-right: auto;

        }
        .table-width{
            width: 50%; /* You can adjust the width to your preference */
    margin-left: auto;
    margin-right: auto;
        }
        .form-group {
            text-align: center;
        }
        .btns{
            margin-left: auto;  /* Left margin auto */
            margin-right: auto;
            display: block;
            border-radius: 10px;
            height: 8%;
            width: 8%;
        }
        .form-control{
            width: 25%;
            height: 7%;
            margin-left: auto;  /* Left margin auto */
            margin-right: auto;
            display: block;
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
