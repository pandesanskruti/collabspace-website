<?php
$host = 'localhost';
$dbname = 'signupforms';
$user = 'root';
$pass = '';

$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

session_start();
$currentUsername = $_SESSION['username'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $chatroomId = $_POST['chatroom_id'];
    $message = $_POST['message'];

    $insertMessageQuery = "INSERT INTO chat_messages (chatroom_id, sender, message) VALUES ('$chatroomId', '$currentUsername', '$message')";
    $conn->query($insertMessageQuery);
}

$conn->close();
?>
