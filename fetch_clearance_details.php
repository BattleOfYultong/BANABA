<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "barangay_management";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$Request_ID = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($Request_ID > 0) {
    
    $sql = "SELECT Request_ID, full_name, address, contact_number, gender, civil_status, job, id_number, purpose, occupation, years_residency, household_head, valid_id_type, application_date
            FROM barangay_clearance 
            WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $Request_ID);
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
            <title>Clearance Request</title>
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
                        <div class="label">Request ID:</div>
                        <div class="value"><?php echo $report['Request_ID']; ?></div>
                    </div>

                    <div class="detail-row">
                        <div class="label">Full Name:</div>
                        <div class="value"><?php echo htmlspecialchars($report['full_name']); ?></div>
                    </div>

                    <div class="detail-row">
                        <div class="label">Address:</div>
                        <div class="value"><?php echo htmlspecialchars($report['address']); ?></div>
                    </div>

                    <div class="detail-row">
                        <div class="label">Contact Number:</div>
                        <div class="value"><?php echo htmlspecialchars($report['contact_number']); ?></div>
                    </div>

                    <div class="detail-row">
                        <div class="label">Gender:</div>
                        <div class="value"><?php echo htmlspecialchars($report['gender']); ?></div>
                    </div>

                    <div class="detail-row">
                        <div class="label">Civil Status</div>
                        <div class="value"><?php echo htmlspecialchars($report['civil_status']); ?></div>
                    </div>

                    <div class="detail-row">
                        <div class="label">Job</div>
                        <div class="value"><?php echo htmlspecialchars($report['job']); ?></div>
                    </div>

                    <div class="detail-row">
                        <div class="label">ID Number</div>
                        <div class="value"><?php echo nl2br(htmlspecialchars($report['id_number'])); ?></div>
                    </div>

                    <div class="detail-row">
                        <div class="label">Purpose of Application</div>
                        <div class="value"><?php echo htmlspecialchars($report['purpose']); ?></div>
                    </div>

                    <div class="detail-row">
                        <div class="label">Current Occupation:</div>
                        <div class="value"><?php echo htmlspecialchars($report['occupation']); ?></div>
                    </div>

                    <div class="detail-row">
                        <div class="label">Years of Residency</div>
                        <div class="value"><?php echo htmlspecialchars($report['years_residency']); ?></div>
                    </div>

                    <div class="detail-row">
                        <div class="label">Household Head</div>
                        <div class="value"><?php echo htmlspecialchars($report['household_head']); ?></div>
                    </div>

                    <div class="detail-row">
                        <div class="label">Valid ID </div>
                        <div class="value"><?php echo htmlspecialchars($report['valid_id_type']); ?></div>
                    </div>

                    <div class="detail-row">
                        <div class="label">Date submitted</div>
                        <div class="value"><?php echo htmlspecialchars($report['application_date']); ?></div>
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
