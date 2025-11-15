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
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $chatroomName = $_POST['chatroom_name'];
    $creator = $_POST['creator'];
    $description = $_POST['description'];
    $membersInput = $_POST['members'];
    $members = explode(',', $membersInput);

    $insertChatroomQuery = "INSERT INTO chatrooms (name, creator, description, members) VALUES ('$chatroomName', '$creator', '$description', '$membersInput')";
    $conn->query($insertChatroomQuery);

    $chatroomId = $conn->insert_id;

    if ($chatroomId > 0) {
        foreach ($members as $member) {
            $insertMembersQuery = "INSERT INTO chatroom_members (chatroom_id, member) VALUES ('$chatroomId', '$member')";
            $conn->query($insertMembersQuery);
        }

        header("Location: chat.php?chatroom_id=$chatroomId");
        exit();
    } else {
        echo "Error creating chatroom.";
    }
}

$conn->close();
?>
