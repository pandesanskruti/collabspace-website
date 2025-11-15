<?php
session_start();
include 'connect.php';

$chatroomId = $_GET['chatroom_id'];
$username = $_SESSION['username'];

// Remove the user from the chatroom members
$leaveChatroomQuery = "UPDATE chatrooms SET members = REPLACE(members, '$username', '') WHERE id = $chatroomId";
$con->query($leaveChatroomQuery);

// Redirect to a page after leaving
header("Location: chatrooms.php");
exit();

$con->close();
?>
