<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "barangay_management";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT id, complainant_name, status, date_reported FROM blotter_reports ORDER BY date_reported DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blotter Reports History</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <style>
        /* General Styles */
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        /* Navbar */
        .navbar {
            background-color: #003366;
            padding: 50px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .navbar-logo {
            width: 50px;
            height: 50px;
            object-fit: contain;
        }

        .navbar h1 {
            color: white;
            font-size: 24px;
            margin-left: 15px;
        }

        .navbar ul {
            list-style: none;
            padding: 0;
            margin: 0;
            display: flex;
        }

        .navbar ul li {
            margin-left: 20px;
        }

        .navbar a {
            color: white;
            text-decoration: none;
            font-size: 18px;
            padding: 10px 15px;
            border-radius: 4px;
            transition: background-color 0.3s;
        }

        .navbar a:hover {
            background-color: #005bb5;
        }

        /* Main Content */
        .container {
            max-width: 1100px;
            margin: 30px auto;
            padding: 20px;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        .container h2 {
            text-align: center;
            font-size: 28px;
            color: #003366;
            margin-bottom: 20px;
        }

        /* Table Styles */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            padding: 15px;
            text-align: center;
            border: 1px solid #ddd;
        }

        th {
            background-color: #003366;
            color: white;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        tr:hover {
            background-color: #f1f1f1;
        }

        td a {
            color: #003366;
            text-decoration: none;
            font-weight: bold;
            transition: color 0.3s;
        }

        td a:hover {
            color: #005bb5;
        }

        .no-reports {
            text-align: center;
            font-size: 18px;
            color: #ff0000;
        }

        /* Modal Styles */
        #detailsModal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5); /* Darker overlay */
            align-items: center;
            justify-content: center;
            z-index: 1000;
        }

        #detailsModal .modal-content {
            background-color: white;
            padding: 30px;
            border-radius: 10px;
            width: 80%;
            max-width: 800px;
            position: relative;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
            overflow-y: auto; /* Allow scrolling if content is too long */
        }

        #detailsModal .modal-header {
            font-size: 24px;
            font-weight: bold;
            color: #003366;
            margin-bottom: 20px;
        }

        #detailsModal .close {
            font-size: 32px;
            color: #003366;
            cursor: pointer;
            position: absolute;
            top: 10px;
            right: 10px;
        }

        #detailsModal .close:hover {
            color: #ff0000;
        }

        #modal-body {
            font-size: 18px;
            line-height: 1.6;
        }

        #modal-body h3 {
            color: #003366;
            font-size: 22px;
            margin-bottom: 15px;
        }

        #modal-body p {
            margin-bottom: 15px;
        }
    </style>
</head>
<body>

    <!-- Navigation Bar -->
    <div class="navbar">
        <img src="LOGO.png" alt="Barangay Logo" class="navbar-logo"> 
        <h1>Barangay Blotter System</h1>
        <ul>
        <a href="barangay_dashboard.php">Dashboard</a>
                <a href="blotter_report_list.php">Report List</a>
                <a href="blotter_history.php">Blotter History</a>
       
    </div>

    <!-- Main Content -->
    <div class="container">
        <h2>Blotter Reports History</h2>

        <?php if ($result->num_rows > 0): ?>
            <table>
                <thead>
                    <tr>
                        <th>Blotter Number</th>
                        <th>Complainant's Name</th>
                        <th>Status</th>
                        <th>Date Reported</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo $row['id']; ?></td>
                            <td><?php echo htmlspecialchars($row['complainant_name']); ?></td>
                            <td><?php echo htmlspecialchars($row['status']); ?></td>
                            <td><?php echo htmlspecialchars($row['date_reported']); ?></td>
                            <td>
                                <a href="javascript:void(0);" onclick="fetchDetails(<?php echo $row['id']; ?>)">View Details</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p class="no-reports">No blotter reports history found.</p>
        <?php endif; ?>

        <?php $conn->close(); ?>
    </div>

    <!-- Modal for Details -->
    <div id="detailsModal">
        <div class="modal-content">
            <span class="close" onclick="closeModal()">×</span>
            <div id="modal-body">
                <!-- Dynamic content will be injected here -->
            </div>
        </div>
    </div>

    <script>
        // Function to fetch blotter details
        function fetchDetails(id) {
            const xhr = new XMLHttpRequest();
            xhr.open('GET', 'fetch_blotter_details.php?id=' + id, true);
            xhr.onload = function () {
                if (this.status === 200) {
                    document.getElementById('modal-body').innerHTML = this.responseText;
                    document.getElementById('detailsModal').style.display = 'flex';
                }
            };
            xhr.send();
        }

        // Function to close the modal
        function closeModal() {
            document.getElementById('detailsModal').style.display = 'none';
        }
    </script>

</body>
</html>
