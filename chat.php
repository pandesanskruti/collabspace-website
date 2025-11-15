<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}
?>

<?php
    // Your database connection code here
    include 'connect.php';
    // Get chatroom information based on chatroom_id
    $chatroomId = $_GET['chatroom_id'];
    $chatroomQuery = "SELECT name,creator, members FROM chatrooms WHERE id = $chatroomId";
    $result = $con->query($chatroomQuery);

    if ($result->num_rows > 0) {
        $chatroom = $result->fetch_assoc();
        $chatroomName = $chatroom['name'];
        $chatroomCreator = $chatroom['creator'];
        $members = $chatroom['members'];

        // Check if the user is the creator of the chatroom
        $isCreator = ($_SESSION['username'] == $chatroomCreator);

        // Check if the user is a member of the chatroom
        $isMember = (strpos($members, $_SESSION['username']) !== false);
    
    } else {
        // Handle the case where the chatroom is not found
        echo "Chatroom not found.";
        exit;
    }

    // Close the database connection
    $con->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chatroom</title>
    <link rel="stylesheet" href="css/chat.css">
</head>
<body>
    <?php include 'nav.php'; ?>
    <div class="chat-block">
        <div class="chatroom-edit option-container">
            <?php if ($isCreator): ?>
            
            <!-- Option for the creator to add members -->
            <form class="add-member-form" action="add_member.php" method="get">
                <label for="new_member">Add Member:</label>
                <input type="text" id="new_member" name="new_member" required>
                <input type="hidden" name="chatroom_id" value="<?php echo $chatroomId; ?>">
                <input type="submit" value="Add Member">
            </form>
            
            <!-- Option for the creator to remove members -->
            <form class="remove-member-form" action="remove_member.php" method="get">
                <label for="member_to_remove">Remove Member:</label>
                <select id="member_to_remove" name="member" required>
                    <?php
                    // Populate the dropdown with current members
                    $membersArray = explode(',', $members);
                    
                    foreach ($membersArray as $member) {
                        // Trim to remove leading/trailing whitespaces
                        $member = trim($member);
                        echo "<option value='$member'>$member</option>";
                    }
                    ?>
                </select>
                <input type="hidden" name="chatroom_id" value="<?php echo $chatroomId; ?>">
                <input type="submit" value="Remove Member">
            </form>

            <!-- Option for the creator to delete the chatroom -->
            <a class="delete-chatroom" href="delete_chatroom.php?chatroom_id=<?php echo $chatroomId; ?>">Delete Chatroom</a>
            
            <?php elseif ($isMember): ?>
            <!-- Option for members to leave the chatroom -->
            <a class="leave-chatroom" href="leave_chatroom.php?chatroom_id=<?php echo $chatroomId; ?>">Leave Chatroom</a>    
            <?php endif; ?>
        </div>

        <h2>Chatroom: <?php echo $chatroomName; ?></h2>
        <p>Members: <?php echo $members; ?></p>
        <div id="chat-container"></div>
        <form id="message-form">
            <input type="text" id="message-input" placeholder="Type your message">
            <input type="submit" value="Send">
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script>
        $(document).ready(function() {
            // Initial load of chat messages
            loadChat();

            // Poll for new messages every 2 seconds
            setInterval(function() {
                loadChat();
            }, 2000);

            // Handle form submission
            $("#message-form").submit(function(e) {
                e.preventDefault();

                var message = $("#message-input").val();

                // Check if the message is not empty
                if (message.trim() !== "") {
                    $.post("send_message.php", { chatroom_id: <?php echo $_GET['chatroom_id']; ?>, message: message }, function(data) {
                        // Clear the input field
                        $("#message-input").val("");
                        // Load the updated chat messages
                        loadChat();
                    });
                }
            });

            // Function to load chat messages
            function loadChat() {
                $.get("get_messages.php", { chatroom_id: <?php echo $_GET['chatroom_id']; ?> }, function(data) {
                    $("#chat-container").html(data);
                    // Scroll to the bottom to show the latest messages
                    $("#chat-container").scrollTop($("#chat-container")[0].scrollHeight);
                });
            }
        });
    </script>
</body>
</html>
