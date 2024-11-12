<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    
<?php
session_start();
include "../../../connection/connection.php";
if (isset($_GET['q'])) {
    $searchValue = $_GET['q'];
    $username = $_SESSION['username'];

$sql = "SELECT `offers`.*, `user`.`num`, `apply`.`username`
        FROM `offers`
        LEFT JOIN `user` ON `offers`.`username` = `user`.`username`
        LEFT JOIN `apply` ON `offers`.`id` = `apply`.`offer_id` AND `apply`.`username` = '$username'
        WHERE `apply`.`username` IS NULL and `offers`.`username` != '$username' and lower(`title`) LIKE '%$searchValue%'
        ORDER BY `offers`.`date` DESC";
$r = mysqli_query($conn, $sql);
    if (!$r) {
        die("Query failed: " . mysqli_error($conn));
    }
if (mysqli_num_rows($r) > 0) {
    echo "<div class='container'>";
    echo "<h2>Oppurnuties</h2>";
    $name = "";
    while ($row = mysqli_fetch_assoc($r)) {
            $id = $row['id'];
            $q = "SELECT `username` from `offers` where `id` = '$id'";
            $rr = mysqli_query($conn,$q);
            
            $row2 = mysqli_fetch_assoc($rr);
                    $name = $row2['username'];
            

        $title = $row['title'];
        $desc = $row['description'];
        $date = $row['date'];
        $num = $row['num'];
        echo "<div class='request'>";
        echo "<center><p> $name Offer Opportunity </center></p>";
        echo"<br><br>";
        echo "<center><p> $title</p></center>";
        echo "<p> $desc</p>";
        echo "<p> $date</p>";
        $whatsappLink = "https://wa.me/$num"; 
        echo "<form action='' method='POST'>";
        echo "<button name='apply' value='" . $row['id'] . "'>Easy Apply</button>";
        echo "<button class='rejected' name='contact' value='" . $row['id'] . "'>Contact</button>";
        echo "</form>";
        echo "</div>";
        }
    }else{
        echo "<center><h1> No Result Found</center></p>";
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

    }
?>



</body>
</html>