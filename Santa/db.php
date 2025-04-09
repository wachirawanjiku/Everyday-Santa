<?php
$servername = "localhost"; // or "127.0.0.1"
$username = "root";        // default for MAMP/XAMPP
$password = "root";            // leave blank for default on MAMP
$dbname = "everyday_santa"; // your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check if connection worked
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
?>