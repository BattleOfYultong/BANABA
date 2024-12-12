<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "barangay_management";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$blotter_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($blotter_id > 0) {
    
    $sql = "SELECT id, complainant_name, respondent_name, witnesses, incident_date, incident_time, 
                   incident_location, incident_details, resident_type, status 
            FROM blotter_reports 
            WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $blotter_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $report = $result->fetch_assoc();
        ?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Blotter Report Details</title>
            <style>
                body {
                    font-family: Arial, sans-serif;
                    background-color: #f7f9fc;
                    margin: 0;
                    padding: 0;
                    color: #333;
                }

                .document-container {
                    max-width: 800px;
                    margin: 40px auto;
                    background-color: #ffffff;
                    border-radius: 10px;
                    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
                    overflow: hidden;
                }

                .header {
                    background-color: #003366;
                    color: #ffffff;
                    padding: 20px;
                    text-align: center;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    gap: 10px;
                }

                .header img {
                    height: 60px;
                }

                h2 {
                    margin: 0;
                    font-size: 1.8em;
                }

                .content {
                    padding: 20px;
                }

                .detail-row {
                    display: flex;
                    justify-content: space-between;
                    margin-bottom: 15px;
                    align-items: center;
                }

                .label {
                    font-weight: bold;
                    color: #003366;
                    width: 200px;
                    margin-right: 10px;
                }

                .value {
                    flex: 1;
                }

                .footer {
                    text-align: center;
                    background-color: #f1f1f1;
                    padding: 10px;
                    color: #666;
                    font-size: 0.9em;
                }

                .print-button {
                    display: block;
                    margin: 20px auto;
                    padding: 10px 20px;
                    font-size: 16px;
                    background-color: #003366;
                    color: white;
                    border: none;
                    border-radius: 5px;
                    cursor: pointer;
                }

                .print-button:hover {
                    background-color: #00509e;
                }

                @media (max-width: 768px) {
                    .header img {
                        height: 50px;
                    }

                    h2 {
                        font-size: 1.5em;
                    }

                    .content {
                        padding: 15px;
                    }

                    .detail-row {
                        flex-direction: column;
                    }

                    .label {
                        width: auto;
                    }
                }
            </style>
        </head>
        <body>
            <div class="document-container">
                <div class="header">
                    <img src="LOGO.png" alt="Barangay Logo"> 
                    <h2>Blotter Report Details</h2>
                </div>

                <div class="content">
                    <div class="detail-row">
                        <div class="label">Blotter Number:</div>
                        <div class="value"><?php echo $report['id']; ?></div>
                    </div>

                    <div class="detail-row">
                        <div class="label">Complainant Name:</div>
                        <div class="value"><?php echo htmlspecialchars($report['complainant_name']); ?></div>
                    </div>

                    <div class="detail-row">
                        <div class="label">Respondent Name:</div>
                        <div class="value"><?php echo htmlspecialchars($report['respondent_name']); ?></div>
                    </div>

                    <div class="detail-row">
                        <div class="label">Witnesses:</div>
                        <div class="value"><?php echo htmlspecialchars($report['witnesses']); ?></div>
                    </div>

                    <div class="detail-row">
                        <div class="label">Incident Date:</div>
                        <div class="value"><?php echo htmlspecialchars($report['incident_date']); ?></div>
                    </div>

                    <div class="detail-row">
                        <div class="label">Incident Time:</div>
                        <div class="value"><?php echo htmlspecialchars($report['incident_time']); ?></div>
                    </div>

                    <div class="detail-row">
                        <div class="label">Location:</div>
                        <div class="value"><?php echo htmlspecialchars($report['incident_location']); ?></div>
                    </div>

                    <div class="detail-row">
                        <div class="label">Incident Details:</div>
                        <div class="value"><?php echo nl2br(htmlspecialchars($report['incident_details'])); ?></div>
                    </div>

                    <div class="detail-row">
                        <div class="label">Resident Type:</div>
                        <div class="value"><?php echo htmlspecialchars($report['resident_type']); ?></div>
                    </div>

                    <div class="detail-row">
                        <div class="label">Status:</div>
                        <div class="value"><?php echo htmlspecialchars($report['status']); ?></div>
                    </div>
                </div>

                <div class="footer">
                    <p>Barangay Management System</p>
                </div>
            </div>

            <button class="print-button" onclick="window.print()">Print Report</button>
        </body>
        </html>
        <?php
    } else {
        echo "<p>Blotter report not found.</p>";
    }

    $stmt->close();
} else {
    echo "<p>Invalid blotter ID.</p>";
}

$conn->close();
?>
