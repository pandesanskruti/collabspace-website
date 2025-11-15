<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$host = 'localhost';
$dbname = 'signupforms';
$user = 'root';
$pass = '';

$con = new mysqli($host, $user, $pass, $dbname);

if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}

$username = $_SESSION['username'];

// Fetch chatrooms where the user is a member
$selectChatroomsQuery = "SELECT c.id, c.name, c.creator, c.description, c.members FROM chatrooms c JOIN chatroom_members m ON c.id = m.chatroom_id WHERE m.member = '$username'";
$result = $con->query($selectChatroomsQuery);

$chatrooms = array();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $chatrooms[] = $row;
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="css/dashboard.css">
</head>
<body>
    <?php include 'nav.php'; ?>
    <div class="dash_container">
        <h2>Welcome, <?php echo $username; ?>!</h2>
        <h3><span>Chatrooms</span> in which you are included</h3>
        <div class="dash_table">
            <table>
                <thead>
                    <tr>
                        <th>Chatroom Name</th>
                        <th>Creator</th>
                        <th>Members</th>
                        <th>Description</th>
                        <th>Join</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($chatrooms as $chatroom): ?>
                        <tr>
                            <td><?php echo $chatroom['name']; ?></td>
                            <td><?php echo $chatroom['creator']; ?></td>
                            <td><?php echo $chatroom['members']; ?></td>
                            <td><?php echo $chatroom['description']; ?></td>
                            <td><a href="chat.php?chatroom_id=<?php echo $chatroom['id']; ?>" class="join-link">Join</a></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <span>Want to Create New Chatroom ? </span><a href="create_chatroom.php" id="cnc">Create New Chatroom</a>
    </div>
</body>
</html>
