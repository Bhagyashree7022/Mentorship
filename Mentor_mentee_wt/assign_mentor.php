<?php
session_start();
require 'db_connect.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admins') {
    header("Location: login.php");
    exit();
}

$admin_id = $_SESSION['user_id'];
$msg = "";


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $mentor_id = $_POST['mentor_id'] ?? '';
    $project_id = $_POST['project_id'] ?? '';

    if ($mentor_id && $project_id) {
        $assigned_on = date('Y-m-d');
        $sql = "INSERT INTO mentor_assignments (mentor_id, project_id, assigned_on, assigned_by_admin_id) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        if ($stmt) {
            $stmt->bind_param("iisi", $mentor_id, $project_id, $assigned_on, $admin_id);
            if ($stmt->execute()) {
                $msg = "Mentor assigned to project successfully!";
            } else {
                $msg = "Error: " . $stmt->error;
            }
            $stmt->close();
        } else {
            $msg = "Prepare failed: " . $conn->error;
        }
    } else {
        $msg = "Please select both a mentor and a project.";
    }
}


$mentors = [];
$result = $conn->query("SELECT mentor_id, name FROM mentors");
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $mentors[] = $row;
    }
}


$projects = [];
$result = $conn->query("SELECT project_id, title FROM projects");
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $projects[] = $row;
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Assign Mentor to Project</title>
    <style>
        body { font-family: Arial; background: #f4f4f4; }
        .box { max-width: 500px; margin: 50px auto; background: #fff; padding: 25px; border-radius: 8px; box-shadow: 0 0 10px rgba(0,0,0,.1); }
        label, select, button { display: block; width: 100%; margin-bottom: 15px; }
        select, button { padding: 10px; border: 1px solid #ccc; border-radius: 4px; }
        button { background: #28a745; color: white; font-weight: bold; cursor: pointer; }
        button:hover { background: #218838; }
        .msg { color: green; margin-bottom: 15px; }
    </style>
</head>
<body>
<div class="box">
    <h2>Assign Mentor to Project</h2>

    <?php if ($msg): ?><p class="msg"><?= htmlspecialchars($msg); ?></p><?php endif; ?>

    <form method="POST">
        <label for="mentor_id">Select Mentor</label>
        <select name="mentor_id" id="mentor_id" required>
            <option value="">Choose Mentor</option>
            <?php foreach ($mentors as $mentor): ?>
                <option value="<?= $mentor['mentor_id']; ?>">
                    <?= htmlspecialchars($mentor['name']) . " (ID: " . $mentor['mentor_id'] . ")"; ?>
                </option>
            <?php endforeach; ?>
        </select>

        <label for="project_id">Select Project</label>
        <select name="project_id" id="project_id" required>
            <option value=""> Choose Project </option>
            <?php foreach ($projects as $project): ?>
                <option value="<?= $project['project_id']; ?>">
                    <?= htmlspecialchars($project['title']) . " (ID: " . $project['project_id'] . ")"; ?>
                </option>
            <?php endforeach; ?>
        </select>

        <button type="submit">Assign Mentor</button>
    </form>
</div>
</body>
</html>
<?php
echo "<a href='admin.php' style='display:inline-block; margin-top:20px; padding:10px 20px;
      background:#007bff; color:white; text-decoration:none; border-radius:4px;'>← Back to Dashboard</a>";

echo "</div>";
 $conn->close(); ?>
