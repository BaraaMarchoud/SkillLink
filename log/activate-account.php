<?php

$token = $_GET["token"];
$username = $_GET['username'];

// $token_hash = hash("sha256", $token);

require "../connection/connection.php";



$sql = "SELECT * FROM `user`
        WHERE `verification_token` = ' $token'";

$result = mysqli_query($conn,$sql);
$row = mysqli_fetch_assoc($result);
$num = mysqli_num_rows($result);





$sqll = "UPDATE user
        SET verification_token = NULL
        WHERE `username` = '$username'";

$res = mysqli_query($conn,$sqll);

if ($res === false) {
    die("Error updating user: " . $conn->error);
}

?>
<!DOCTYPE html>
<html>
<head>
    <title>Account Activated</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../out/index.css">
</head>
<body>

<div class="b">
    </div>
    <br><br> <br><br><br><br>

<center>
    <div class="k">
    <h1>Account Activated</h1>
    <p>Account activated successfully. You can now
       <a href="login.php">log in</a>.</p>
       </div>
       </center>

       <style>
        .k{
            width: 450px;
            margin-left: 0px;
            margin-top:170px;
            border: 2px solid #0166FF;
            border-radius: 14px;
        }
       </style>

</body>
</html>