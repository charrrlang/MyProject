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

    $stmt = $conn->prepare("INSERT INTO reservations (student_id, purpose, lab_room, reserve_date, reserve_time) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $id_number, $purpose, $lab, $date, $time);
    
    if ($stmt->execute()) {
        $message = "<div style='color: green; margin-bottom: 15px; font-weight: bold;'>Reservation successfully submitted!</div>";
    }
    $stmt->close();
}

$res_query = "SELECT * FROM reservations WHERE student_id = '$id_number' ORDER BY reserve_date DESC";
$res_result = $conn->query($res_query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Reservation - CCS Sit-in Monitoring</title>
    <style>
        /* Global Styles matching your History screenshot */
        html, body { height: 100%; margin: 0; font-family: 'Segoe UI', Arial, sans-serif; background-color: #f4f7f6; }
        
        /* Header styling */
        header {
            background-color: #b0b1a8;
            padding: 10px 50px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid #999;
        }
        .logo-group { display: flex; align-items: center; gap: 10px; }
        .logo-group img { width: 40px; }
        .system-title { color: #1a2fa3; font-weight: bold; font-size: 20px; }
        .nav-links a { color: #1a2fa3; text-decoration: none; font-weight: bold; margin-left: 20px; font-size: 14px; }

        /* Layout Grid */
        .wrapper { display: flex; height: calc(100vh - 65px); }

        /* Sidebar with the blue divider line */
        .sidebar {
            width: 250px;
            background: white;
            border-right: 2px solid #1a2fa3;
            padding: 40px 30px;
        }
        .sidebar h3 { color: #1a2fa3; font-size: 20px; margin-bottom: 25px; }
        .label { font-size: 10px; color: #888; text-transform: uppercase; font-weight: bold; display: block; margin-top: 15px; }
        .value { font-size: 15px; color: #333; font-weight: 600; display: block; margin-bottom: 5px; }

        /* Main Content Container */
        .main-content {
            flex: 1;
            padding: 40px;
            overflow-y: auto;
        }

        /* The White Box Container (Matching your History page) */
        .content-box {
            background: white;
            border-radius: 12px;
            padding: 40px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
            max-width: 1000px;
            margin: 0 auto;
        }

        h2 { color: #000; font-size: 28px; margin-top: 0; margin-bottom: 30px; }

        /* Form Styling */
        .form-row { display: flex; gap: 20px; margin-bottom: 20px; }
        .form-group { flex: 1; }
        .form-group label { display: block; font-size: 11px; font-weight: bold; color: #999; text-transform: uppercase; margin-bottom: 5px; }
        .form-group input { 
            width: 100%; 
            padding: 10px; 
            border: 1px solid #ddd; 
            border-radius: 4px; 
            box-sizing: border-box; 
            font-size: 14px;
        }
        .form-group input[readonly] { background-color: #f9f9f9; color: #666; }

        /* Session Badge */
        .session-badge {
            background: #e3f2fd;
            color: #1a2fa3;
            padding: 8px 15px;
            border-radius: 20px;
            display: inline-block;
            font-size: 13px;
            font-weight: bold;
            margin: 15px 0;
        }

        .btn-submit {
            background-color: #1a2fa3;
            color: white;
            border: none;
            padding: 12px 30px;
            border-radius: 4px;
            font-weight: bold;
            cursor: pointer;
            margin-top: 10px;
        }

        /* Table Styling (Matching your Blue Header Table) */
        .table-section { margin-top: 50px; }
        table { width: 100%; border-collapse: collapse; }
        table th { background-color: #1a2fa3; color: white; text-align: left; padding: 15px; font-size: 13px; }
        table td { padding: 15px; border-bottom: 1px solid #eee; font-size: 14px; }

    </style>
</head>
<body>

<header>
    <div class="logo-group">
        <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/6/68/University_of_Cebu_Logo.png/960px-University_of_Cebu_Logo.png" alt="UC Logo">
        <span class="system-title">College of Computer Studies Sit-in Monitoring</span>
    </div>
    <div class="nav-links">
        <a href="homepage.php">Home</a>
        <a href="editprofile.php">Edit Profile</a>
        <a href="history.php">History</a>
        <a href="reservation.php" style="text-decoration: underline;">Reservation</a>
        <a href="welcomepage.php" style="color: #d9534f;">Logout</a>
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
                    <div class="form-group">
                        <label>ID Number</label>
                        <input type="text" value="<?php echo $id_number; ?>" readonly>
                    </div>
                    <div class="form-group">
                        <label>Student Name</label>
                        <input type="text" value="<?php echo $full_name; ?>" readonly>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label>Purpose</label>
                        <input type="text" name="purpose" placeholder="e.g. Java Programming" required>
                    </div>
                    <div class="form-group">
                        <label>Laboratory</label>
                        <input type="text" name="lab" placeholder="e.g. 524" required>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label>Time In</label>
                        <input type="time" name="time_in" required>
                    </div>
                    <div class="form-group">
                        <label>Date</label>
                        <input type="date" name="date" required>
                    </div>
                </div>

                <div class="session-badge">
                    💻 30 sessions remaining
                </div>

                <div>
                    <button type="submit" name="submit_res" class="btn-submit">Submit Reservation</button>
                </div>
            </form>

            <div class="table-section">
                <h3 style="color: #1a2fa3; border-bottom: 2px solid #eee; padding-bottom: 10px;">My Reservations</h3>
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
                        <?php if ($res_result->num_rows > 0): ?>
                            <?php while($row = $res_result->fetch_assoc()): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($row['purpose']); ?></td>
                                    <td><?php echo htmlspecialchars($row['lab_room']); ?></td>
                                    <td><?php echo date('M d, Y', strtotime($row['reserve_date'])); ?></td>
                                    <td><?php echo date('h:i A', strtotime($row['reserve_time'])); ?></td>
                                    <td style="color: #1a2fa3; font-weight: bold;"><?php echo $row['status']; ?></td>
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