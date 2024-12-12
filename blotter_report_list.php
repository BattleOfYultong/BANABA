<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "barangay_management";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT id, complainant_name, email, status FROM blotter_reports ORDER BY id DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blotter Reports List</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        nav {
            background-color: #003366;
            padding: 50px;
        }

        nav ul {
            list-style: none;
            padding: 0;
            margin: 0;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        nav ul li {
            display: inline;
        }

        nav a {
            color: white;
            text-decoration: none;
            font-size: 18px;
            margin: 0 15px;
            transition: background-color 0.3s ease;
        }

        nav a:hover {
            background-color: #005bb5;
            padding: 5px;
        }

        .container {
            max-width: 900px;
            margin: 20px auto;
            padding: 20px;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .header img {
            width: 100px;
            height: 100px;
            object-fit: contain;
        }

        .header h2 {
            font-size: 24px;
            margin: 10px 0;
        }

        h2 {
            text-align: center;
            font-size: 30px;
            margin-bottom: 20px;
            color: #003366;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            padding: 12px;
            text-align: center;
        }

        th {
            background-color: #003366;
            color: white;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        tr:hover {
            background-color: #ddd;
        }

        .resolve-btn {
            background-color: #28a745;
            color: white;
            border: none;
            padding: 8px 16px;
            font-size: 14px;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .resolve-btn:hover {
            background-color: #218838;
        }

        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            align-items: center;
            justify-content: center;
            z-index: 1000;
        }

        .modal-content {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            width: 80%;
            max-width: 600px;
            position: relative;
        }

        .close {
            font-size: 24px;
            color: #333;
            cursor: pointer;
            position: absolute;
            top: 10px;
            right: 10px;
        }

        .close:hover {
            color: #ff0000;
        }

        .no-reports {
            text-align: center;
            font-size: 18px;
            color: #ff0000;
        }
    </style>
</head>
<body>

    <!-- Navigation -->
    <nav>
        <ul>
            <li><a href="#" style="font-weight: bold;">Barangay Banaba</a></li>
            <li>
                <a href="barangay_dashboard.php">Dashboard</a>
                <a href="blotter_report_list.php">Report List</a>
                <a href="blotter_history.php">Blotter History</a>
            </li>
        </ul>
    </nav>

    <!-- Container for the Reports -->
    <div class="container">
        
        <h2>Blotter Reports List</h2>

        <?php if ($result->num_rows > 0): ?>
            <table>
                <thead>
                    <tr>
                        <th>Blotter Number</th>
                        <th>Complainant's Name</th>
                        <th>Email</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo $row['id']; ?></td>
                            <td><?php echo htmlspecialchars($row['complainant_name']); ?></td>
                            <td><?php echo htmlspecialchars($row['email']); ?></td>
                            <td><?php echo htmlspecialchars($row['status']); ?></td>
                            <td>
                                <a href="javascript:void(0);" onclick="fetchDetails(<?php echo $row['id']; ?>)">View Details</a>
                                <?php if ($row['status'] === 'Pending'): ?>
                                    <button class="resolve-btn" onclick="resolveBlotter(<?php echo $row['id']; ?>)">Mark as Resolved</button>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p class="no-reports">No blotter reports found.</p>
        <?php endif; ?>

        <?php $conn->close(); ?>
    </div>

    <!-- Modal for Details -->
    <div id="detailsModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal()">&times;</span>
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

        // Function to resolve blotter
        function resolveBlotter(id) {
            const xhr = new XMLHttpRequest();
            xhr.open('POST', 'update_status.php', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onload = function () {
                if (this.status === 200) {
                    alert(this.responseText);  
                    location.reload();  
                }
            };
            xhr.send('id=' + id + '&status=Resolved');
        }
    </script>

</body>
</html>
