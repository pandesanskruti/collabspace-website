<?php

// Works only for unhashed passwords.
// Sample: 
// Username: bhagwat
// Password: 123
// Modify code to work with hashing.

// Include database configuration
include 'connect.php';

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Query to check user credentials
    $sql = "SELECT * FROM registration1 WHERE username = ? AND password = ?";
    $stmt = $con->prepare($sql);
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        // Successful login
        $_SESSION['username'] = $username;
        header("Location: indexTwo.html");
        exit();
    } else {
        // Invalid login
        echo "Invalid username or password.";
    }
    $stmt->close();
}
$con->close();
?>
