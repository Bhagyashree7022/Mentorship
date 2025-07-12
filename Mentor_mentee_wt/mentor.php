<?php
session_start();

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'mentors') {
    header("Location: login.php");
    exit();
}

$mentorName = $_SESSION['user_name'] ?? 'Mentor';
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Mentor Dashboard</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
<div style="display: flex; justify-content: space-between; align-items: center; padding: 10px 20px; background-color: #f8f9fa; border-bottom: 1px solid #ccc;">
    <h2 style="margin: 0;">Dashboard</h2>
    <a href="logout.php" style="background-color: #dc3545; color: white; padding: 8px 16px; border-radius: 5px; text-decoration: none;">Logout</a>
</div>
<div class="container">
  <h1>Welcome, <?php echo htmlspecialchars($mentorName); ?></h1>
  <p class="subtitle">Use the cards below to manage mentees, view assigned projects, and submit feedback.</p>

  <div class="grid-container">
    <a href="assign_mentees.php" class="card card1">
      <h2>Assign Mentees</h2>
      <p>Link mentees to your mentorship and projects.</p>
    </a>

    <a href="view_projects.php" class="card card2">
      <h2>View Projects</h2>
      <p>See the list of prosjects you’re mentoring.</p>
    </a>

    <a href="view_mentees.php" class="card card3">
      <h2>View Mentees</h2>
      <p>See all mentees assigned to you.</p>
    </a>

    <a href="view_feedback1.php" class="card card4">
      <h2>View Feedback</h2>
      <p>Provide feedback on mentee performance.</p>
    </a>

    <a href="update_mentor.php" class="card card1">
      <h2>Update Profile</h2>
      <p>Update your personal details and Changeyour Password.</p>
    </a>

  </div>
</div>

</body>
</html>
