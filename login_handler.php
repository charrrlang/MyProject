<?php
session_start();
include 'db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // 1. Basic Server-side validation to ensure fields aren't empty
    if (empty($_POST['username']) || empty($_POST['password'])) {
        echo "<script>alert('Please fill in all fields'); window.history.back();</script>";
        exit();
    }

    $username = $_POST['username'];
    $password = $_POST['password'];

    // 2. Fetch the user from the database
    // Note: Ensure 'userName' matches your phpMyAdmin column exactly
    $sql = "SELECT * FROM Users WHERE userName = '$username'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        
        // 3. Use password_verify to check the hashed password
        if (password_verify($password, $row['Password'])) {
            $_SESSION['user_id'] = $row['Id'];
            $_SESSION['user_name'] = $row['userName'];
            
            echo "<script>alert('Login Successful!'); window.location='dashboard.php';</script>";
        } else {
            echo "<script>alert('Incorrect Password'); window.history.back();</script>";
        }
    } else {
        echo "<script>alert('User not found'); window.history.back();</script>";
    }

    $conn->close();
}
?>