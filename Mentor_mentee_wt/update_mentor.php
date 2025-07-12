<?php
session_start();
require 'db_connect.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'mentors') {
    header("Location: login.php");
    exit();
}

$mentor_id = $_SESSION['user_id'];
$msg = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $department = trim($_POST['department'] ?? '');
    $password = trim($_POST['password'] ?? '');

    if ($name && $password) {
        $sql = "UPDATE mentors SET name = ?, department = ?, password = ? WHERE mentor_id = ?";
        $stmt = $conn->prepare($sql);
        if (!$stmt) {
            die("Prepare failed: " . $conn->error);
        }
        $stmt->bind_param("sssi", $name, $department, $password, $mentor_id);
        if ($stmt->execute()) {
            $msg = " Profile updated successfully.";
        } else {
            $msg = " Update failed: " . $stmt->error;
        }
        $stmt->close();
    } else {
        $msg = "Name and password are required.";
    }
}

$sql = "SELECT name, email, department, password FROM mentors WHERE mentor_id = ?";
$stmt = $conn->prepare($sql);
if (!$stmt) {
    die("Prepare failed: " . $conn->error);
}
$stmt->bind_param("i", $mentor_id);
$stmt->execute();
$result = $stmt->get_result();
$mentor = $result->fetch_assoc();
$stmt->close();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Update Mentor Profile</title>
    <style>
        body { font-family: Arial; background: #f2f2f2; }
        .box {
            width: 400px; margin: 60px auto; background: #fff;
            padding: 20px; border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        input, button {
            width: 100%; padding: 10px; margin: 10px 0;
            border: 1px solid #ccc; border-radius: 4px;
        }
        button {
            background-color: #28a745; color: white;
            border: none;
        }
        button:hover {
            background-color: #218838;
        }
        .msg {
            margin-bottom: 15px;
            color: green;
            font-weight: bold;
        }
    </style>
</head>
<body>
<div class="box">
    <h2>Update Profile</h2>

    <?php if ($msg): ?>
        <p class="msg"><?= htmlspecialchars($msg) ?></p>
    <?php endif; ?>

    <form method="POST">
        <label>Email (cannot be changed)</label>
        <input type="email" value="<?= htmlspecialchars($mentor['email']) ?>" readonly>

        <label>Name *</label>
        <input type="text" name="name" value="<?= htmlspecialchars($mentor['name']) ?>" required>

        <label>Department</label>
        <input type="text" name="department" value="<?= htmlspecialchars($mentor['department']) ?>">

        <label>Password *</label>
        <input type="text" name="password" value="<?= htmlspecialchars($mentor['password']) ?>" required>

        <button type="submit">Update</button>
    </form>
</div>
</body>
</html>
<?php
echo "<a href='mentor.php' style='display:inline-block; margin-top:20px; padding:10px 20px;
      background:#007bff; color:white; text-decoration:none; border-radius:4px;'>← Back to Dashboard</a>";

echo "</div>";

$conn->close();
 ?>
