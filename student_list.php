<?php
session_start();
include 'db_connect.php';

// Check if Admin is logged in
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'Admin') {
    header("Location: login.php");
    exit();
}

// Fetch all students from the users table
$sql = "SELECT Id, FullName, UserName, Course, CourseLevel, SessionsRemaining FROM users ORDER BY FullName ASC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Students Information - Admin</title>
    <style>
        body { font-family: 'Segoe UI', sans-serif; background-color: #f4f7f6; margin: 0; }
        .admin-nav { background: #004a99; padding: 15px; display: flex; justify-content: center; gap: 20px; }
        .admin-nav a { color: white; text-decoration: none; font-weight: bold; }
        
        .container { padding: 40px; }
        .info-card { background: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        
        h2 { text-align: center; color: #333; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th { background-color: #004a99; color: white; padding: 12px; text-align: left; }
        td { padding: 12px; border-bottom: 1px solid #ddd; font-size: 14px; }
        tr:hover { background-color: #f1f1f1; }

        .btn { padding: 6px 12px; border-radius: 4px; text-decoration: none; color: white; font-size: 12px; }
        .btn-edit { background-color: #007bff; }
        .btn-delete { background-color: #dc3545; }
    </style>
</head>
<body>

<div class="admin-nav">
    <a href="admin_dashboard.php">Home</a>
    <a href="admin_dashboard.php#search-section">Search</a>
    <a href="student_list.php" style="text-decoration: underline;">Students</a>
    <a href="sitin_records.php">Sit-in Records</a>
    <a href="logout.php" style="color: #ff4d4d;">Logout</a>
</div>

<div class="container">
    <div class="info-card">
        <h2>Students Information</h2>
        
        <table>
            <thead>
                <tr>
                    <th>ID Number</th>
                    <th>Name</th>
                    <th>Course</th>
                    <th>Year Level</th>
                    <th>Remaining Session</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                if ($result && $result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo "<tr>
                                <td>" . htmlspecialchars($row['Id']) . "</td>
                                <td>" . htmlspecialchars($row['FullName']) . "</td>
                                <td>" . htmlspecialchars($row['Course']) . "</td>
                                <td>" . htmlspecialchars($row['CourseLevel']) . "</td>
                                <td>" . htmlspecialchars($row['SessionsRemaining']) . "</td>
                                <td>
                                    <a href='edit_student.php?id=" . $row['Id'] . "' class='btn btn-edit'>Edit</a>
                                    <a href='delete_student.php?id=" . $row['Id'] . "' class='btn btn-delete' onclick='return confirm(\"Delete this student?\")'>Delete</a>
                                </td>
                              </tr>";
                    }
                } else {
                    echo "<tr><td colspan='6' style='text-align:center;'>No students registered yet.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

</body>
</html>