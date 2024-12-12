<?php
$servername = "localhost";  
$username = "root";         
$password = "";             
$dbname = "barangay_management"; 

$con = new mysqli($servername, $username, $password, $dbname);


if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
} else {
    echo "Connected successfully";
}


if (isset($_GET['delete_id'])) {
    $id = $_GET['delete_id'];
    
    $sql = "SELECT image FROM `announcement` WHERE id = $id";
    $result = mysqli_query($con, $sql);
    
    if ($result) {
        $row = mysqli_fetch_assoc($result);
        $imagePath = $row['image'];
        
        if (file_exists($imagePath)) {
            unlink($imagePath);  
        }
        
        $deleteSql = "DELETE FROM `announcement` WHERE id = $id";
        if (mysqli_query($con, $deleteSql)) {
            header('Location: admin_announcements.php?deleted=true');
            exit();
        } else {
            die(mysqli_error($con));
        }
    }
}

if(isset($_POST['submit'])){
    $image = $_POST['image'];

    $sql = "INSERT INTO `announcement` (image) VALUES('$image')";
    $result = mysqli_query($con, $sql);
    if($result){
        header('location: admin_announcements.php?added=true');
        exit();
    } else {
        die(mysqli_error($con));
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <title>Admin Announcement</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
            display: flex;
            flex-direction: column;
            height: 100vh;
        }

        .top-nav {
            background-color: #003366;
            color: white;
            padding: 50px 0px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: fixed;
            width: 100%;
            top: 0;
            z-index: 1000;
        }

        .top-nav .logo {
            font-size: 24px;
            font-weight: bold;
        }

        .top-nav .user-actions a {
            color: white;
            text-decoration: none;
            margin: 0 10px;
        }

        .dashboard-container {
            width: 80%;
            margin: 180px auto 20px;
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            overflow-y: auto;
        }

        h2 {
            color: #003366;
            margin-bottom: 20px;
            text-align: center;
        }

        table {
            width: 100%;
            margin-top: 20px;
            border-collapse: collapse;
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            padding: 12px;
            text-align: left;
        }

        th {
            background-color: #003366;
            color: white;
        }

        .action-buttons a {
            padding: 5px 10px;
            color: white;
            text-decoration: none;
            border-radius: 4px;
            margin: 0 5px;
            font-size: 14px;
        }

        .approve {
            background-color: #4CAF50;
        }

        .approve:hover {
            background-color: #45a049;
        }

        .reject {
            background-color: #f44336;
        }

        .reject:hover {
            background-color: #e53935;
        }

        @media (max-width: 768px) {
            .top-nav {
                flex-direction: column;
                align-items: flex-start;
                padding: 20px;
            }

            .dashboard-container {
                width: 90%;
                margin: 120px auto 20px;
            }

            .action-buttons a {
                font-size: 12px;
                padding: 4px 8px;
            }
        }

        .image {

            display: block;
  margin-left: auto;
  margin-right: auto;

        }
        .table-width{
            width: 50%;
    margin-left: auto;
    margin-right: auto;
        }
        .form-group {
            text-align: center;
        }
        .btns{
            margin-left: auto;  
            margin-right: auto;
            display: block;
            border-radius: 10px;
            height: 8%;
            width: 8%;
        }
        .form-control{
            width: 25%;
            height: 7%;
            margin-left: auto;  
            margin-right: auto;
            display: block;
        }

        
    </style>
</head>
<body>
<div class="top-nav">
        <div class="logo">Admin Panel</div>
        <div class="user-actions">
            <a href="admin_dashboard.php"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
            <a href="admin_announcements.php"><i class="fas fa-bullhorn"></i> Announcements</a>
            <a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
        </div>
    </div>
        </div>
        </div>
    </div>

    <div class="dashboard-container">

        <h2>Add Announcement</h2>

        <form method="POST">
            <div class="form-group">
                <input type="file" class="form-control" id="image" name="image" required>
            </div>
            <button type="submit" class="btns btn-primary" name="submit">Submit</button>
        </form>

        <table class="table-width">
            <thead>
                <tr>
                    <th style="text-align: center;">Announcement</th>
                    <th style="text-align: center;">Action</th>
                </tr>
            </thead>
            <tbody>

            <?php
            $sql = "SELECT * FROM `announcement`";
            $result = mysqli_query($con, $sql);
            if ($result) {
                while ($row = mysqli_fetch_assoc($result)) {
                    $id = $row['id'];
                    $image = $row['image'];

                    echo '<tr>
                        <td><img src="' . $image . '" alt="Image" width="550" height="350" class="image"></td>
                        <td>
                            <a href="admin_announcements.php?delete_id=' . $id . '" class="btn-delete" onclick="return confirm(\'Are you sure you want to delete this announcement?\')">Delete</a>
                        </td>
                    </tr>';
                }
            }
            ?>

            </tbody>
        </table>
    </div>
</body>
</html>
