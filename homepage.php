<?php
session_start();
if (!isset($_SESSION['id_number'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard - Sit-in Monitoring</title>
    <style>
        body { 
            font-family: 'Segoe UI', sans-serif; 
            margin: 0; 
            display: flex; /* Creates the side-by-side layout */
            background-color: #f4f7f6; 
            height: 100vh;
        }
        
        /* 1. Sidebar Styling */
        .sidebar {
            width: 280px;
            background-color: #ffffff;
            border-right: 2px solid #1a2fa3;
            padding: 30px 20px;
            display: flex;
            flex-direction: column;
            box-shadow: 2px 0 5px rgba(0,0,0,0.05);
        }

        .sidebar h3 {
            color: #1a2fa3;
            font-size: 18px;
            margin-bottom: 25px;
            border-bottom: 1px solid #eee;
            padding-bottom: 10px;
        }

        .detail-box {
            margin-bottom: 20px;
        }

        .label { 
            font-size: 11px; 
            color: #888; 
            text-transform: uppercase; 
            font-weight: bold; 
            display: block;
            margin-bottom: 4px;
        }

        .value { 
            font-size: 16px; 
            color: #333; 
            font-weight: 600; 
        }

        .logout-section {
            margin-top: auto; /* Pushes logout to the bottom */
            padding-top: 20px;
            border-top: 1px solid #eee;
        }

        .logout-btn {
            color: #d9534f;
            text-decoration: none;
            font-weight: bold;
            display: block;
            text-align: center;
            padding: 10px;
            border: 1px solid #d9534f;
            border-radius: 5px;
            transition: 0.3s;
        }

        .logout-btn:hover {
            background-color: #d9534f;
            color: white;
        }

        /* 2. Main Content Styling */
        .main-content {
            flex-grow: 1; /* Takes up the remaining space */
            padding: 50px;
            text-align: center;
        }

        .welcome-card {
            background: white;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }
    </style>
</head>
<body>

    <div class="sidebar">
        <h3>Student Profile</h3>
        
        <div class="detail-box">
            <span class="label">ID Number</span>
            <span class="value"><?php echo $_SESSION['id_number']; ?></span>
        </div>

        <div class="detail-box">
            <span class="label">Student Name</span>
            <span class="value"><?php echo $_SESSION['full_name']; ?></span>
        </div>

        <div class="detail-box">
            <span class="label">Course & Year</span>
            <span class="value"><?php echo $_SESSION['course'] . " - " . $_SESSION['course_lvl']; ?></span>
        </div>

        <div class="detail-box">
            <span class="label">Email Address</span>
            <span class="value"><?php echo $_SESSION['email_address']; ?></span>
        </div>

        <div class="logout-section">
            <a href="logout.php" class="logout-btn">Logout</a>
        </div>
    </div>

    <div class="main-content">
        <div class="welcome-card">
            <h1>Welcome, <?php echo $_SESSION['full_name']; ?>!</h1>
            <p>Select an option from the sidebar to manage your sit-in sessions.</p>
        </div>
    </div>

</body>
</html>