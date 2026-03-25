<?php
session_start();
include 'db_connect.php';

// Check if Admin is logged in
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'Admin') {
    header("Location: login.php");
    exit();
}

// Fetch all pending reservations
// If you still get an error, remove "ORDER BY date DESC" until you fix the DB column names
$sql = "SELECT * FROM sitin_records WHERE status = 'Pending'";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin - Reservation List</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f8f9fa; margin: 0; }
        
        /* Matching UC Admin Navigation */
        .admin-navbar {
            background-color: #004a99; 
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 12px 25px;
            color: white;
        }
        .nav-links { display: flex; align-items: center; gap: 15px; }
        .nav-links a { color: white; text-decoration: none; font-size: 12px; }
        .btn-logout { background-color: #ffc107; color: black !important; padding: 5px 12px; border-radius: 4px; font-weight: bold; }

        .container { padding: 30px; max-width: 1100px; margin: auto; }
        .res-table { width: 100%; border-collapse: collapse; background: white; box-shadow: 0 1px 3px rgba(0,0,0,0.2); }
        .res-table th { background: #004a99; color: white; padding: 12px; text-align: left; font-size: 13px; }
        .res-table td { padding: 12px; border-bottom: 1px solid #eee; font-size: 13px; }
        .btn-approve { background: #28a745; color: white; border: none; padding: 5px 10px; cursor: pointer; border-radius: 3px; font-size: 11px; }
    </style>
</head>
<body>

<nav class="admin-navbar">
    <div style="font-weight:bold;">College of Computer Studies Admin</div>
    <div class="nav-links">
        <a href="admin_dashboard.php">Home</a>
        <a href="student_list.php">Students</a>
        <a href="reservation_admin.php">Reservation</a>
        <a href="welcomepage.php" class="btn-logout">Log out</a>
    </div>
</nav>

<div class="container">
    <h2 style="color: #004a99;">Pending Reservations</h2>
    <table class="res-table">
        <thead>
            <tr>
                <th>ID Number</th>
                <th>Purpose</th>
                <th>Laboratory</th>
                <th>Date</th>
                <th>Time</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($result && $result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    // Safety check for null dates/times to prevent further errors
                    $display_date = isset($row['date']) ? $row['date'] : 'N/A';
                    $display_time = isset($row['time']) ? $row['time'] : 'N/A';
                    
                    echo "<tr>
                            <td>{$row['id_number']}</td>
                            <td>{$row['purpose']}</td>
                            <td>{$row['lab_room']}</td>
                            <td>{$display_date}</td>
                            <td>{$display_time}</td>
                            <td>
                                <form action='update_reservation.php' method='POST'>
                                    <input type='hidden' name='res_id' value='{$row['id']}'>
                                    <button type='submit' name='action' value='Approved' class='btn-approve'>Approve</button>
                                </form>
                            </td>
                          </tr>";
                }
            } else {
                echo "<tr><td colspan='6' style='text-align:center;'>No pending reservations found.</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>

</body>
</html>