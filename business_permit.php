<?php
// Connect to the database
include 'clearance_connect.php';

if (isset($_POST['submit'])) {
    // Collect form data
    $business_name = $_POST['business_name'];
    $address = $_POST['address'];
    $type = $_POST['type'];
    $owner = $_POST['owner'];
    $contact = $_POST['contact'];
    $tin_number = $_POST['tin_number'];  // Added field
    $business_license = $_POST['business_license'];  // Added field
    $email = $_POST['email'];  // Added field
    $establishment_date = $_POST['establishment_date'];  // Added field

    // Prepared statement to prevent SQL injection
    $stmt = $con->prepare("INSERT INTO business_permit (business_name, address, type, owner, contact, tin_number, business_license, email, establishment_date) 
                           VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");

    // Bind parameters (Note: We only bind 9 variables since id is auto-incremented)
    $stmt->bind_param("sssssssss", $business_name, $address, $type, $owner, $contact, $tin_number, $business_license, $email, $establishment_date);

    // Execute the query
    if ($stmt->execute()) {
        // Success: Show an alert and redirect to the form
        echo "<script>
                alert('Form submitted successfully!');
                window.location.href = 'business_permit.php';
              </script>";
        exit();  // Make sure no further code is executed after the alert
    } else {
        // Error: Show an alert
        echo "<script>
                alert('Error submitting form!');
              </script>";
    }

    // Close the statement
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Barangay Business Permit Form</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<!-- Top Navigation Bar -->
<nav class="navbar">
    <ul>
    <li>
        <a href="javascript:history.back()">Dashboard</a></li>

    </ul>
</nav>

<!-- Form Container -->
<div class="container">
    <h1>Business Permit Application</h1>

    <form method="POST">
        <!-- Business Information -->
        <h3>Business Information</h3>
        <label for="business_name">Business Name :</label>
        <input type="text" name="business_name" id="business_name" required>

        <label for="address">Business Address:</label>
        <input type="text" name="address" id="address" required>

        <label for="type">Business Type:</label>
        <input type="text" name="type" id="type" required>

        <label for="business_license">Business License Number:</label>
        <input type="text" name="business_license" id="business_license" required>

        <label for="establishment_date">Establishment Date:</label>
        <input type="date" name="establishment_date" id="establishment_date" required>

        <!-- Owner Information -->
        <h3>Owner Information</h3>
        <label for="owner">Owner Name:</label>
        <input type="text" name="owner" id="owner" required>

        <label for="contact">Owner's Contact Info:</label>
        <input type="text" name="contact" id="contact" required>

        <label for="email">Owner's Email:</label>
        <input type="email" name="email" id="email" required>

        <label for="tin_number">Owner's TIN Number:</label>
        <input type="text" name="tin_number" id="tin_number" required>

        <!-- Submit Button -->
        <button type="submit" name="submit">Submit</button>
    </form>
</div>

<!-- Style for the Navigation Bar -->
<style>
    /* Style for the whole page */
body {
    font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
}

/* Navigation Bar */
.navbar {
    background-color: #003366;
    padding: 50px 20px;
    font-weight:bold;
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

/* Container that holds the form */
.container {
    max-width: 800px;
    margin: 30px auto;
    padding: 20px;
    background-color: #fff;
    border-radius: 8px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
}

/* Heading styles */
h1 {
    text-align: center;
    color: #333;
    margin-bottom: 30px;
    font-size: 36px;
}

/* Section Titles */
h3 {
    color: #555;
    font-size: 24px;
    margin-bottom: 10px;
}

/* Label styles */
label {
    font-size: 16px;
    color: #333;
    margin-bottom: 5px;
    display: block;
}

/* Input field styles */
input[type="text"], input[type="number"], input[type="date"], select, textarea, input[type="email"] {
    width: 100%;
    padding: 10px;
    margin: 10px 0;
    border: 1px solid #ddd;
    border-radius: 5px;
    box-sizing: border-box;
    font-size: 16px;
}

/* Textarea specific styling */
textarea {
    height: 120px;
}

/* Button styles */
button[type="submit"] {
    background-color: #007bff;
    color: #fff;
    padding: 12px 20px;
    border: none;
    border-radius: 5px;
    font-size: 18px;
    cursor: pointer;
    width: 100%;
    margin-top: 10px;
}

button[type="submit"]:hover {
    background-color: #0056b3;
}

/* Responsive Design: Adjust form width on smaller screens */
@media (max-width: 768px) {
    .container {
        padding: 15px;
    }
}
</style>

</body>
</html>
