<?php
session_start();
include 'db_connect.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'mentors') {
    header("Location: login.php");
    exit();
}

$mentor_id   = $_SESSION['user_id'];
$mentor_name = $_SESSION['user_name'] ?? 'Mentor';

$sql = "
SELECT 
    m.mentee_id,
    m.`name` AS mentee_name,
    m.email,
    m.batch,
    p.title AS project_title,
    ma.progress_status,
    ma.assigned_on
FROM 
    mentees m
JOIN 
    mentee_assignments ma ON m.mentee_id = ma.mentee_id
JOIN 
    projects p ON ma.project_id = p.project_id
WHERE 
    ma.assigned_by_mentor_id = ?
ORDER BY 
    m.`name`
";

$stmt = $conn->prepare($sql);
if (!$stmt) {
    die("SQL Prepare Error: " . $conn->error); 
}

$stmt->bind_param("i", $mentor_id);
$stmt->execute();
$result = $stmt->get_result();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Mentees Assigned to <?= htmlspecialchars($mentor_name) ?></title>
    <style>
        table { border-collapse: collapse; width: 100%; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; }
        th { background-color: #f2f2f2; text-align: left; }
    </style>
</head>
<body>
    <h2>Mentees Assigned to <?= htmlspecialchars($mentor_name) ?></h2>
    <?php if ($result->num_rows === 0): ?>
        <p>No mentees assigned to you yet.</p>
    <?php else: ?>
        <table>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Batch</th>
                <th>Project Title</th>
                <th>Progress</th>
                <th>Assigned On</th>
            </tr>
            <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?= htmlspecialchars($row['mentee_name']) ?></td>
                <td><?= htmlspecialchars($row['email']) ?></td>
                <td><?= htmlspecialchars($row['batch']) ?></td>
                <td><?= htmlspecialchars($row['project_title']) ?></td>
                <td><?= htmlspecialchars($row['progress_status']) ?></td>
                <td><?= htmlspecialchars($row['assigned_on']) ?></td>
            </tr>
            <?php endwhile; ?>
        </table>
    <?php endif; ?>
</body>
</html>
<?php
echo "<a href='mentor.php' style='display:inline-block; margin-top:20px; padding:10px 20px;
      background:#007bff; color:white; text-decoration:none; border-radius:4px;'>← Back to Dashboard</a>";

echo "</div>";
$stmt->close();
$conn->close();
?>
