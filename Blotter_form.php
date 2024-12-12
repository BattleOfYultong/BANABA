<?php
session_start(); 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Barangay Banaba Blotter Form</title>
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

        .form-row {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            margin-bottom: 15px;
        }

        .form-group {
            flex: 1;
            min-width: 280px;
        }

        .form-group label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .form-group input,
        .form-group select,
        .form-group textarea {
            width: 100%;
            padding: 6px;
            border-radius: 4px;
            border: 1px solid #ccc;
            font-size: 16px;
        }

        .form-group textarea {
            resize: vertical;
        }

        .form-group select {
            cursor: pointer;
        }

        button {
            background-color: #003366;
            color: white;
            border: none;
            padding: 10px 20px;
            font-size: 16px;
            border-radius: 4px;
            cursor: pointer;
            width: 100%;
            margin-top: 20px;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #005bb5;
        }

        .notification {
            background-color: #e9f7df;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #a4d08e;
            color: #4d9c3e;
            font-size: 16px;
            border-radius: 4px;
            text-align: center;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .form-row {
                flex-direction: column;
                gap: 10px;
            }
        }
    </style>
</head>
<body>
    <!-- Top Navigation Bar -->
    <nav>
        <ul>
            <li><a href="#" style="font-weight: bold;">Barangay Banaba</a></li>
            
            <li>
            <a href="resident_dashboard.php">Dashboard</a>
            </li>
        </ul>
    </nav>

    <div class="container">
        <div class="header">
            <img src="LOGO.png" alt="Logo"> 
            <h2>Brgy. Banaba Blotter Form</h2>
        </div>

        <?php
        if (isset($_SESSION['notification'])) {
            echo "<div class='notification'>" . $_SESSION['notification'] . "</div>";
            unset($_SESSION['notification']); 
        }
        ?>

        <form action="submit_blotter.php" method="POST">
            <div class="form-row">
                <div class="form-group">
                    <label for="complainant_name">Complainant Name</label>
                    <input type="text" id="complainant_name" name="complainant_name" required>
                </div>

                <div class="form-group">
                    <label for="complainant_address">Complainant Address</label>
                    <input type="text" id="complainant_address" name="complainant_address" required>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="respondent_name">Complained Name</label>
                    <input type="text" id="respondent_name" name="respondent_name" required>
                </div>

                 <div class="form-group">
                    <label for="respondent_name">Complainant Email</label>
                    <input type="email" id="email" name="email" required>
                </div>

                <div class="form-group">
                    <label for="respondent_address">Complained Address</label>
                    <input type="text" id="respondent_address" name="respondent_address" required>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="witnesses">Witnesses (Separate by commas)</label>
                    <input type="text" id="witnesses" name="witnesses">
                </div>

                <div class="form-group">
                    <label for="incident_date">Incident Date</label>
                    <input type="date" id="incident_date" name="incident_date" required>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="incident_time">Incident Time</label>
                    <input type="time" id="incident_time" name="incident_time" required>
                </div>

                <div class="form-group">
                    <label for="incident_location">Incident Location</label>
                    <input type="text" id="incident_location" name="incident_location" required>
                </div>
                
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="incident_details">Incident Details</label>
                    <textarea id="incident_details" name="incident_details" rows="4" required></textarea>
                </div>

                <div class="form-group">
                    <label for="resident_type">Type of Resident</label>
                    <select id="resident_type" name="resident_type" required>
                        <option value="Normal">Normal</option>
                        <option value="Senior">Senior</option>
                        <option value="PWD">PWD</option>
                    </select>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="status">Status</label>
                    <select id="status" name="status" required>
                        <option value="Pending">Pending</option>
                        <option value="Resolved">Resolved</option>
                    </select>
                </div>
            </div>

            <button type="submit">Submit</button>
        </form>
    </div>
</body>
</html>
