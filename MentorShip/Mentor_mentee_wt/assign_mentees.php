<?php
session_start();
include 'db_connect.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'mentors') {
    header("Location: login.php");
    exit();
}

$mentor_id = $_SESSION['user_id'];
$message = "";

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $mentee_id = $_POST['mentee_id'];
    $project_id = $_POST['project_id'];
    $assigned_on = date('Y-m-d');
    $progress_status = 'Not Started';

    // Check if already assigned
    $check_sql = "SELECT * FROM mentee_assignments WHERE mentee_id = ? AND project_id = ?";
    $check_stmt = $conn->prepare($check_sql);
    $check_stmt->bind_param("ii", $mentee_id, $project_id);
    $check_stmt->execute();
    $check_result = $check_stmt->get_result();

    if ($check_result->num_rows > 0) {
        $message = "This mentee is already assigned to the selected project.";
    } else {
        $insert_sql = "INSERT INTO mentee_assignments (mentee_id, project_id, assigned_on, progress_status, assigned_by_mentor_id)
                       VALUES (?, ?, ?, ?, ?)";
        $insert_stmt = $conn->prepare($insert_sql);
        $insert_stmt->bind_param("isssi", $mentee_id, $project_id, $assigned_on, $progress_status, $mentor_id);

        if ($insert_stmt->execute()) {
            $message = "Mentee assigned successfully.";
        } else {
            $message = "Failed to assign mentee.";
        }
    }
}

// Fetch available mentees
$mentees = $conn->query("SELECT mentee_id, name FROM mentees");

// Fetch mentor's own projects
$project_sql = "
    SELECT p.project_id, p.title
    FROM projects p
    JOIN mentor_assignments ma ON p.project_id = ma.project_id
    WHERE ma.mentor_id = ?
";
$project_stmt = $conn->prepare($project_sql);
$project_stmt->bind_param("i", $mentor_id);
$project_stmt->execute();
$projects = $project_stmt->get_result();
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Assign Mentee</title>
    <style>
        body { font-family: Arial; padding: 40px; }
        form { max-width: 500px; margin: auto; border: 1px solid #ccc; padding: 20px; }
        label, select, button { display: block; margin: 15px 0; width: 100%; }
        button { padding: 10px; background-color: #007bff; color: white; border: none; cursor: pointer; }
        button:hover { background-color: #0056b3; }
        .message { text-align: center; color: green; margin-top: 20px; }
    </style>
</head>
<body>

<h2 style="text-align:center;">Assign Mentee to Project</h2>

<form method="POST">
    <label for="mentee_id">Select Mentee:</label>
    <select name="mentee_id" id="mentee_id" required>
        <option value="">-- Choose a Mentee --</option>
        <?php while ($mentee = $mentees->fetch_assoc()): ?>
            <option value="<?= $mentee['mentee_id'] ?>"><?= htmlspecialchars($mentee['name']) ?></option>
        <?php endwhile; ?>
    </select>

    <label for="project_id">Select Your Project:</label>
    <select name="project_id" id="project_id" required>
        <option value="">-- Choose a Project --</option>
        <?php while ($project = $projects->fetch_assoc()): ?>
            <option value="<?= $project['project_id'] ?>"><?= htmlspecialchars($project['title']) ?></option>
        <?php endwhile; ?>
    </select>

    <button type="submit">Assign</button>
</form>

<?php if ($message): ?>
    <p class="message"><?= htmlspecialchars($message) ?></p>
<?php endif; ?>

</body>
</html>

<?php
echo "<a href='mentor.php' style='display:inline-block; margin-top:20px; padding:10px 20px;
      background:#007bff; color:white; text-decoration:none; border-radius:4px;'>← Back to Dashboard</a>";

echo "</div>";
$conn->close();
?>
