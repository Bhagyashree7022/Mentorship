<?php
session_start();
require 'db_connect.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$mentee_id = $_SESSION['user_id'];
$msg = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $batch = trim($_POST['batch'] ?? '');
    $password = trim($_POST['password'] ?? '');

    if ($name && $password) {
        $sql = "UPDATE mentees SET name = ?, batch = ?, password = ? WHERE mentee_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssi", $name, $batch, $password, $mentee_id);
        if ($stmt->execute()) {
            $msg = "Profile updated successfully.";
        } else {
            $msg = "Update failed: " . $stmt->error;
        }
        $stmt->close();
    } else {
        $msg = "Name and password are required.";
    }
}

$sql = "SELECT name, email, batch, password FROM mentees WHERE mentee_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $mentee_id);
$stmt->execute();
$result = $stmt->get_result();
$mentee = $result->fetch_assoc();
$stmt->close();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Update Profile</title>
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
        <input type="email" value="<?= htmlspecialchars($mentee['email']) ?>" readonly>

        <label>Name *</label>
        <input type="text" name="name" value="<?= htmlspecialchars($mentee['name']) ?>" required>

        <label>Batch</label>
        <input type="text" name="batch" value="<?= htmlspecialchars($mentee['batch']) ?>">

        <label>Password *</label>
        <input type="text" name="password" value="<?= htmlspecialchars($mentee['password']) ?>" required>

        <button type="submit">Update</button>
    </form>
</div>
</body>
</html> 
<?php
echo "<a href='MENTEE.php' style='display:inline-block; margin-top:20px; padding:10px 20px;
      background:#007bff; color:white; text-decoration:none; border-radius:4px;'>← Back to Dashboard</a>";

echo "</div>";
$conn->close(); ?>
