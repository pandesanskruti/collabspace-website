<?php
$db=mysqli_connect("localhost","root","","signupforms");
session_start();
$msg=$_GET["msg"];
$name=$_SESSION['username'];;

// check whether phone no. is in database or not
// $q="SELECT * FROM `users` WHERE uname='$name'";
// if($rq=mysqli_query($db,$q)){
//     if(mysqli_num_rows($rq)==1){

        // phone no. in database, so enter data to table
        $q="INSERT INTO `msg`(`uname`, `msg`) VALUES ('$name','$msg')";
        $rq=mysqli_query($db,$q);
//     }
// }

?>