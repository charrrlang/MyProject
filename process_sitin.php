<?php
session_start();
include 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Collect data from the form
    $id = $_POST['id_number'];
    $name = $_POST['fullname'];
    $purpose = $_POST['purpose'];
    $lab = $_POST['lab_room'];

    // This is the SQL query you asked about
    $sql = "INSERT INTO sitin_records (id_number, fullname, purpose, lab_room, login_time, status) 
            VALUES ('$id', '$name', '$purpose', '$lab', NOW(), 'Pending')";

    if ($conn->query($sql)) {
        // Redirect back to the dashboard with a success message
        header("Location: admin_dashboard.php?msg=request_sent");
        exit();
    } else {
        echo "Error: " . $conn->error;
    }
}
?>