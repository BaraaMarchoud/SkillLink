<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css/offer.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">


</head>
<body>

<style>

    .menu{

        margin-left: 149px;
    }
    .search-box{
        width: 250px;
        top: 21%;
    }
</style>


<?php
session_start();
$username = $_SESSION['username'];
$fname = $_SESSION['fname'];
$lname = $_SESSION['lname'];
$skill = $_SESSION['skill'];
include '../../connection/connection.php';

$sql = "SELECT * FROM `user` WHERE `username` =  '$username'";
$res = mysqli_query($conn, $sql);
if (mysqli_num_rows($res) == 0) {
    header("location: logout.php");
    exit;
}

?>
<div class="header">
   
   <div class="logout-icon" style="float: right; margin-right: 20px;">
   <a href="logout.php">
           <i class="fa fa-sign-out" aria-hidden="true" title="Logout"></i>
       </a>
   </div>
  
</div>


  <div class="navbar">
    <div class="profile">
    <?php
    
        $row = mysqli_fetch_assoc($res);
        $profileImage = $row['profile'];
        echo "<a href='profile.php'><img class='profile-image' src='images/profile_images/$profileImage' alt='Profile Image'></a>";
    
   ?>
      
    </div>

  <div class="menu">
     <ul>
      <li><a href="../home.php">Home</a></li>
      <li><a href="findskiller.php">Find Skiller</a></li>
      <li><a href="clients.php">Requests</a></li>
      <li><a href="offer.php">Offering</a></li>
      <li><a href="events.php">Events</a></li>
      
     </ul>
     </div>

        <div class="rest">
            <a href="add_offer.php"> <button class="add-offer-button">Offer Oppurtunity</button></a>
            <div class="search-icon" id="search-icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24">
                    <circle cx="11" cy="11" r="8"></circle>
                    <path d="M21 21l-4.35-4.35"></path>
                </svg>
            </div>
        </div>
    </div>

    <br><br>

    <?php


echo "<div class='container' id='or'>";
    $sql = "SELECT `offers`.*, `user`.`num`, `apply`.`username`
        FROM `offers`
        LEFT JOIN `user` ON `offers`.`username` = `user`.`username`
        LEFT JOIN `apply` ON `offers`.`id` = `apply`.`offer_id` AND `apply`.`username` = '$username'
        LEFT JOIN `cats` ON `offers`.`cat_id` = `cats`.`id`
        WHERE `apply`.`username` IS NULL and `offers`.`username` != '$username'
        ORDER BY `offers`.`date` DESC";
    $r = mysqli_query($conn, $sql);
    if (!$r) {
        die("Query failed: " . mysqli_error($conn));
    }
    if (mysqli_num_rows($r) > 0) {
    
        echo "<h2>Oppurnuties</h2>";
        $name = "";
        while ($row = mysqli_fetch_assoc($r)) {
            $id = $row['id'];
            $cid = $row['cat_id'];
            $q = "SELECT `username` from `offers` where `id` = '$id'";
            $rr = mysqli_query($conn,$q);
            
            $row2 = mysqli_fetch_assoc($rr);
            $name = $row2['username'];

            $qq = "SELECT `name` from `cats` where `id` = '$cid'";
            $rrr = mysqli_query($conn,$qq);
            
            $row3 = mysqli_fetch_assoc($rrr);
            $cat_name = $row3['name'];
            

        $title = $row['title'];
        $desc = $row['description'];
        $date = $row['date'];
        $num = $row['num'];
        $salary = $row['salary'];
        echo "<div class='request'>";
        echo "<center><p> $name Offer Opportunity </center></p>";
        echo"<br><br>";
        echo "<center> <p> $cat_name</p></center>";
        echo "<center> <p> $title</p></center>";
        echo"<br>";
        echo "<p> $desc</p>";
        echo"<br>";
        echo "<p> $salary</p>";
        echo"<br>";
        echo "<p> $date</p>";
        $whatsappLink = "https://wa.me/$num"; 
        echo "<form action='' method='POST'>";
        echo "<button name='apply' value='" . $row['id'] . "'>Easy Apply</button>";
        echo"<input name='cname' type='hidden' value='$cat_name'></input>";
        echo "<button class='rejected' name='contact' value='" . $row['id'] . "'>Contact</button>";
        echo "</form>";
        echo "</div>";
        }
        echo"</div>";
    }else{
        echo "<center><div class='no-requests'><p>No new Offering</p></div></center>";
    }

    if(isset($_POST['contact'])){
        $id = $_POST['contact'];
        echo "<script>";
                  echo "setTimeout(function() {";
                  echo "    window.location.href = '$whatsappLink';";
                  echo "}, 0);";;
                  echo "</script>";
      }

      if(isset($_POST['apply'])){
        $id = $_POST['apply'];
        $cid = $_POST['cname'];
        $query = "SELECT * FROM `skilleduser` 
          LEFT JOIN `skill` ON `skilleduser`.`skill_idd` = `skill`.`skill_id`
          LEFT JOIN `cats` ON `skill`.`cat_id` = `cats`.`id` 
          WHERE `skilleduser`.`username` = '$username' and `cats`.`name` = '$cid'";
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
            echo "    window.location.href = 'offer.php';";
            echo "}, 0);";;
            echo "</script>";
    
        }else{
            echo 'Error: ' . mysqli_error($conn);    }
      }
    else{
        echo"<script>alert('You must have skill of that category');</script>";
    }
}
echo"</div>";

?>
<div id="result"></div>
<div class="search-box" id="search-box">
    <input type="text" id="search_text" onkeyup="Search(this.value)" placeholder="Search...">
</div>



    <script src="scripts/offer.js"></script>

</body>
</html>