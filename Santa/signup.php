<?php
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "everyday_santa";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($_SERVER["REQUEST_METHOD"] === "POST") {
  // Collect data from POST
  $name = $conn->real_escape_string($_POST['name']);
  $email = $conn->real_escape_string($_POST['email']);
  $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
  $address = $conn->real_escape_string($_POST['address']);
  $city = $conn->real_escape_string($_POST['city']);
  $state = $conn->real_escape_string($_POST['state']);
  $zip = $conn->real_escape_string($_POST['zip']);

  // Check if email exists
  $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
  $stmt->bind_param("s", $email);
  $stmt->execute();
  $stmt->store_result();

  if ($stmt->num_rows > 0) {
    echo "<script>alert('Email already registered'); window.history.back();</script>";
  } else {
    // Insert new user
    $stmt = $conn->prepare("INSERT INTO users (name, email, password, address, city, state, zip) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssss", $name, $email, $password, $address, $city, $state, $zip);

    if ($stmt->execute()) {
      // Optional: Log the user in after signup
      session_start();
      $_SESSION['user_id'] = $conn->insert_id;
      header("Location: profile.php");
      exit;
    } else {
      echo "<script>alert('Signup failed'); window.history.back();</script>";
    }
  }
} else {
  echo "Invalid Request";
}

$conn->close();
?>
