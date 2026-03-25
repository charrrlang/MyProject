<?php
session_start();
include 'db_connect.php';

// Check if Admin is logged in
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'Admin') {
    header("Location: login.php");
    exit();
}

// 1. Fetch Stats for Home View
$total_students = $conn->query("SELECT COUNT(*) as count FROM users")->fetch_assoc()['count'];
$active_sitin = $conn->query("SELECT COUNT(*) as count FROM sitin_records WHERE status = 'Approved'")->fetch_assoc()['count'];

// 2. Fetch Pie Chart Data
$chart_sql = $conn->query("SELECT purpose, COUNT(*) as count FROM sitin_records GROUP BY purpose");
$purposes = []; $counts = [];
while($row = $chart_sql->fetch_assoc()) {
    $purposes[] = $row['purpose'];
    $counts[] = $row['count'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard - CCS Sit-in</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f8f9fa; margin: 0; }
        
        /* Navigation Bar matching image_8c2dfe.jpg */
        .admin-navbar {
            background-color: #004a99; 
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 12px 25px;
            color: white;
        }
        .nav-brand { font-weight: bold; font-size: 14px; }
        .nav-links { display: flex; align-items: center; gap: 15px; }
        .nav-links a { color: white; text-decoration: none; font-size: 12px; cursor: pointer; }
        .nav-links a:hover { text-decoration: underline; color: #ffcd56; }
        .btn-logout { 
            background-color: #ffc107; color: black !important; 
            padding: 5px 12px; border-radius: 4px; font-weight: bold; 
        }

        /* Layout containers */
        .home-content { display: flex; gap: 20px; padding: 25px; max-width: 1200px; margin: auto; }
        .search-content { display: none; padding: 50px; text-align: center; } /* Hidden by default */
        
        .card { background: white; border-radius: 4px; box-shadow: 0 1px 3px rgba(0,0,0,0.2); flex: 1; border: 1px solid #ddd; }
        .card-header { background: #007bff; color: white; padding: 10px; font-weight: bold; font-size: 14px; }
        .card-body { padding: 20px; }

        /* Search Input Styling */
        .search-box { padding: 12px; width: 350px; border: 2px solid #004a99; border-radius: 5px; font-size: 16px; }
        .btn-search { padding: 12px 25px; background: #004a99; color: white; border: none; border-radius: 5px; cursor: pointer; font-weight: bold; }
    </style>
</head>
<body>

<nav class="admin-navbar">
    <div class="nav-brand">College of Computer Studies Admin</div>
    <div class="nav-links">
        <a onclick="showView('home')">Home</a>
        <a onclick="showView('search')">Search</a>
        <a href="student_list.php">Students</a>
        <a onclick="showView('search')">Sit-in</a>
        <a href="view_sitin_records.php">View Sit-in Records</a>
        <a href="sitin_reports.php">Sit-in Reports</a>
        <a href="feedback_reports.php">Feedback Reports</a>
        <a href="reservation_admin.php">Reservation</a>
        <a href="welcomepage.php" class="btn-logout">Log out</a>
    </div>
</nav>

<div id="home-view" class="home-content">
    <div class="card">
        <div class="card-header">📊 Statistics</div>
        <div class="card-body">
            <p><b>Students Registered:</b> <?php echo $total_students; ?></p>
            <p><b>Currently Sit-in:</b> <?php echo $active_sitin; ?></p>
            <p><b>Total Sit-in:</b> 15</p>
            <div style="height: 250px;"><canvas id="purposeChart"></canvas></div>
        </div>
    </div>
    <div class="card">
        <div class="card-header">📢 Announcement</div>
        <div class="card-body">
            <form action="post_announcement.php" method="POST">
                <textarea name="content" style="width:100%; height:80px;" placeholder="New Announcement"></textarea><br>
                <button type="submit" style="background:#28a745; color:white; border:none; padding:8px; margin-top:10px; cursor:pointer;">Submit</button>
            </form>
            <h4 style="border-bottom:1px solid #eee; margin-top:20px;">Posted Announcement</h4>
            <p style="font-size:11px; color:#666;">CCS Admin | 2026-Feb-11</p>
            <p>Welcome to the CCS Sit-in Monitoring System!</p>
        </div>
    </div>
</div>

<div id="search-view" class="search-content">
    <h1 style="color: #004a99; margin-bottom: 30px;">Search Student</h1>
    <form action="admin_dashboard.php" method="GET">
        <input type="text" name="search_id" class="search-box" placeholder="Enter ID Number (e.g. 213000)..." required>
        <button type="submit" name="search" class="btn-search">Search</button>
    </form>

    <?php
    if (isset($_GET['search'])) {
        // If a search is made, ensure we stay in the Search View
        echo "<script>document.addEventListener('DOMContentLoaded', function() { showView('search'); });</script>";
        
        $search_id = $_GET['search_id'];
        $user_res = $conn->query("SELECT * FROM users WHERE Id = '$search_id'");
        
        if ($user = $user_res->fetch_assoc()) {
            $res_query = $conn->query("SELECT * FROM sitin_records WHERE id_number = '$search_id' AND status = 'Pending' LIMIT 1");
            $reservation = $res_query->fetch_assoc();

            echo "
            <div class='card' style='max-width: 500px; margin: 40px auto; text-align: left; border-top: 5px solid #28a745;'>
                <div class='card-header' style='background:#28a745'>Sit In Form</div>
                <div class='card-body'>
                    <form action='process_sitin.php' method='POST'>
                        <p><b>Student Name:</b> {$user['FullName']}</p>
                        <p><b>ID Number:</b> {$user['Id']}</p>
                        <input type='hidden' name='id_number' value='{$user['Id']}'>
                        
                        <label>Purpose:</label><br>
                        <input type='text' name='purpose' value='" . ($reservation['purpose'] ?? '') . "' required style='width:95%; padding:10px; margin-bottom:15px;'><br>
                        
                        <label>Lab Room:</label><br>
                        <input type='text' name='lab_room' value='" . ($reservation['lab_room'] ?? '') . "' required style='width:95%; padding:10px; margin-bottom:15px;'><br>
                        
                        <p><b>Remaining Sessions:</b> {$user['SessionsRemaining']}</p>
                        <button type='submit' style='background:#28a745; color:white; width:100%; padding:15px; border:none; font-weight:bold; cursor:pointer;'>CONFIRM SIT-IN</button>
                    </form>
                </div>
            </div>";
        } else {
            echo "<p style='color:red; font-weight:bold; margin-top:20px;'>No student found with ID: " . htmlspecialchars($search_id) . "</p>";
        }
    }
    ?>
</div>

<script>
    // Logic to toggle between Home and Search views
    function showView(viewName) {
        if (viewName === 'search') {
            document.getElementById('home-view').style.display = 'none';
            document.getElementById('search-view').style.display = 'block';
        } else {
            document.getElementById('home-view').style.display = 'flex';
            document.getElementById('search-view').style.display = 'none';
        }
    }

    // Pie Chart Logic
    const ctx = document.getElementById('purposeChart').getContext('2d');
    new Chart(ctx, {
        type: 'pie',
        data: {
            labels: <?php echo json_encode($purposes); ?>,
            datasets: [{
                data: <?php echo json_encode($counts); ?>,
                backgroundColor: ['#36a2eb', '#ff6384', '#ffcd56', '#4bc0c0', '#9966ff']
            }]
        },
        options: { responsive: true, maintainAspectRatio: false }
    });
</script>

</body>
</html>