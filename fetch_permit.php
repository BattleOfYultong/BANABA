<?php

$servername = "localhost: 3307";
$username = "root";
$password = "";
$dbname = "barangay_management";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$blotter_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($blotter_id > 0) {
    
    $sql = "SELECT id, owner, business_name, type, address, contact, tin_number, business_license, email, establishment_date
            FROM business_permit
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
            <title>Permit Details</title>
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
                    <h2>Permit Details</h2>
                </div>

                <div class="content">

                    <div class="detail-row">
                        <div class="label">ID:</div>
                        <div class="value"><?php echo $report['id']; ?></div>
                    </div>

                    <div class="detail-row">
                        <div class="label">Owner Name:</div>
                        <div class="value"><?php echo $report['owner']; ?></div>
                    </div>

                    <div class="detail-row">
                        <div class="label">Business Name:</div>
                        <div class="value"><?php echo htmlspecialchars($report['business_name']); ?></div>
                    </div>

                    <div class="detail-row">
                        <div class="label">Type of Business:</div>
                        <div class="value"><?php echo htmlspecialchars($report['type']); ?></div>
                    </div>

                    <div class="detail-row">
                        <div class="label">Contact:</div>
                        <div class="value"><?php echo htmlspecialchars($report['contact']); ?></div>
                    </div>

                    <div class="detail-row">
                        <div class="label">TIN number:</div>
                        <div class="value"><?php echo htmlspecialchars($report['tin_number']); ?></div>
                    </div>

                    <div class="detail-row">
                        <div class="label">Business License:</div>
                        <div class="value"><?php echo htmlspecialchars($report['business_license']); ?></div>
                    </div>

                    <div class="detail-row">
                        <div class="label">Email:</div>
                        <div class="value"><?php echo htmlspecialchars($report['email']); ?></div>
                    </div>

                    <div class="detail-row">
                        <div class="label">Establishment Date:</div>
                        <div class="value"><?php echo htmlspecialchars($report['establishment_date']); ?></div>
                    </div>

                </div>

                <div class="footer">
                    <p>Barangay Management System</p>
                </div>
            </div>

            <button class="print-button" onclick="window.print()">Print Permit</button>
        </body>
        </html>
        <?php
    } else {
        echo "<p>Permit not found.</p>";
    }

    $stmt->close();
} else {
    echo "<p>Invalid permit ID.</p>";
}

$conn->close();
?>
