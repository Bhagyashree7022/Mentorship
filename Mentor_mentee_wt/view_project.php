<?php
session_start();
require 'db_connect.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'mentees') {
    header("Location: login.php");
    exit();
}

$mentee_id = $_SESSION['user_id'];

$sql = "
    SELECT 
        p.project_id,
        p.title,
        p.description,
        m.mentor_id,
        m.name AS mentor_name,
        m.email AS mentor_email,
        m.department
    FROM mentee_assignments ma
    JOIN projects p ON ma.project_id = p.project_id
    JOIN mentors m ON ma.assigned_by_mentor_id = m.mentor_id
    WHERE ma.mentee_id = ?
";

$stmt = $conn->prepare($sql);
if (!$stmt) {
    die("Prepare failed: " . $conn->error);
}

$stmt->bind_param("i", $mentee_id);
$stmt->execute();
$result = $stmt->get_result();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Your Projects and Mentors</title>
    <style>
        body { font-family: Arial; background: #f9f9f9; padding: 30px; }
        .container { max-width: 900px; margin: auto; background: white; padding: 20px; border-radius: 10px; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
        h2 { text-align: center; margin-bottom: 20px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 12px; border: 1px solid #ccc; text-align: left; }
        th { background: #007bff; color: white; }
        tr:nth-child(even) { background: #f2f2f2; }
        a.back { display: block; margin-top: 20px; text-align: center; color: #007bff; text-decoration: none; }
        a.back:hover { text-decoration: underline; }
    </style>
</head>
<body>
<div class="container">
    <h2>Your Projects and Assigned Mentors</h2>

    <?php if ($result->num_rows > 0): ?>
        <table>
            <tr>
                <th>Project ID</th>
                <th>Project Name</th>
                <th>Description</th>
                <th>Mentor Name</th>
                <th>Mentor Email</th>
                <th>Department</th>
            </tr>
            <?php while($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($row['project_id']) ?></td>
                    <td><?= htmlspecialchars($row['title']) ?></td>
                    <td><?= htmlspecialchars($row['description']) ?></td>
                    <td><?= htmlspecialchars($row['mentor_name']) ?></td>
                    <td><?= htmlspecialchars($row['mentor_email']) ?></td>
                    <td><?= htmlspecialchars($row['department']) ?></td>
                </tr>
            <?php endwhile; ?>
        </table>
    <?php else: ?>
        <p>You have not been assigned to any projects yet.</p>
    <?php endif; ?>

    <a class="back" href="mentee.php">← Back to Dashboard</a>
</div>
</body>
</html>
<?php

$stmt->close();
$conn->close();
?>
