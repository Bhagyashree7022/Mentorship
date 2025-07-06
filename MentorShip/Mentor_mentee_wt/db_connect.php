<?php
$servername = "localhost";
$username = "root";        // Default username for XAMPP
$password = "root";            // Default password is empty
$database = "mentorship";  // Change this to your actual database name

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>