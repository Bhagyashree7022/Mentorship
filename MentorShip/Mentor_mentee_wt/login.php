<?php
session_start();
require 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email    = trim($_POST['email']    ?? '');
    $password = trim($_POST['password'] ?? '');
    $role     = trim($_POST['role']     ?? '');

    if (!$email || !$password || !$role) {
        die('All fields are required.');
    }

    $roles = [
        'admins'  => ['table' => 'admins',  'pk' => 'admin_id',  'dash' => 'admin.php'],
        'mentors' => ['table' => 'mentors', 'pk' => 'mentor_id', 'dash' => 'mentor.php'],
        'mentees' => ['table' => 'mentees', 'pk' => 'mentee_id', 'dash' => 'mentee.php']
    ];

    if (!isset($roles[$role])) {
        die('Invalid role selected.');
    }

    $table = $roles[$role]['table'];
    $pkCol = $roles[$role]['pk'];
    $dash  = $roles[$role]['dash'];

    $sql = "SELECT $pkCol AS id, name, email, password FROM `$table` WHERE email = ? LIMIT 1";
    $stmt = $conn->prepare($sql);
    if (!$stmt) { die("SQL prepare failed: " . $conn->error); }

    $stmt->bind_param('s', $email);
    $stmt->execute();
    $user = $stmt->get_result()->fetch_assoc();

    if (!$user || $user['password'] !== $password) {
        die('Incorrect credentials.');
    }

    $_SESSION['email']     = $user['email'];
    $_SESSION['role']      = $role;
    $_SESSION['user_id']   = $user['id'];
    $_SESSION['user_name'] = $user['name'] ?? ucfirst($role);

    header("Location: $dash");
    exit;
}
?>

<!-- HTML BELOW -->
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Mentorship Login</title>
  <style>
    body {
      font-family: sans-serif;
      background: #f4f4f4;
    }
    .container {
      width: 400px;
      margin: 60px auto;
      background: white;
      padding: 20px;
      border-radius: 8px;
      box-shadow: 0 0 10px rgba(0,0,0,0.1);
    }
    h2 {
      text-align: center;
    }
    label {
      display: block;
      margin: 10px 0 5px;
    }
    input, select {
      width: 100%;
      padding: 8px;
      margin-bottom: 10px;
    }
    button {
      width: 100%;
      padding: 10px;
      background: #007bff;
      color: white;
      border: none;
      border-radius: 4px;
    }
  </style>
</head>
<body>
<div class="container">
  <h2>Login</h2>
  <form method="POST" action="">
    <label>Email</label>
    <input type="email" name="email" required>

    <label>Password</label>
    <input type="password" name="password" required>

    <label>Role</label>
    <select name="role" required>
      <option value="">Select Role</option>
      <option value="admins">Admin</option>
      <option value="mentors">Mentor</option>
      <option value="mentees">Mentee</option>
    </select>

    <button type="submit">Login</button>
  </form>
</div>
</body>
</html>
