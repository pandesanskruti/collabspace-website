<?php include 'nav.php'; ?>

<!-- <!DOCTYPE html> -->
<?php session_start(); ?>
<?php  $name=$_SESSION['username']; ?>
<?php
    include ('connect.php');
    if(isset($_POST['submit']))
    {
        $username=$name;
        $pro_name=$_POST['pro_name'];
        $techno_name=$_POST['techno_name'];
        $doc_link=$_POST['doc_link'];
        // $file_name=$_FILES["doc"]["name"];
        // $location="uploaded_files/";
        // $doc_name=implode(",",$file_name);

        // if(!empty($file_name))
        // {
        //     foreach($file_name as $key=>$val)
        //     {
        //         $targetPath=$location .$val;
        //         move_uploaded_file($_FILES["doc"]["tmp_name"][$key],$targetPath);
        //     }
        // }
        $insert="INSERT INTO uploads(username,Project_Name,technologies,file)VALUES('$username','$pro_name','$techno_name','$doc_link')";
        $run=mysqli_query($con,$insert);
        if($run==true){
            $upload="Data Uploaded";
        }
    }
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Uploading Page</title>
    <link rel="stylesheet" href="css/log.css">
    <link rel="stylesheet" href="css/uploads.css">
</head>
<body>
    <div class="container1" style="margin-top:20px;">
        <div class="left">
            <img src="img/upload1.jpg" alt="upload_image" style="margin-top:90px;">
        </div>
        <div class="right">
            <h1>Upload Your Projects here : </h1>
            <div class="tbox">
                <p style="color:green; font-weight:bold; font-size:1.3rem;">
                    <?php
                        if(isset($upload)){
                            echo $upload;
                        }
                    ?>
                </p>
            </div>
            <form action="" method="POST" enctype="multipart/form-data">
                <!-- <label>Username : </label>
                <input type="text" name="username"  required>
                <br><br> -->
                <div class="tbox">
                    <label>Project Name : </label><br>
                    <input type="text" name="pro_name"  required>
                </div>
                <br><br>
                <div class="tbox">
                    <label>Technologies Used : </label><br>
                    <input type="text" name="techno_name"  required>
                </div>
                <br><br>
                <div class="tbox">
                    <label>Upload File Link : </label><br>
                    <input type="text" name="doc_link" multiple="" required>
                </div>
                <br><br>
                <div class="tbox">
                    <input type="submit" class="btn" value="Upload files" name="submit">
                </div>
            </form>
        </div>
    </div>
</body>
</html>


