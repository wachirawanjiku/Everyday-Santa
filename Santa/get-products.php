<?php
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "everyday_santa";

$conn = new mysqli($servername, $username, $password, $dbname);

header("Access-Control-Allow-Origin: *");
header('Content-Type: application/json');

if ($conn->connect_error) {
  echo json_encode(['status' => 'error', 'message' => 'Connection failed: ' . $conn->connect_error]);
  exit();
}

$sql = "SELECT * FROM products";
$result = $conn->query($sql);

$products = [];

if ($result && $result->num_rows > 0) {
  while($row = $result->fetch_assoc()) {
    $products[] = $row;
  }
  echo json_encode(['status' => 'success', 'products' => $products]);
} else {
  echo json_encode(['status' => 'empty', 'products' => []]);
}

$conn->close();
?>
