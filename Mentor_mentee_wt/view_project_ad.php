<?php
include 'db_connect.php';

$sql = "
SELECT 
    p.title AS project_title,
    p.start_date,
    p.end_date,
    m.name AS mentor_name,
    me.name AS mentee_name,
    mea.progress_status
FROM projects p
JOIN mentor_assignments ma ON p.project_id = ma.project_id
JOIN mentors m ON ma.mentor_id = m.mentor_id
JOIN mentee_assignments mea ON p.project_id = mea.project_id
JOIN mentees me ON mea.mentee_id = me.mentee_id
ORDER BY p.start_date DESC
";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
  <title>Assigned Projects</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background: #f8f9fa;
      padding: 20px;
    }
    h2 {
      text-align: center;
      color: #333;
    }
    table {
      width: 90%;
      margin: 20px auto;
      border-collapse: collapse;
      background: #fff;
      box-shadow: 0 2px 6px rgba(0,0,0,0.1);
    }
    th, td {
      padding: 12px 16px;
      border: 1px solid #ccc;
      text-align: left;
    }
    th {
      background: #343a40;
      color: white;
    }
    tr:nth-child(even) {
      background-color: #f1f1f1;
    }
  </style>
</head>
<body>

<h2>Assigned Projects Overview</h2>

<table>
  <thead>
    <tr>
      <th>Project Title</th>
      <th>Mentor</th>
      <th>Mentee</th>
      <th>Start Date</th>
      <th>End Date</th>
      <th>Progress</th>
    </tr>
  </thead>
  <tbody>
    <?php if ($result && $result->num_rows > 0): ?>
      <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
          <td><?= htmlspecialchars($row['project_title']) ?></td>
          <td><?= htmlspecialchars($row['mentor_name']) ?></td>
          <td><?= htmlspecialchars($row['mentee_name']) ?></td>
          <td><?= htmlspecialchars($row['start_date']) ?></td>
          <td><?= htmlspecialchars($row['end_date']) ?></td>
          <td><?= htmlspecialchars($row['progress_status']) ?></td>
        </tr>
      <?php endwhile; ?>
    <?php else: ?>
      <tr><td colspan="6" style="text-align:center;">No assignments found.</td></tr>
    <?php endif; ?>
  </tbody>
</table>

</body>
</html>
