<?php
session_start();
require 'db_connect.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$mentee_id = $_SESSION['user_id'];

$sql = SELECT DISTINCT m.mentor_id, m.name, m.email, m.department
FROM   mentee_assignments ma
JOIN   mentors m
       ON ma.assigned_by_mentor_id = m.mentor_id
WHERE  ma.mentee_id = ?;
";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html>
<head>
    <title>View Mentors</title>
    <style>
        body { font-family: Arial; background: #eef2f5; padding: 30px; }
        .container { max-width: 800px; margin: auto; background: white; padding: 20px; border-radius: 10px; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
        h2 { text-align: center; margin-bottom: 20px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 10px; border: 1px solid #ccc; text-align: left; }
        th { background: #007bff; color: white; }
        tr:nth-child(even) { background: #f9f9f9; }
        a.back { display: block; margin-top: 20px; text-align: center; color: #007bff; text-decoration: none; }
        a.back:hover { text-decoration: underline; }
    </style>
</head>
<body>
<div class="container">
    <h2>Available Mentors</h2>

    <?php if ($result && $result->num_rows > 0): ?>
        <table>
            <tr>
                <th>Mentor ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Department</th>
            </tr>
            <?php while($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($row['mentor_id']) ?></td>
                    <td><?= htmlspecialchars($row['name']) ?></td>
                    <td><?= htmlspecialchars($row['email']) ?></td>
                    <td><?= htmlspecialchars($row['department']) ?></td>
                </tr>
            <?php endwhile; ?>
        </table>
    <?php else: ?>
        <p>No mentors found.</p>
    <?php endif; ?>

    <a class="back" href="mentee.php">← Back to Dashboard</a>
</div>
</body>
</html>
<?php
$conn->close();
?>
