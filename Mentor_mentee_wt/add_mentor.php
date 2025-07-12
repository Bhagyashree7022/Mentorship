<?php
include 'db_connect.php';

$name = $_POST['name'];
$email = $_POST['email'];
$department = $_POST['department'];

$check = mysqli_query($conn, "SELECT * FROM mentors WHERE email = '$email'");
if (mysqli_num_rows($check) > 0) {
    echo "<p style='color:red; text-align:center;'>Email already exists!</p>";
    exit;
}

$sql = "INSERT INTO mentors (name, email, department) VALUES ('$name', '$email', '$department')";

if (mysqli_query($conn, $sql)) {
    echo "<p style='color:green; text-align:center;'>Mentor added successfully!</p>";
} else {
    echo "<p style='color:red; text-align:center;'>Error: " . mysqli_error($conn) . "</p>";
}

echo "<a href='admin.php' style='display:inline-block; margin-top:20px; padding:10px 20px;
      background:#007bff; color:white; text-decoration:none; border-radius:4px;'>← Back to Dashboard</a>";

echo "</div>";

mysqli_close($conn);
?>
