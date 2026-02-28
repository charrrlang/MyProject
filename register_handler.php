<?php
include 'db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // 1. Collect data from your register.php form
    $id = $_POST['id_number'];
    $fullname = $_POST['fullname'];
    $uname = $_POST['username'];
    $course_lvl = $_POST['course_level'];
    $course = $_POST['course'];
    $email = $_POST['email'];
    

    // 2. Hash the password for security
    // This creates a long, secure string that cannot be reversed
    $pass = $_POST['password']; 
    $hashed_pass = password_hash($pass, PASSWORD_DEFAULT);

    // 3. SQL to insert data into the 'Users' table
    // Note: 'userName' must match the column name in your phpMyAdmin exactly
    $sql = "INSERT INTO Users (Id, userName, fullName, CourseLvl, Course, EmailAddress, Password) 
            VALUES ('$id', '$uname', '$fullname', '$course_lvl', '$course', '$email', '$hashed_pass')";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Account Created Successfully!'); window.location='login.php';</script>";
    } else {
        echo "Error: " . $conn->error;
    }

    $conn->close();
}
?>