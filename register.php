<?php
require_once 'config.php';
include 'db_connection.php';


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user = $_POST['username'];
    $email = $_POST['email'];
    $pass = $_POST['password'];
    $confirm = $_POST['confirm_password'];

    if ($pass !== $confirm) {
        echo "<script>alert('Passwords do not match!');</script>";
    } else {
        // Securely hash the password
        $hashed_pass = password_hash($pass, PASSWORD_DEFAULT);

        try {
            $sql = "INSERT INTO users (username, email, password) VALUES (?, ?, ?)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$user, $email, $hashed_pass]);
            
            echo "<script>alert('Registration Successful!'); window.location='login.php';</script>";
        } catch (PDOException $e) {
            echo "<script>alert('Error: Username or Email already exists.');</script>";
        }
    }
}
?>


<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
    <style>
        /* 1. Global fix: Remove underline from ALL links */
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
            background-color: #f4f4f4;
        }

        /* 3. Style the form container */
        form {
            background: white;
            border: 1px solid #ccc;
            padding: 30px;
            border-radius: 8px;
            width: 320px;
            margin-top: 50px;
            display: flex;
            flex-direction: column;
            gap: 15px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }

        h2 {
            text-align: center;
            margin-top: 0;
        }

        /* 4. Style the inputs */
        input {
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 14px;
        }

        /* 5. Style the Register Button */
        button {
            background-color: #1a2fa3; /* Matches your green theme */
            color: white;
            border: none;
            padding: 12px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            font-weight: bold;
        }

        button:hover {
            background-color: #218838;
        }

        /* 6. Style the Cancel Link to look like a button */
        .btn-cancel {
            background-color: #ffffff;
            color: #333;
            border: 1px solid #ccc;
            padding: 10px;
            border-radius: 4px;
            text-align: center;
            display: inline-block;
            font-size: 14px;
        }

        .btn-cancel:hover {
            background-color: #f1f1f1;
        }
    </style>
</head>
<body>

<form method="POST">
    <h2>Create Account</h2>
    
    <input type="text" name="username" placeholder="Username" required>
    <input type="email" name="email" placeholder="Email Address" required>
    <input type="password" name="password" placeholder="Password" required>
    <input type="password" name="confirm_password" placeholder="Confirm Password" required>
    
    <button type="submit">Register</button>
    
    <a href="index.html" class="btn-cancel">Cancel</a>
</form>

</body>
</html>