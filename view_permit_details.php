<?php
// Connect to the database
include 'clearance_connect.php';

// Fetch the last submitted form data (You can modify this as per your requirement to fetch the right record)
$sql = "SELECT * FROM business_permit ORDER BY id DESC LIMIT 1";
$result = mysqli_query($con, $sql);

if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $id = $row['id'];
    $business_name = $row['business_name'];
    $address = $row['address'];
    $type = $row['type'];
    $owner = $row['owner'];
    $contact = $row['contact'];
    
} else {
    echo "No data found!";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Barangay Clearance Statement</title>

    <!-- Add some basic styles -->
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        .container {
            width: 8.5in; /* 8.5 inches for width */
            height: 11in; /* 11 inches for height */
            margin: 20px auto;
            padding: 20px;
            background-color: white;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        h1 {
            text-align: center;
            font-size: 24px;
            margin-bottom: 20px;
            color: #333;
        }

        p, ul {
            font-size: 16px;
            color: #333;
            line-height: 1.6;
        }

        p strong {
            font-weight: bold;
        }

        ul {
            list-style-type: none;
            padding-left: 0;
        }

        ul li {
            margin: 5px 0;
        }

        hr {
            border: 1px solid #000;
            margin: 20px 0;
        }

        .signature-section {
            margin-top: 50px;
            display: flex;
            justify-content: space-between;
            padding-top: 20px;
        }

        .signature {
            width: 45%;
        }

        .signature-line {
            border-bottom: 1px solid #000;
            width: 200px;
            margin-top: 10px;
        }

        nav {
            background-color: darkblue;
            padding: 10px;
            color: white;
            font-weight:bold;
        }

        nav ul {
            list-style-type: none;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
        }

        nav ul li {
            margin: 0 15px;
        }

        nav ul li a {
            color: white;
            text-decoration: none;
            font-size: 18px;
        }

        nav ul li a:hover {
            text-decoration: underline;
        }

        /* Hide elements during print */
        @media print {
            nav {
                display: none;
            }

            .print-button {
                display: none;
            }
        }

        .print-button {
            text-align: center;
            margin: 20px;
        }

        .print-button button {
            padding: 10px 20px;
            font-size: 16px;
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
            border-radius: 5px;
        }

        .print-button button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>

<nav>
    <ul>
        <li><a href="barangay_dashboard.php">Dashboard</a></li>
        <li><a href="business_permit.php">Business Permit Form</a></li>
        <li><a href="view_permit.php">View Permit</a></li>
        
    </ul>
</nav>

<div class="container">
    <h1>Business Permit</h1>

    <p><strong>Republic of the Philippines</strong></p>
    <p><strong>Province of Rizal, Calabarzon</strong></p>
    <p><strong>City/Municipality of San Mateo, Rizal</strong></p>
    <p><strong>Barangay Banaba</strong></p>

    <hr>

    <p><strong>Barangay Clearance No. <?php echo $id; ?></strong></p>
    <p><strong>Date Issued: <?php echo date('F j, Y'); ?></strong></p>

    <p><strong>TO WHOM IT MAY CONCERN:</strong></p>

    <p>This is to certify that <strong><?php echo $full_name; ?></strong>, of legal age, Filipino, and a resident of <strong><?php echo $address; ?></strong>, has personally appeared before the undersigned Barangay Captain for the purpose of securing a Barangay Clearance.</p>

    <p>After verifying the records and the personal details of the applicant, it is hereby certified that:</p>
    <ul>
        <li>Is a registered resident of this Barangay.</li>
        <li>Has no pending criminal or administrative cases in this Barangay.</li>
        <li>Has no derogatory record that will prevent him/her from receiving this clearance.</li>
    </ul>

    <p>This Barangay Clearance is issued upon the request of the applicant for the purpose of <strong><?php echo $purpose; ?></strong> and is valid for 6 (six) months from the date of issuance, unless revoked for cause.</p>

    <p>Issued this <?php echo date('F j, Y'); ?> at Barangay Banaba, San Mateo, Rizal.</p>

    <div class="signature-section">
        <div class="signature">
            <p><strong>Issued by:</strong></p>
            <p>Mr. Sherwin Cuevillas<br>Barangay Captain<br>Barangay Banaba, San Mateo, Rizal</p>
            <div class="signature-line"></div>
            <p>Signature</p>
        </div>

        <div class="signature">
            <p><strong>Attested by:</strong></p>
            <p>Mrs. Liezel Garcia<br>Barangay Secretary</p>
            <div class="signature-line"></div>
            <p>Signature</p>
        </div>
    </div>

    <div class="print-button">
        <button onclick="window.print()">Print Clearance</button>
    </div>
</div>

</body>
</html>
