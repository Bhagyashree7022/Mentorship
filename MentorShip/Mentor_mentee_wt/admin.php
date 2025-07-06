
<?php
session_start();

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admins') {
    header("Location: login.php");
    exit();
}

$adminName = $_SESSION['user_name'];  // ← use correct session variable
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Admin Dashboard</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <div style="display: flex; justify-content: space-between; align-items: center; padding: 10px 20px; background-color: #f8f9fa; border-bottom: 1px solid #ccc;">
    <h2 style="margin: 0;">Dashboard</h2>
    <a href="logout.php" style="background-color: #dc3545; color: white; padding: 8px 16px; border-radius: 5px; text-decoration: none;">Logout</a>
</div>

  <div class="container">
    <h1>Welcome, <?php echo htmlspecialchars($adminName); ?></h1>
    <p class="subtitle">Use the buttons below to manage mentors, mentees, assignments, and feedback.</p>

    <div class="grid-container">
      <a href="add_mentor.html" class="card card1">
        <h2>Add Mentor</h2>
        <p>Add new mentor records into the system.</p>
      </a>

      <a href="add_mentee.html" class="card card2">
        <h2>Add Mentee</h2>
        <p>Register students or mentees for guidance.</p>
      </a>

      <a href="assign_mentor.php" class="card card3">
        <h2>Assign Mentor</h2>
        <p>Link mentors to their assigned mentees and projects.</p>
      </a>

      <a href="view_feedback.php" class="card card4">
        <h2>View Feedback</h2>
        <p>Review mentor feedback for each mentee/project.</p>
      </a>
    </div>
  </div>

</body>
</html>
