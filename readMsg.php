<?php
// $db=mysqli_connect("localhost","root","","signupforms");
include 'connect.php';
session_start();
$username=$_SESSION['username'];
$q="SELECT * FROM `msg`";
if($rq=mysqli_query($con,$q)){
    if(mysqli_num_rows($rq)>0){
        while($data=mysqli_fetch_assoc($rq)){
            if($data["uname"]==$username){
            ?>
            <p class="sender">
                <span><b><?= "You : " ?></b></span>
                <?= $data["msg"]  ?>
            </p>
            <?php

            }else{
            ?>
            <p>
                <span><b><?= $data["uname"]." : " ?></b></span>
                <?= $data["msg"]  ?>
            </p>
            <?php
            }
        }
    }else{
        echo "<h3>Chat is empty at this moment!!</h3>";
    }
}


?>