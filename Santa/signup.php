<?php
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "everyday_santa";

$conn = new mysqli($servername, $username, $password, $dbname);
header("Access-Control-Allow-Origin: *");
header('Content-Type: application/json');

$data = json_decode(file_get_contents("php://input"), true);

if (isset($data['email'], $data['password'])) {
  $email = $conn->real_escape_string($data['email']);
  $hashedPassword = password_hash($data['password'], PASSWORD_DEFAULT);

  $check = $conn->query("SELECT id FROM users WHERE email = '$email'");
  if ($check->num_rows > 0) {
    echo json_encode(['status' => 'error', 'message' => 'Email already registered']);
  } else {
    $sql = "INSERT INTO users (email, password) VALUES ('$email', '$hashedPassword')";
    if ($conn->query($sql)) {
      echo json_encode(['status' => 'success', 'message' => 'User registered']);
    } else {
      echo json_encode(['status' => 'error', 'message' => 'Signup failed']);
    }
  }
} else {
  echo json_encode(['status' => 'error', 'message' => 'Missing email or password']);
}

$conn->close();
?>
