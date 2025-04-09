<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "everyday_santa";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$response = array();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Collect data from POST
    $email = $conn->real_escape_string($_POST['email']);
    $password = $_POST['password'];

    // Check if email exists
    $sql = "SELECT id, name, password FROM users WHERE email = '$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Fetch user details
        $user = $result->fetch_assoc();

        // Verify the password
        if (password_verify($password, $user['password'])) {
            // Successful login
            $response['status'] = "success";
            $response['message'] = "Login successful";
            $response['user'] = array("id" => $user['id'], "name" => $user['name']);
        } else {
            // Incorrect password
            $response['status'] = "error";
            $response['message'] = "Invalid password";
        }
    } else {
        // User not found
        $response['status'] = "error";
        $response['message'] = "Email not registered";
    }
} else {
    $response['status'] = "error";
    $response['message'] = "Invalid request method";
}

echo json_encode($response);

$conn->close();
?>