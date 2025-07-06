<?php
session_start();
require 'db_connect.php';

/* 1 ▸  Only mentees may access */
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'mentees') {
    header("Location: login.php");
    exit();
}
$mentee_id = $_SESSION['user_id'];

/* helper to bail with DB errors during dev */
function sql_die($msg, $conn) { die($msg .' ' . $conn->error); }

$msg = "";

/* 2 ▸  Fetch all mentor‑project pairs for this mentee */
$sql = "
SELECT 
    ma.project_id,
    p.title,
    m.mentor_id,
    m.name AS mentor_name
FROM mentee_assignments ma
JOIN projects p ON ma.project_id = p.project_id
JOIN mentors  m ON ma.assigned_by_mentor_id = m.mentor_id
WHERE ma.mentee_id = ?
ORDER BY p.title, m.name
";

$stmt = $conn->prepare($sql) or sql_die('Prepare failed', $conn);
$stmt->bind_param('i', $mentee_id);
$stmt->execute();
$assignments = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
$stmt->close();

/* 3 ▸  Handle feedback form submit */
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // value looks like "projectID-mentorID" (e.g. "2-4")
    if (!empty($_POST['pair'])) {
        [$project_id, $mentor_id] = array_map('intval', explode('-', $_POST['pair']));
    } else {
        $project_id = $mentor_id = 0;
    }
    $rating   = intval($_POST['rating']   ?? 0);
    $comments = trim($_POST['comments']   ?? '');
    $today    = date('Y-m-d');

    if ($project_id && $mentor_id && $rating >= 1 && $rating <= 5) {
        $insert = "INSERT INTO feedback
                  (project_id, mentee_id, mentor_id, comments, rating, submitted_on)
                   VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($insert) or sql_die('Prepare failed', $conn);
        $stmt->bind_param('iiisss', $project_id, $mentee_id, $mentor_id,
                          $comments, $rating, $today);
        if ($stmt->execute()) {
            $msg = " Feedback submitted successfully!";
        } else {
            $msg = " Insert error: " . $stmt->error;
        }
        $stmt->close();
    } else {
        $msg = "Please choose a mentor/project pair and give a rating (1‑5).";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Submit Feedback</title>
<style>
 body{font-family:Arial;background:#f5f7fa;padding:40px}
 .box{max-width:600px;margin:auto;background:#fff;padding:25px;border-radius:8px;
      box-shadow:0 0 10px rgba(0,0,0,.1)}
 h2{text-align:center;margin-bottom:20px}
 label{display:block;margin-top:15px;font-weight:600}
 select,textarea,input[type=number]{width:100%;padding:9px;margin-top:6px;
      border:1px solid #ccc;border-radius:4px}
 textarea{height:100px;resize:vertical}
 button{margin-top:20px;background:#28a745;color:#fff;border:none;padding:11px 18px;
        border-radius:4px;cursor:pointer;font-size:16px}
 button:hover{background:#218838}
 .msg{text-align:center;font-weight:bold;margin-top:15px}
 .back{display:block;margin-top:20px;text-align:center;color:#007bff;text-decoration:none}
 .back:hover{text-decoration:underline}
</style>
</head>
<body>
<div class="box">
    <h2>Submit Feedback</h2>

    <?php if ($msg): ?>
        <p class="msg"><?= htmlspecialchars($msg) ?></p>
    <?php endif; ?>

    <?php if ($assignments): ?>
    <form method="POST">
        <!-- mentor + project paired together -->
        <label for="pair">Project &amp; Mentor</label>
        <select name="pair" id="pair" required>
            <option value="">-- Select --</option>
            <?php foreach ($assignments as $a): ?>
                <?php
                  $value = $a['project_id'] . '-' . $a['mentor_id'];
                  $text  = $a['pname'] . '  ➟  Mentor: ' . $a['mentor_name'];
                ?>
                <option value="<?= $value ?>"><?= htmlspecialchars($text) ?></option>
            <?php endforeach; ?>
        </select>

        <label for="rating">Rating (1–5)</label>
        <input type="number" id="rating" name="rating" min="1" max="5" required>

        <label for="comments">Comments</label>
        <textarea id="comments" name="comments" placeholder="Write your feedback..."></textarea>

        <button type="submit">Submit Feedback</button>
    </form>
    <?php else: ?>
        <p class="msg" style="color:#d00;">You have no mentor/project assignments yet.</p>
    <?php endif; ?>

    <a class="back" href="mentee.php">← Back to Dashboard</a>
</div>
</body>
</html>
<?php $conn->close(); ?>
