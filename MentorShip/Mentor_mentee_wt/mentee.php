<?php
/* ───── Mentee Dashboard ───── */
session_start();
require 'db_connect.php';

/* 1 ▸ Restrict page to mentees only */
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'mentees') {
    header("Location: login.php");
    exit();
}

$menteeName = $_SESSION['user_name'] ?? 'Mentee';
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Mentee Dashboard</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<style>
    body { font-family: Arial, sans-serif; background:#f4f4f4; margin:0; }
    .container { max-width: 900px; margin: 50px auto; padding: 0 15px; }
    h1 { text-align:center; margin-bottom: 10px; }
    p.subtitle { text-align:center; margin-top:0; color:#555; }
    .grid { display:grid; grid-template-columns: repeat(auto-fit,minmax(200px,1fr)); gap:20px; margin-top:30px; }
    .card {
        background:#fff; border-radius:8px; padding:25px; text-align:center;
        box-shadow:0 2px 6px rgba(0,0,0,.12); text-decoration:none; color:#222;
        transition: transform .15s ease-in-out;
    }
    .card:hover { transform: translateY(-4px); }
    .card h2 { margin:0 0 10px; font-size:20px; }
    .card p  { margin:0; color:#666; font-size:14px; }
    /* individual colors */
    .c1{border-top:6px solid #20c997;}
    .c2{border-top:6px solid #17a2b8;}
    .c3{border-top:6px solid #007bff;}
</style>
</head>
<body>
    <div style="display: flex; justify-content: space-between; align-items: center; padding: 10px 20px; background-color: #f8f9fa; border-bottom: 1px solid #ccc;">
    <h2 style="margin: 0;">Dashboard</h2>
    <a href="logout.php" style="background-color: #dc3545; color: white; padding: 8px 16px; border-radius: 5px; text-decoration: none;">Logout</a>
</div>
<div class="container">

    <h1>Welcome, <?= htmlspecialchars($menteeName) ?></h1>
    <p class="subtitle">Choose an action below:</p>

    <div class="grid">
        <!-- View Projects -->
        <a href="view_project.php" class="card c1">
            <h2>View Projects</h2>
            <p>Check your assigned projects and details.</p>
        </a>

        <!-- Update Profile -->
        <a href="update_profile.php" class="card c2">
            <h2>Update Profile</h2>
            <p>Edit your personal information &amp; password.</p>
        </a>

        <!-- Submit Feedback -->
        <a href="submit_feedback.php" class="card c3">
            <h2>Submit Feedback</h2>
            <p>Rate your mentor &amp; project experience.</p>
        </a>
    </div>

</div>
</body>
</html>
<?php $conn->close(); ?>
