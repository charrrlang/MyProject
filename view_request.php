<?php
session_start();
include 'db_connect.php';

// Fetch only students waiting for approval
$sql = "SELECT * FROM sitin_records WHERE status = 'Pending'";
$result = $conn->query($sql);
?>
<h2>Pending Sit-in Approvals</h2>
<table border="1">
    <tr>
        <th>ID Number</th>
        <th>Name</th>
        <th>Purpose</th>
        <th>Action</th>
    </tr>
    <?php while($row = $result->fetch_assoc()): ?>
    <tr>
        <td><?= $row['id_number'] ?></td>
        <td><?= $row['fullname'] ?></td>
        <td><?= $row['purpose'] ?></td>
        <td>
            <a href="approve_logic.php?id=<?= $row['id'] ?>" style="color: green; font-weight: bold;">APPROVE</a>
        </td>
    </tr>
    <?php endwhile; ?>
</table>