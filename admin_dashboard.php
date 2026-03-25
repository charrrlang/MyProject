<?php
session_start();
include 'db_connect.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'Admin') {
    header("Location: login.php");
    exit();
}

$search = isset($_POST['search_input']) ? $_POST['search_input'] : "";
// Fetch students and their remaining sessions
$students = $conn->query("SELECT Id, FullName, Course, CourseLevel, SessionsRemaining FROM Users WHERE Id LIKE '%$search%' OR FullName LIKE '%$search%' LIMIT 5");

$active_sessions = $conn->query("SELECT * FROM sitin_records WHERE status = 'Active'");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin - Sit-in Management</title>
    <style>
        body { font-family: 'Segoe UI', sans-serif; background: #f4f7f6; margin: 0; }
        header { background: #b0b1a8; padding: 15px 50px; display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid #999; }
        .admin-wrapper { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; padding: 30px; }
        .admin-card { background: white; padding: 20px; border-radius: 10px; box-shadow: 0 4px 10px rgba(0,0,0,0.1); }
        h3 { color: #1a2fa3; margin-top: 0; border-bottom: 2px solid #f4f7f6; padding-bottom: 10px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th { background: #1a2fa3; color: white; padding: 10px; text-align: left; font-size: 12px; }
        td { padding: 10px; border-bottom: 1px solid #eee; font-size: 13px; }
        
        /* Session Counter Styles */
        .count-badge { padding: 2px 8px; border-radius: 10px; font-weight: bold; font-size: 11px; }
        .count-ok { background: #d4edda; color: #155724; }
        .count-low { background: #fff3cd; color: #856404; }
        .count-empty { background: #f8d7da; color: #721c24; }

        .btn { padding: 6px 12px; border-radius: 4px; text-decoration: none; font-weight: bold; font-size: 11px; color: white; border: none; cursor: pointer; display: inline-block; }
        .btn-start { background: #28a745; }
        .btn-disabled { background: #ccc; cursor: not-allowed; }
        .btn-end { background: #d9534f; }
    </style>
</head>
<body>

<header>
    <h2 style="color: #1a2fa3; margin: 0;">CCS Admin Dashboard</h2>
    <a href="welcomepage.php" style="color: #d9534f; font-weight: bold; text-decoration: none;">Logout</a>
</header>

<div class="admin-wrapper">
    <div class="admin-card">
        <h3>Search & Initiate</h3>
        <form method="POST" style="margin-bottom: 15px;">
            <input type="text" name="search_input" placeholder="Search ID/Name..." value="<?php echo htmlspecialchars($search); ?>" style="padding: 8px; width: 60%; border: 1px solid #ddd; border-radius: 4px;">
            <button type="submit" style="background:#1a2fa3; color:white; border:none; padding:8px 15px; border-radius:4px; cursor:pointer;">Search</button>
        </form>
        <table>
            <thead><tr><th>ID</th><th>Name</th><th>Sess. Left</th><th>Action</th></tr></thead>
            <tbody>
                <?php while($row = $students->fetch_assoc()): 
                    $remaining = $row['SessionsRemaining'];
                    $class = ($remaining > 10) ? 'count-ok' : (($remaining > 0) ? 'count-low' : 'count-empty');
                ?>
                <tr>
                    <td><?php echo $row['Id']; ?></td>
                    <td><?php echo $row['FullName']; ?></td>
                    <td><span class="count-badge <?php echo $class; ?>"><?php echo $remaining; ?></span></td>
                    <td>
                        <?php if($remaining > 0): ?>
                            <a href="initiate_session.php?id=<?php echo $row['Id']; ?>" class="btn btn-start">Start</a>
                        <?php else: ?>
                            <span class="btn btn-disabled" title="No sessions remaining">Start</span>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

    <div class="admin-card">
        <h3>Current Sit-in Sessions</h3>
        <table>
            <thead><tr><th>ID</th><th>Name</th><th>Time In</th><th>Action</th></tr></thead>
            <tbody>
                <?php while($active = $active_sessions->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $active['id_number']; ?></td>
                    <td><?php echo $active['fullname']; ?></td>
                    <td><?php echo date('h:i A', strtotime($active['login_time'])); ?></td>
                    <td><a href="end_session.php?id=<?php echo $active['id']; ?>&sid=<?php echo $active['id_number']; ?>" class="btn btn-end">End Session</a></td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>

</body>
</html>