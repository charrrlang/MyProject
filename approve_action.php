<?php
include 'db_connect.php';

if (isset($_GET['id']) && isset($_GET['action'])) {
    $id = $_GET['id'];
    $new_status = ($_GET['action'] == 'approve') ? 'Approved' : 'Rejected';

    $sql = "UPDATE sitin_records SET status = '$new_status' WHERE id = '$id'";
    
    if ($conn->query($sql)) {
        header("Location: view_requests.php?msg=updated");
    } else {
        echo "Error: " . $conn->error;
    }
}
?>