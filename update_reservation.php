<?php
include 'db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['res_id'])) {
    $res_id = $_POST['res_id'];
    $new_status = $_POST['action']; // This will be 'Approved'

    // Update the status in the sitin_records table
    $stmt = $conn->prepare("UPDATE sitin_records SET status = ? WHERE id = ?");
    $stmt->bind_param("si", $new_status, $res_id);

    if ($stmt->execute()) {
        // Redirect back to the reservation list with a success message
        header("Location: reservation_admin.php?msg=Success");
    } else {
        echo "Error updating record: " . $conn->error;
    }
    $stmt->close();
}
$conn->close();
?>