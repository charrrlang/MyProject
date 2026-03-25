<?php
session_start();
include 'db_connect.php';

if (!isset($_SESSION['id_number'])) {
    header("Location: login.php");
    exit();
}

$id_number = $_SESSION['id_number'];
$full_name = $_SESSION['full_name'];
$message = "";

// Handle Submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit_res'])) {
    $purpose = $_POST['purpose'];
    $lab = $_POST['lab'];
    $time = $_POST['time_in'];
    $date = $_POST['date'];
    $status = "Pending"; // Matches what the admin filters for

    // Use sitin_records table to sync with Admin Panel
    $stmt = $conn->prepare("INSERT INTO sitin_records (id_number, purpose, lab_room, date, time, status) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssss", $id_number, $purpose, $lab, $date, $time, $status);
    
    if ($stmt->execute()) {
        $message = "<div style='color: green; margin-bottom: 15px; font-weight: bold;'>Reservation successfully submitted!</div>";
    }
    $stmt->close();
}

// Fetch from the unified table
$res_query = "SELECT * FROM sitin_records WHERE id_number = '$id_number' ORDER BY date DESC";
$res_result = $conn->query($res_query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Reservation - CCS Sit-in Monitoring</title>
    <style>
        /* Keep your existing CSS here */
        html, body { height: 100%; margin: 0; font-family: 'Segoe UI', Arial, sans-serif; background-color: #f4f7f6; }
        header { background-color: #b0b1a8; padding: 10px 50px; display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid #999; }
        .system-title { color: #1a2fa3; font-weight: bold; font-size: 20px; }
        .nav-links a { color: #1a2fa3; text-decoration: none; font-weight: bold; margin-left: 20px; font-size: 14px; }
        .wrapper { display: flex; height: calc(100vh - 65px); }
        .sidebar { width: 250px; background: white; border-right: 2px solid #1a2fa3; padding: 40px 30px; }
        .main-content { flex: 1; padding: 40px; overflow-y: auto; }
        .content-box { background: white; border-radius: 12px; padding: 40px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); max-width: 1000px; margin: 0 auto; }
        .form-row { display: flex; gap: 20px; margin-bottom: 20px; }
        .form-group { flex: 1; }
        .form-group label { display: block; font-size: 11px; font-weight: bold; color: #999; text-transform: uppercase; margin-bottom: 5px; }
        .form-group input { width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px; box-sizing: border-box; }
        .btn-submit { background-color: #1a2fa3; color: white; border: none; padding: 12px 30px; border-radius: 4px; font-weight: bold; cursor: pointer; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        table th { background-color: #1a2fa3; color: white; padding: 15px; text-align: left; }
        table td { padding: 15px; border-bottom: 1px solid #eee; }
    </style>
</head>
<body>

<header>
    <div class="logo-group">
        <span class="system-title">College of Computer Studies Sit-in Monitoring</span>
    </div>
    <div class="nav-links">
        <a href="homepage.php">Home</a>
        <a href="editprofile.php">Edit Profile</a>
        <a href="history.php">History</a>
        <a href="reservation.php" style="text-decoration: underline;">Reservation</a>
        <a href="logout.php" style="color: #d9534f;">Logout</a>
    </div>
</header>

<div class="wrapper">
    <div class="sidebar">
        <h3>Student Profile</h3>
        <span class="label">ID Number</span>
        <span class="value"><?php echo $id_number; ?></span>
        <span class="label">Student Name</span>
        <span class="value"><?php echo $full_name; ?></span>
    </div>

    <div class="main-content">
        <div class="content-box">
            <h2>Reservation</h2>
            <?php echo $message; ?>

            <form method="POST">
                <div class="form-row">
                    <div class="form-group"><label>Purpose</label><input type="text" name="purpose" required></div>
                    <div class="form-group"><label>Laboratory</label><input type="text" name="lab" required></div>
                </div>
                <div class="form-row">
                    <div class="form-group"><label>Time In</label><input type="time" name="time_in" required></div>
                    <div class="form-group"><label>Date</label><input type="date" name="date" required></div>
                </div>
                <button type="submit" name="submit_res" class="btn-submit">Submit Reservation</button>
            </form>

            <div class="table-section">
                <h3 style="color: #1a2fa3; border-bottom: 2px solid #eee; padding-bottom: 10px; margin-top: 40px;">My Reservations</h3>
                <table>
                    <thead>
                        <tr>
                            <th>Purpose</th>
                            <th>Lab</th>
                            <th>Date</th>
                            <th>Time</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($res_result && $res_result->num_rows > 0): ?>
                            <?php while($row = $res_result->fetch_assoc()): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($row['purpose']); ?></td>
                                    <td><?php echo htmlspecialchars($row['lab_room']); ?></td>
                                    <td><?php echo date('M d, Y', strtotime($row['date'])); ?></td>
                                    <td><?php echo date('h:i A', strtotime($row['time'])); ?></td>
                                    <td style="font-weight: bold; color: <?php echo ($row['status'] == 'Approved') ? '#28a745' : '#1a2fa3'; ?>;">
                                        <?php echo $row['status']; ?>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr><td colspan="5" style="text-align: center; color: #999;">No reservations found.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
</body>
</html>