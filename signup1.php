<?php
// Include database configuration
include 'connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Validate user input
    if (!empty($username) && !empty($email) && !empty($password)) {
        // Check if the username or email already exists
        $sql = "SELECT * FROM registration1 WHERE username = ? OR email = ?";
        $stmt = $con->prepare($sql);
        $stmt->bind_param("ss", $username, $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            echo "Username or email already exists.";
        } else {
            // Insert the new user into the database without hashing the password
            $sql = "INSERT INTO registration1 (username, email, password) VALUES (?, ?, ?)";
            $stmt = $con->prepare($sql);
            $stmt->bind_param("sss", $username, $email, $password);

            if ($stmt->execute()) {
                echo "Registration successful!";
                header("Location: loginsignup.html"); // Redirect to login page after successful signup
                exit();
            } else {
                echo "Error: " . $con->error;
            }
        }
        $stmt->close();
    } else {
        echo "All fields are required.";
    }
}
$con->close();
?>
