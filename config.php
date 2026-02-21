<?php
$host = "localhost";
$dbname = "user_system"; // Matches the database in your screenshot
$username = "root";      // Default XAMPP username
$password = "";          // Default XAMPP password is empty

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    // Set error mode so we can see if something goes wrong
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Could not connect to the database: " . $e->getMessage());
}
?>