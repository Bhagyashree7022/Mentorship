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
</div>
</body>
</html>
