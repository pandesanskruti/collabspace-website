<?php
session_start();
include 'connect.php';

$chatroomId = $_GET['chatroom_id'];
$creator = $_SESSION['username'];
$memberToRemove = $_GET['member'];

// Check if the user is the creator of the chatroom
$checkCreatorQuery = "SELECT creator FROM chatrooms WHERE id = $chatroomId";
$result = $con->query($checkCreatorQuery);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    if ($row['creator'] == $creator) {
        // Remove the specified member from the chatroom
        $removeMemberQuery = "UPDATE chatrooms SET members = REPLACE(members, '$memberToRemove', '') WHERE id = $chatroomId";
        $con->query($removeMemberQuery);

        // Redirect to the chatroom page
        header("Location: chat.php?chatroom_id=$chatroomId");
        exit();
    } else {
        // Handle the case where the user is not the creator
        echo "You don't have permission to remove members from this chatroom.";
        exit();
    }
} else {
    // Handle the case where the chatroom is not found
    echo "Chatroom not found.";
    exit();
}

$con->close();
?>
