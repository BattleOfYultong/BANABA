<?php
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


if (isset($_GET['delete'])) {
    $id = $_GET['delete'];

    $sql = "DELETE FROM `brgy_officials` WHERE id = $id";
    $result = mysqli_query($con, $sql);

    if ($result) {
        header('location: barangay_officials.php?deleted=true');
        exit();
    } else {
        die(mysqli_error($con));
    }
}

if(isset($_POST['submit'])){
    $position=$_POST['position'];
    $image=$_POST['image'];
    $name=$_POST['name'];
    $contact=$_POST['contact'];
    




    $sql="insert into `brgy_officials` (position,image,name,contact)
    values('$position','$image','$name','$contact')";
    $result=mysqli_query($con,$sql);
    if($result){
        header('location: barangay_officials.php?added=true');
        exit();
    }else{
        die(mysqli_error($con));
    }
}

if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $position = $_POST['position'];
    $image = $_POST['image'];
    $name = $_POST['name'];
    $contact = $_POST['contact'];

    $sql = "UPDATE `brgy_officials` SET position='$position', image='$image', name='$name', contact='$contact' WHERE id=$id";
    $result = mysqli_query($con, $sql);

    if ($result) {
        header('location: barangay_officials.php?updated=true');
        exit();
    } else {
        die(mysqli_error($con));
    }
}



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
        <h1>Barangay Officials</h1>
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

<button id="showModalButton" class="button">Add Official</button> 


<div class="table-container">
        <table class="table">
            <thead>
                <tr>
                <th scope="col">Sl no</th>
                    <th scope="col">Position</th>
                    <th scope="col">Image</th>
                    <th scope="col">Name</th>
                    <th scope="col">Contact</th>



                    <th scope="col">Operation</th>

                </tr>
            </thead>
</div>
            
            <tbody>

            <?php
$sql = "SELECT * FROM `brgy_officials`";
$result = mysqli_query($con, $sql);
if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $id = $row['id'];
        $position = $row['position'];
        $image = $row['image'];
        $name = $row['name'];
        $contact = $row['contact'];
        

        

        echo '<tr>
            <td>' . $id . '</td>
            <td>' . $position . '</td>
            <td><img src="' . $image . '" alt="Image" width="80" height="100"></td>
            <td>' . $name . '</td>
            <td>' . $contact . '</td>
                        

            <td>
                <button class="btn-update" data-id="' . $id . '" data-position="' . $position . '" data-image="' . $image . '" data-name="' . $name . '" data-contact="' . $contact . '">Update</button>
                <button class="btn-delete" onclick="showDeleteModal(' . $id . ')">Delete</button>                </button>

            </td>
        </tr>';
    }
}
?>


</tbody>
</table>

</div>


<div id="addModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <form method="post" action="barangay_officials.php">
                <label for="position">Position:</label>
                <input type="text" name="position" required><br><br>

                <label for="image">Image:</label>
                <input type="file" name="image" required><br><br> 

                <label for="name">Name:</label>
                <input type="text" name="name" required><br><br>

                <label for="contact">Contact:</label>
                <input type="text" name="contact" required><br><br>

                <input type="submit" name="submit" value="Add">
            </form>
        </div>
    </div>

<!-- Update Modal -->
<div id="updateModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <form method="post" action="barangay_officials.php">
                <input type="hidden" name="id" id="updateId">
                <label for="position">Position:</label>
                <input type="text" name="position" id="updatePosition" required><br><br>

                <label for="image">Image URL:</label>
                <input type="file" name="image" id="updateImage" required><br><br>

                <label for="name">Name:</label>
                <input type="text" name="name" id="updateName" required><br><br>

                <label for="contact">Contact:</label>
                <input type="text" name="contact" id="updateContact" required><br><br>

                <input type="submit" name="update" value="Update">
            </form>
        </div>
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

    // ... (Your existing JavaScript code) ...

    let updateModal = document.getElementById("updateModal");
        let span = document.getElementsByClassName("close")[0];

        let updateButtons = document.querySelectorAll('.btn-update');
        updateButtons.forEach(button => {
            button.addEventListener('click', () => {
                document.getElementById("updateId").value = button.dataset.id;
                document.getElementById("updatePosition").value = button.dataset.position;
                document.getElementById("updateImage").value = "";
                document.getElementById("updateName").value = button.dataset.name;
                document.getElementById("updateContact").value = button.dataset.contact;
                updateModal.style.display = "block";
            });
        });

        span.onclick = function() {
            updateModal.style.display = "none";
        }

        window.onclick = function(event) {
            if (event.target == updateModal) {
                updateModal.style.display = "none";
            }
        }
</script>

<script>
        function showDeleteModal(id) {
            if (confirm("Are you sure you want to delete this official?")) {
                window.location.href = "barangay_officials.php?delete=" + id; 
            }
        }
    </script>

<script>
        // ... (Your existing JavaScript code for sidebar, dropdown, update modal) ...

        let addModal = document.getElementById("addModal");
        let addModalButton = document.getElementById("showModalButton");
        let addModalClose = document.getElementsByClassName("close")[0]; 

        addModalButton.addEventListener('click', () => {
            addModal.style.display = "block";
        });

        addModalClose.onclick = function() {
            addModal.style.display = "none";
        };

        window.onclick = function(event) {
            if (event.target == addModal) {
                addModal.style.display = "none";
            }
        };
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

    .button{
            background-color: #003366;
            color: white;
            text-decoration: none;
            padding: 10px 20px;
            border: solid white 2px;
            border-radius: 5px;
            display: inline-block;
            margin-top: 150px;
            margin-left: 400px;
    }

    .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0,0,0,0.4);
            border-radius: 10px;
        }

        .modal-content {
            background-color: #fefefe;
            margin: 15% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 30%;
            border-radius: 10px;
            
        
        }

        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }

        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
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
    .table-container {

        margin-top: 40px;
        margin-left: 300px;
        overflow-x: auto; /* Allow horizontal scrolling if needed */
    padding: 20px;
    height: 600px; /* Set a desired height for the container */
    overflow-y: auto; /* Add vertical scroll if content is too large */
    
}

.table {
    width: 90%; /* Table takes full width */
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

.btn {
            background-color: blue;
            color: white;
            text-decoration: none;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            
        }
        .btn-update{
            background-color: darkblue;
            color: white;
            text-decoration: none;
            padding: 10px 20px;
            border: solid white 2px;
            border-radius: 5px;
            display: inline-block;
            margin: 5px;
            font-size: 15px;

        }
        .btn-delete {
            background-color: darkred;
            color: white;
            text-decoration: none;
            padding: 10px 20px;
            border: solid white 2px;
            border-radius: 5px;
            display: inline-block;
            margin: 5px;
            font-size: 15px;

        }
        .btn:hover {
            background-color: darkblue;
        }
        .btn-update:hover{
            background-color: darkblue;

        } 
        .btn-delete:hover {
            background-color: darkred;
        }
        
        h1{
            color: white;
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
        background-color:  #003366;
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
        background-color:  #003366;
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
        background-color: #111;
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
        background-color: #222;
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
