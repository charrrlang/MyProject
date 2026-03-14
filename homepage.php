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
        /* 1. Global Reset */
        body { 
            font-family: 'Segoe UI', sans-serif; 
            margin: 0; 
            background-color: #f4f7f6; 
            height: 100vh;
            display: flex;
            flex-direction: column; 
        }
        
        /* 2. Header Styling - Matched to Rules Page */
        header {
            background-color: #b0b1a8; /* Specific grey from your screenshot */
            display: flex;
            padding: 15px 60px; 
            align-items: center;
            justify-content: space-between;
            width: 100%; 
            box-sizing: border-box;
            border-bottom: 1px solid #999;
            z-index: 1000;
        }
        
        .logo-group { display: flex; align-items: center; gap: 20px; }
        .UC-logo { width: 50px; height: auto; }
        .system-title { 
            font-size: 22px; 
            font-weight: bold; 
            color: #1a2fa3; /* UC Blue */
            margin: 0; 
        }

        .auth-group { display: flex; gap: 25px; align-items: center; }
        .nav-link { 
            color: #1a2fa3; 
            text-decoration: none; 
            font-weight: bold; 
            font-size: 15px;
        }
        .nav-link:hover { text-decoration: underline; }
        
        /* Dropdown Styling */
        .dropbtn { 
            background: none; 
            border: none; 
            color: #1a2fa3; 
            cursor: pointer; 
            font-size: 15px; 
            font-weight: bold;
            font-family: inherit; 
            padding: 0;
        }
        .dropdown { position: relative; display: inline-block; }
        .dropdown-content {
            display: none;
            position: absolute;
            background-color: white;
            min-width: 120px;
            box-shadow: 0px 8px 16px rgba(0,0,0,0.2);
            z-index: 1;
        }
        .dropdown-content a { color: black; padding: 12px 16px; text-decoration: none; display: block; }
        .dropdown:hover .dropdown-content { display: block; }

        /* 3. Layout Wrapper */
        .app-body {
            display: flex;
            flex-grow: 1; 
            overflow: hidden;
        }

        /* 4. Sidebar Styling */
        .sidebar {
            width: 280px;
            background-color: #ffffff;
            border-right: 2px solid #1a2fa3;
            padding: 30px 20px;
            display: flex;
            flex-direction: column;
            box-shadow: 2px 0 5px rgba(0,0,0,0.05);
        }

        .sidebar h3 { color: #1a2fa3; border-bottom: 1px solid #eee; padding-bottom: 10px; margin-top: 0; }
        .detail-box { margin-bottom: 20px; }
        .label { font-size: 11px; color: #888; text-transform: uppercase; font-weight: bold; display: block; }
        .value { font-size: 16px; color: #333; font-weight: 600; }

        /* 5. Main Content Area */
        .main-content {
            flex-grow: 1;
            padding: 50px;
            overflow-y: auto; 
        }

        .welcome-card {
            background: white;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            text-align: center;
        }

        /* 6. Footer */
        footer {
            background-color: #2c3e50;
            color: white;
            text-align: center;
            padding: 10px 0;
            font-size: 14px;
        }
    </style>
</head>
<body>

    <header>
        <div class="logo-group">
            <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/6/68/University_of_Cebu_Logo.png/960px-University_of_Cebu_Logo.png" alt="UC logo" class="UC-logo">
            <h1 class="system-title">College of Computer Studies Sit-in Monitoring</h1>
        </div>

        <div class="auth-group">
            <a href="homepage.php" class="nav-link">Home</a>
            <a href="editprofile.php" class="nav-link">Edit Profile</a>
            <a href="History.php" class="nav-link">History</a>
            <a href="reservation.php" class="nav-link">Reservation</a>
            <a href="welcomepage.php" class="nav-link" style="color: #d9534f;">Logout</a>
        </div>
    </header>

    <div class="app-body">
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
        </div>

        <div class="main-content">
            <div class="welcome-card">
                <h1>Welcome, <?php echo $_SESSION['full_name']; ?>!</h1>
                <p>Select an option from the sidebar to manage your sit-in sessions.</p>
            </div>
        </div>
    </div>

    <footer>
        &copy; 2024 College of Computer Studies
    </footer>

</body>
</html>