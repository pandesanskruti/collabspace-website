<?php
$host = 'localhost';
$dbname = 'signupforms';
$user = 'root';
$pass = '';

$conn = new mysqli($host, $user, $pass, $dbname);
session_start();
$currentUsername = $_SESSION['username'];
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $chatroomId = $_GET['chatroom_id'];

    $selectMessagesQuery = "SELECT sender, message, timestamp FROM chat_messages WHERE chatroom_id = '$chatroomId' ORDER BY timestamp ASC";
    $result = $conn->query($selectMessagesQuery);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $sender = $row['sender'];
            $message = $row['message'];
            $timestamp = $row['timestamp'];

            if($sender==$currentUsername){
                $sender='You';
                "<b>".$sender."</b>";
                ?>
                <div class="sender msg">
                    <?php
                    echo "<p>[$timestamp] <b>$sender:</b> $message</p>";
                    ?>
                </div>
            <?php
            }else{
                ?>
                <div class="msg">
                <?php
                    echo "<p>[$timestamp] <b>$sender:</b> $message</p>";
                    ?>
                </div>
            <?php
            }
            
            // echo "<p>[$timestamp] $sender: $message</p>";
        }
    } else {
        echo "No messages in this chatroom.";
    }
}

$conn->close();
?>
