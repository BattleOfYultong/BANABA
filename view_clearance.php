<?php
// Connect to the database
include 'clearance_connect.php';

// Fetch all records from the barangay_clearance table
$sql = "SELECT id, full_name, application_date, email FROM barangay_clearance";
$result = mysqli_query($con, $sql);


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Barangay Clearance List</title>
    <link rel="stylesheet" href="style.css">
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        /* General page styles */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        /* Top Navigation Bar */
        .navbar {
            background-color: darkblue;
            padding: 10px 20px;
        }

        .navbar ul {
            list-style-type: none;
            padding: 0;
            margin: 0;
            display: flex;
            justify-content: center;
        }

        .navbar ul li {
            margin-right: 20px;
        }

        .navbar ul li a {
            color: white;
            text-decoration: none;
            font-size: 18px;
        }

        .navbar ul li a:hover {
            background-color: #0056b3;
        }

        /* Container for the content */
        .container {
            width: 80%;
            margin: 30px auto;
            padding: 20px;
            background-color: white;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        h1 {
            text-align: center;
            font-size: 24px;
            color: #333;
            margin-bottom: 20px;
        }

        /* Table Styles */
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            padding: 12px;
            text-align: left;
        }

        th {
            background-color: #003366; /* Dark blue background */
            color: white;
        }

        tr:nth-child(even) {
            background-color: #e0e0e0; /* Light gray for even rows */
        }

        tr:hover {
            background-color: #c8d6e5; /* Lighter blue when hovered */
        }

        /* Action button styles */
        a {
            color: #007BFF;
            text-decoration: none;
            font-weight: bold;
        }

        a:hover {
            text-decoration: underline;
        }

         .action-buttons a {
            padding: 5px 10px;
            color: white;
            text-decoration: none;
            border-radius: 4px;
            margin: 0 5px;
            font-size: 14px;
           
        }
         .action-buttons i {
            margin-right: 5px; /* Space between the icon and text */
        }
         .approve {
            background-color: #4CAF50;
        }
         .reject {
            background-color: blue;
        }
         .approve:hover {
            background-color: #45a049;
        }
         .reject:hover {
            background-color: darkblue;
        }


        /* Responsive styling for smaller screens */
        @media (max-width: 768px) {
            .container {
                width: 90%;
            }

            table {
                font-size: 14px;
            }
        }

    </style>
</head>
<body>

<!-- Top Navigation Bar -->
<nav class="navbar">
    <ul>
        <li><a href="barangay_dashboard.php">Dashboard</a></li>
        <li><a href="view_clearance.php">View Clearances</a></li>
    </ul>
</nav>

<!-- Table to Display Barangay Clearances -->
<div class="container">
    <h1>List of Barangay Clearance Applications</h1>
    
    <?php
    if (mysqli_num_rows($result) > 0) {
        // Start the table
        echo "<table>
                <tr>
                    <th>ID</th>
                    <th>Full Name</th>
                    <th>Date Created</th>
                    <th>Email</th>
                    <th>actions</th>    
                </tr>";

        // Output each row
      while ($row = mysqli_fetch_assoc($result)) {
    echo "<tr>";
    echo "<td>" . htmlspecialchars($row['id']) . "</td>";
    echo "<td>" . htmlspecialchars($row['full_name']) . "</td>";
    echo "<td>" . htmlspecialchars($row['application_date']) . "</td>";
     echo "<td>" . htmlspecialchars($row['email']) . "</td>";

    echo "<td class='action-buttons'>";
    echo "<a onclick='alertmessage()' href='send_email_clearance.php?clearance_id=" . urlencode($row['id']) . "' class='approve'>";
    echo "<i class='fas fa-check-circle'></i>Send Email";
    echo "</a>";
    echo "<a href='view_clearance_details.php?id=" . $row['id'] . "' class='reject'>";
    echo "<i class='fas fa-eye'></i>View Details";
    echo "</a>";
    echo "</td>";
    echo "</tr>";
}

        // End the table
        echo "</table>";
    } else {
        echo "<p>No records found.</p>";
    }

    // Close the database connection
    mysqli_close($con);
    ?>

</div>

<script>
    function alertmessage(){
        alert('Email Has Been Sent');
    }
</script>
</body>
</html>
