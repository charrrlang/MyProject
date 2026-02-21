<?php
session_start(); // Allows the user to stay logged in across pages
require_once 'config.php';
include 'config.php';


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user = $_POST['username'];
    $pass = $_POST['password'];

    try {
        // 1. Find the user by username
        $sql = "SELECT * FROM users WHERE username = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$user]);
        $userData = $stmt->fetch();

        // 2. Check if user exists and verify password
        if ($userData && password_verify($pass, $userData['password'])) {
            // Success! Store user info in the session
            $_SESSION['user_id'] = $userData['id'];
            $_SESSION['username'] = $userData['username'];
            
            // Redirect to your welcome page
            header("Location: welcomepage.php");
            exit;
        } else {
            echo "<script>alert('Invalid username or password!');</script>";
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <style>
        a {
            text-decoration: none;
        }

        /* 2. Basic styling for the body */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        /* 3. Style the form container */
        form {
            border: 1px solid #ccc;
            padding: 20px;
            border-radius: 4px;
            width: 300px;
            margin-top: 50px;
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        /* 4. Style the inputs */
        input {
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        /* 5. Style the Login Button */
        button {
            background-color: #1a2fa3;
            color: white;
            border: none;
            padding: 10px;
            border-radius: 4px;
            cursor: pointer;
        }

        button:hover {
            background-color: #218838;
        }

        /* 6. Style the Cancel Link to look like a button */
        .btn-cancel {
            background-color: #f8f9fa;
            color: #333;
            border: 1px solid #ccc;
            padding: 10px;
            border-radius: 4px;
            text-align: center;
            display: inline-block;
        }

        .btn-cancel:hover {
            background-color: #e2e6ea;
        }
    </style>
</head>
<body>

<h2>Login Form</h2>

<form method="POST">
    <input type="text" name="username" placeholder="Username">
    <input type="password" name="password" placeholder="Password">
    <button type="submit">Login</button>
</form>

</body>
</html>
