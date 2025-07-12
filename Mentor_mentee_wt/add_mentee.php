<?php
include 'db_connect.php';

$name  = trim($_POST['name']);
$email = trim($_POST['email']);
$batch = trim($_POST['batch']);

$check = $conn->prepare("SELECT mentee_id FROM mentees WHERE email = ?");
$check->bind_param("s", $email);
$check->execute();
$check->store_result();

echo "<div style='text-align:center; margin-top:40px; font-family:Arial;'>";

if ($check->num_rows > 0) {
    echo "<p style='color:red;'>Email already exists!</p>";
    $check->close();
} else {
    $check->close();

    $stmt = $conn->prepare("INSERT INTO mentees (name, email, batch) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $name, $email, $batch);

    if ($stmt->execute()) {
        echo "<p style='color:green;'>Mentee added successfully!</p>";
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
