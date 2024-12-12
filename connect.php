<?php

$con=new mysqli("localhost", "root", "", "barangay_management");

if(!$con){
    
    die(mysqli_error($con));
}

?>