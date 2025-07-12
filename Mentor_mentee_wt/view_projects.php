<?php
session_start();
include 'db_connect.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'mentors') {
    header("Location: login.php");
    exit();
}

$mentor_id   = $_SESSION['user_id']; // Ensure this is set during login
$mentor_name = $_SESSION['user_name'] ?? 'Mentor';

$sql = "
SELECT 
    p.project_id,
    p.title,
    p.description,
    COUNT(ma2.mentee_id) AS mentee_count
FROM 
    projects p
JOIN 
    mentor_assignments ma ON p.project_id = ma.project_id
LEFT JOIN 
    mentee_assignments ma2 ON p.project_id = ma2.project_id
WHERE 
    ma.mentor_id = ?
GROUP BY 
    p.project_id, p.title, p.description
ORDER BY 
    p.title;
";


$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $mentor_id);
$stmt->execute();
$result = $stmt->get_result();  
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Your Projects</title>
  <style>
    table { width: 100%; border-collapse: collapse; margin-top: 25px; }
    th, td { padding: 10px; border: 1px solid #ccc; }
    th { background: #007bff; color: #fff; }
    tr:nth-child(even) { background: #f2f2f2; }
  </style>
</head>
<body>
<div class="container">
  <h1 style="text-align:center;">Projects Mentored by <?= htmlspecialchars($mentor_name) ?></h1>

  <?php if ($result->num_rows === 0): ?>
      <p style="text-align:center;">You don’t have any projects assigned yet.</p>
  <?php else: ?>
      <table>
        <thead>
          <tr>
            <th>Project Title</th>
            <th>Description</th>
            <th>Mentees Assigned</th>
          </tr>
        </thead>
        <tbody>
          <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
              <td><?= htmlspecialchars($row['title']) ?></td>
              <td><?= htmlspecialchars($row['description']) ?></td>
              <td><?= (int)$row['mentee_count'] ?></td>
            </tr>
          <?php endwhile; ?>
        </tbody>
      </table>
  <?php endif; ?>
</div>
</body>
</html>
<?php
echo "<a href='mentor.php' style='display:inline-block; margin-top:20px; padding:10px 20px;
      background:#007bff; color:white; text-decoration:none; border-radius:4px;'>← Back to Dashboard</a>";

echo "</div>";
$stmt->close();
$conn->close();
?>
