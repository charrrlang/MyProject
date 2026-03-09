<?php
include 'db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // 1. Collect data from your register.php form
    $Id = $_POST['id_number'];
    $FullName = $_POST['fullname'];
    $UserName = $_POST['username'];
    $CourseLevel = $_POST['course_level'];
    $Course = $_POST['course'];
    $EmailAddress = $_POST['email'];
    

    // 2. Hash the password for security
    // This creates a long, secure string that cannot be reversed
    $pass = $_POST['password']; 
    $Password = password_hash($pass, PASSWORD_DEFAULT);

    // 3. SQL to insert data into the 'Users' table
    // Note: 'userName' must match the column name in your phpMyAdmin exactly
    $sql = "INSERT INTO Users (Id, UserName, FullName, CourseLevel, Course, EmailAddress, Password) 
            VALUES ('$Id', '$UserName', '$FullName', '$CourseLevel', '$Course', '$EmailAddress', '$Password')";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Account Created Successfully!'); window.location='login.php';</script>";
    } else {
        echo "Error: " . $conn->error;
    }

    $conn->close();
}
?>