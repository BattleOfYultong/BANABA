<?php
// Connect to the database
include 'clearance_connect.php';

if (isset($_POST['submit'])) {
    // Collect form data
    $full_name = $_POST['full_name'];
    $address = $_POST['address'];
    $contact_number = $_POST['contact_number'];
    $gender = $_POST['gender'];
    $civil_status = $_POST['civil_status'];
    $job = $_POST['job'];
    $valid_id_type = $_POST['valid_id_type'];
    $id_number = $_POST['id_number'];
    $purpose = $_POST['purpose'];
    $occupation = $_POST['occupation'];
    $years_residency = $_POST['years_residency'];
    $household_head = $_POST['household_head'];

    // Prepared statement to prevent SQL injection
    $stmt = $con->prepare("INSERT INTO barangay_clearance (full_name, address, contact_number, gender, civil_status, job, valid_id_type, id_number, purpose, occupation, years_residency, household_head) 
                           VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

    // Bind parameters
    $stmt->bind_param("ssssssssssss", $full_name, $address, $contact_number, $gender, $civil_status, $job, $valid_id_type, $id_number, $purpose, $occupation, $years_residency, $household_head);

    // Execute the query
    if ($stmt->execute()) {
        // Success: Show an alert and redirect to the form
        echo "<script>
                alert('Form submitted successfully!');
                window.location.href = 'barangay_clearance_form.php';
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
    <title>Barangay Clearance Form</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<!-- Top Navigation Bar -->
<nav class="navbar">
<p style="font-weight: bold; color: white; margin-left: 760px; font-size: 38px;">Barangay Banaba</p>

    <ul>
    <li><a href="resident_dashboard.php">Dashboard</a></li>

    </ul>
</nav>

<!-- Form Container -->
<div class="container">
    <h1>Barangay Clearance Form</h1>

    <form method="POST">
        <!-- Applicant's Personal Information -->
        <h3>Applicant's Personal Information</h3>
        <label for="full_name">Full Name (First, Middle, Last):</label>
        <input type="text" name="full_name" id="full_name" required>

        <label for="address">Complete Residential Address:</label>
        <input type="text" name="address" id="address" required>

        <label for="contact_number">Contact Number (Mobile or Landline):</label>
        <input type="text" name="contact_number" id="contact_number" required>

        <label for="gender">Gender:</label>
        <select name="gender" id="gender" required>
            <option value="Male">Male</option>
            <option value="Female">Female</option>
        </select>

        <label for="civil_status">Civil Status:</label>
        <select name="civil_status" id="civil_status" required>
            <option value="Single">Single</option>
            <option value="Married">Married</option>
            <option value="Widowed">Widowed</option>
            <option value="Divorced">Divorced</option>
        </select>

        <label for="job">Date of Birth:</label>
        <input type="date" name="job" id="bob" required>

        <h3>Identification Details</h3>
        <label for="valid_id_type">Valid ID Presented:</label>
        <select name="valid_id_type" id="valid_id_type" required>
            <option value="Driver's License">Driver's License</option>
            <option value="Philippine Passport">Philippine Passport</option>
            <option value="Unified Multi-Purpose ID (UMID)">Unified Multi-Purpose ID (UMID)</option>
            <option value="Social Security System (SSS) ID">Social Security System (SSS) ID</option>
            <option value="Government Service Insurance System (GSIS) ID">Government Service Insurance System (GSIS) ID</option>
            <option value="Postal ID">Postal ID</option>
            <option value="Philippine Identification (PhilID)">Philippine Identification (PhilID)</option>
            <option value="Voter's ID">Voter's ID</option>
            <option value="Taxpayer's Identification Number (TIN) ID">Taxpayer's Identification Number (TIN) ID</option>
            <option value="Senior Citizen ID">Senior Citizen ID</option>
            <option value="Person with Disability (PWD) ID">Person with Disability (PWD) ID</option>
            <option value="Professional Regulation Commission (PRC) ID">Professional Regulation Commission (PRC) ID</option>
            <option value="School ID (for students)">School ID (for students)</option>
            <option value="National Bureau of Investigation (NBI) Clearance">National Bureau of Investigation (NBI) Clearance</option>
            <option value="Barangay ID">Barangay ID</option>
            <option value="PhilHealth ID">PhilHealth ID</option>
            <option value="Pag-IBIG ID">Pag-IBIG ID</option>
            <option value="Company ID">Company ID</option>
            <option value="Police Clearance">Police Clearance</option>
            <option value="Firearms License ID">Firearms License ID</option>
            <option value="Overseas Employment Certificate (OEC)">Overseas Employment Certificate (OEC)</option>
            <option value="Seaman's Book">Seaman's Book</option>
            <option value="Other">Other</option>
        </select>

        <label for="id_number">ID Number:</label>
        <input type="text" name="id_number" id="id_number" required>

        <!-- Purpose of Clearance -->
        <h3>Purpose of Clearance</h3>
        <label for="purpose">Purpose:</label>
        <select name="purpose" id="purpose" required>
            <option value="Job Application">Job Application</option>
            <option value="Business Permit">Business Permit</option>
            <option value="Loan Application">Loan Application</option>
            <option value="Scholarship">Scholarship</option>
            <option value="Barangay Permit">Barangay Permit</option>
            <option value="Voter's Registration">Voter's Registration</option>
            <option value="Travel Abroad">Travel Abroad</option>
            <option value="License Application">License Application</option>
            <option value="Police Clearance Requirement">Police Clearance Requirement</option>
            <option value="Financial Assistance">Financial Assistance</option>
            <option value="Barangay Residency Certification">Barangay Residency Certification</option>
            <option value="Court Requirement">Court Requirement</option>
            <option value="Loan Release">Loan Release</option>
            <option value="Immigration Requirement">Immigration Requirement</option>
            <option value="Other">Other</option>
        </select>

        <!-- Supporting Information -->
        <h3>Supporting Information</h3>
        <label for="occupation">Occupation or Source of Income:</label>
        <input type="text" name="occupation" id="occupation" required>

        <label for="years_residency">Years of Residency in the Barangay:</label>
        <input type="number" name="years_residency" id="years_residency" required>

        <label for="household_head">Are you the Household Head?</label>
        <select name="household_head" id="household_head" required>
            <option value="Yes">Yes</option>
            <option value="No">No</option>
        </select>

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
    display: flex;
    justify-content: center;
    text-align: right;
    margin-left: 1200px;
    margin-top: -80px;
    

}

.navbar ul li {
    margin-right: 20px;
    text-align: right;

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
input[type="text"], input[type="number"], input[type="date"], select, textarea {
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
