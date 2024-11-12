<?php
include "../../../connection/connection.php";

session_start();
$username = $_SESSION['username'];


if(isset($_GET['ofid'])){
    $id = $_GET['ofid'];
    $cid = $_GET['cname'];
    $name = $_GET['user'];
    $query = "SELECT * FROM `skilleduser` 
      LEFT JOIN `skill` ON `skilleduser`.`skill_idd` = `skill`.`skill_id`
      LEFT JOIN `cats` ON `skill`.`cat_id` = `cats`.`id` 
      WHERE `skilleduser`.`username` = '$username' and `cats`.`id` = '$cid'";
    $rq = mysqli_query($conn, $query);
    $num = mysqli_num_rows($rq);
    if($num > 0){
    $s = "INSERT INTO `apply`( `username`, `offer_id`, `date`)
     VALUES ('$username','$id',NOW())";
    $r = mysqli_query($conn,$s);

    if($r){

        echo "<script>";
        echo "setTimeout(function() {";
        echo"alert('You applied Successfully');";    
        echo "    window.location.href = '../profile.php?username=$name';";
        echo "}, 0);";;
        echo "</script>";

    }else{
        echo 'Error: ' . mysqli_error($conn);    }
  }else{
    echo "<script>";
    echo "setTimeout(function() {";
    echo"alert('You must have skill of that category');";    
    echo "    window.location.href = '../profile.php?username=$name';";
    echo "}, 0);";;
    echo "</script>";
}
}else{
echo"<script>alert('You');</script>";
}

?>