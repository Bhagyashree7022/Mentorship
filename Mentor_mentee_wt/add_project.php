<?php
include 'db_connect.php';

$title       = trim($_POST['title']);
$description = trim($_POST['description']);
$start_date  = $_POST['start_date'];
$end_date    = $_POST['end_date'];

echo "<div style='text-align:center; margin-top:40px; font-family:Segoe UI, sans-serif;'>";

if (empty($title) || empty($description) || empty($start_date) || empty($end_date)) {
    echo "<p style='color:red;'> All fields are required!</p>";
} else {
    $stmt = $conn->prepare("INSERT INTO projects (title, description, start_date, end_date) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $title, $description, $start_date, $end_date);

    if ($stmt->execute()) {
        echo "<p style='color:green;'>Project added successfully!</p>";
    } else {
        echo "<p style='color:red;'>Error: " . htmlspecialchars($stmt->error) . "</p>";
    }
    $stmt->close();
}

echo "<a href='admin.php' style='display:inline-block; margin-top:20px; padding:10px 20px;
      background:#007bff; color:white; text-decoration:none; border-radius:4px;'>← Back to Dashboard</a>";

echo "</div>";
$conn->close();
?>
