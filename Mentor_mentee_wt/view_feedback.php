<?php
session_start();
include 'db_connect.php';

if (!isset($_SESSION['role']) || !in_array($_SESSION['role'], ['admins', 'mentors'])) {
    header("Location: login.php");
    exit();
}

$sql = "
SELECT 
    f.feedback_id,
    f.project_id,
    p.title AS project_title,
    f.mentee_id,
    m1.name AS mentee_name,
    f.mentor_id,
    m2.name AS mentor_name,
    f.comments,
    f.rating,
    f.submitted_on
FROM 
    feedback f
JOIN 
    projects p ON f.project_id = p.project_id
JOIN 
    mentees m1 ON f.mentee_id = m1.mentee_id
JOIN 
    mentors m2 ON f.mentor_id = m2.mentor_id
ORDER BY 
    f.submitted_on DESC
";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Feedback List</title>
    <style>
        body { font-family: Arial; margin: 40px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ccc; padding: 12px; text-align: left; }
        th { background-color: #007bff; color: white; }
        tr:nth-child(even) { background-color: #f9f9f9; }
        h2 { text-align: center; }
    </style>
</head>
<body>
    <h2>All Feedback Submitted</h2>

    <?php if ($result->num_rows > 0): ?>
        <table>
            <thead>
                <tr>
                    <th>Feedback ID</th>
                    <th>Project</th>
                    <th>Mentee</th>
                    <th>Mentor</th>
                    <th>Comments</th>
                    <th>Rating</th>
                    <th>Submitted On</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= $row['feedback_id'] ?></td>
                        <td><?= htmlspecialchars($row['project_title']) ?></td>
                        <td><?= htmlspecialchars($row['mentee_name']) ?></td>
                        <td><?= htmlspecialchars($row['mentor_name']) ?></td>
                        <td><?= nl2br(htmlspecialchars($row['comments'])) ?></td>
                        <td><?= (int)$row['rating'] ?>/5</td>
                        <td><?= $row['submitted_on'] ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No feedback submitted yet.</p>
    <?php endif; ?>

</body>
</html>

<?php
echo "<a href='admin.php' style='display:inline-block; margin-top:20px; padding:10px 20px;
      background:#007bff; color:white; text-decoration:none; border-radius:4px;'>← Back to Dashboard</a>";

echo "</div>";
$conn->close();
?>
