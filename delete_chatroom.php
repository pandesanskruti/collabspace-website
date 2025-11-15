<?php
session_start();
include 'connect.php';

// Check if the user is the creator of the chatroom
$chatroomId = $_GET['chatroom_id'];
$creator = $_SESSION['username'];
$checkCreatorQuery = "SELECT creator FROM chatrooms WHERE id = $chatroomId";

$result = $con->query($checkCreatorQuery);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    if ($row['creator'] == $creator) {
        // Delete the chatroom and associated messages
        $deleteChatroomQuery = "DELETE FROM chatrooms WHERE id = $chatroomId";
        $deleteMessagesQuery = "DELETE FROM messages WHERE chatroom_id = $chatroomId";

        $con->query($deleteChatroomQuery);
        $con->query($deleteMessagesQuery);

        // Redirect to a page after deletion
        header("Location: dashboard.php");
        exit();
    } else {
        // Handle the case where the user is not the creator
        echo "You don't have permission to delete this chatroom.";
        exit();
    }
} else {
    // Handle the case where the chatroom is not found
    echo "Chatroom not found.";
    exit();
}

$con->close();
?>
