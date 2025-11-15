<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Chatroom</title>
    <link rel="stylesheet" href="css/create_chatroom.css">
</head>
<body>
    <?php include 'nav.php'; ?>
    <div class="crc">
        <h2>Create Chatroom</h2>
        <form action="create_chatroom_process.php" method="post">
            <label for="chatroom_name">Chatroom Name:</label>
            <input type="text" id="chatroom_name" name="chatroom_name" required>

            <label for="creator">Chatroom Creator:</label>
            <input type="text" id="creator" name="creator" required>

            <label for="description">Chatroom Description:</label>
            <textarea id="description" name="description" rows="4" required></textarea>

            <label for="members">Members (comma-separated usernames):</label>
            <input type="text" id="members" name="members">

            <input type="submit" value="Create Chatroom">
        </form>
    </div>

</body>
</html>
