<?php
// Start session
session_start();

// Database connection
$host = "localhost";
$user = "root";
$pass = "";
$db = "your_database";

$conn = new mysqli($host, $user, $pass, $db);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get form data
$email = $_POST['email'];
$password = $_POST['password'];

// Prevent SQL injection
$stmt = $conn->prepare("SELECT * FROM users WHERE email=?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

// Check if user exists
if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();

    // If password is hashed (recommended)
    if (password_verify($password, $user['password'])) {
        $_SESSION['email'] = $email;
        echo "Login successful!";
        // header("Location: dashboard.php");
    } else {
        echo "Invalid password!";
    }
} else {
    echo "User not found!";
}

$conn->close();
?>