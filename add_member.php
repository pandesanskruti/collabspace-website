<?php
session_start();
include 'connect.php';

$chatroomId = $_GET['chatroom_id'];
$creator = $_SESSION['username'];
$newMember = $_GET['new_member'];

// Check if the user is the creator of the chatroom
$checkCreatorQuery = "SELECT creator FROM chatrooms WHERE id = $chatroomId";
$result = $con->query($checkCreatorQuery);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    if ($row['creator'] == $creator) {
        // Add the new member to the chatroom
        $addMemberQuery = "UPDATE chatrooms SET members = CONCAT(members, ',', '$newMember') WHERE id = $chatroomId";
        $con->query($addMemberQuery);

        // Redirect to the chatroom page
        header("Location: chat.php?chatroom_id=$chatroomId");
        exit();
    } else {
        // Handle the case where the user is not the creator
        echo "You don't have permission to add members to this chatroom.";
        exit();
    }
} else {
    // Handle the case where the chatroom is not found
    echo "Chatroom not found.";
    exit();
}

$con->close();
?>
