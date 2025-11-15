<?php 
    session_start();
    if(!isset($_SESSION['username']))
    {
       header('location:loginsignup.html');
    }
?>

<?php include 'nav.php'; ?>
<link rel="stylesheet" href="css/pub_chatroom.css">

<!-- HTML Content -->
<div class="chat-body">
    <h1>Public ChatRoom</h1>
    <div class="chat">
        <h2>Welcome <span><?= $_SESSION['username'];?> !</span></h2>
        <div class="msg">
            
        </div>
        <div class="input_msg">
            <input type="text" placeholder="Enter msg here" id="input_msg">
            <button onclick="update()">Send</button>
        </div>
    </div>
</div>
</body>
<script src="js/send.js"></script>
</html>

