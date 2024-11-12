<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clients</title>
    <link rel="stylesheet" href="css/clients.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
<?php
session_start();
$username = $_SESSION['username'];
include '../../connection/connection.php';

$sql = "SELECT * FROM `user` WHERE `username` = '$username'";
$res = mysqli_query($conn, $sql);
if (mysqli_num_rows($res) == 0) {
    header("location: ../../log/logout.php");
    exit;
}
?>

<style>
    .menu{
        margin-right: 149px;
    }
.logout-icon a {
    color: #ffffff; 
    font-size: 20px; 
    display: inline-block;
    vertical-align: middle;
    margin-top: 10px;
}

.logout-icon a:hover {
    color: #cccccc; 
    text-decoration: none; 
}

    </style>
</head>
<body>
<div class="header">
   
   <div class="logout-icon" style="float: right; margin-right: 20px;">
   <a href="../../log/logout.php">
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
        
        
    </div>
</div>

<br><br>

<div class="container" id="requestsContainer">
    <?php
    $query = "SELECT * FROM request WHERE `receivedusername` = '$username' AND `status` = 'pending' ORDER BY `date` DESC";
    $skillResult = mysqli_query($conn, $query);

    if (mysqli_num_rows($skillResult) > 0) {
        echo "<h2>Pending Requests</h2>";
        while ($row = mysqli_fetch_assoc($skillResult)) {
            $name = $row['sentusername'];
            $title = $row['title'];
            $desc = $row['description'];
            $num = $row['num'];
            $date = $row['date'];
            $whatsappLink = "https://wa.me/$num";

            echo "<div class='request'>";
            if (strpos($title, 'Applied for Offer:') === 0) {
                echo "<center><p>$name   $title</center></p>";
            } else {
                echo "<center><p>$name requested to hire you</center></p>";
            }
            echo "<p>$desc</p>";
            echo "<p>$date</p>";
            echo "<form action='' method='POST'>";
            echo "<div class='button-group'>";
            echo "<button name='accepted' value='" . $row['id'] . "'>Accept</button>";
            echo "<button class='rejected' name='rejected' value='" . $row['id'] . "'>Reject</button>";
            echo "</div>";
            echo "</form>";
            echo "</div>";
        }

        if(isset($_POST['accepted'])){
            $id = $_POST['accepted'];
            $s = "UPDATE request SET `status` = 'Accepted' WHERE `id` = '$id'";
            $r = mysqli_query($conn, $s);
            echo "<script>";
            echo "setTimeout(function() {";
            echo "    window.location.href = '$whatsappLink';";
            echo "}, 0);";
            echo "</script>";
        }
        if(isset($_POST['rejected'])){
            $id = $_POST['rejected'];
            $s = "UPDATE request SET `status` = 'Rejected' WHERE `id` = '$id'";
            $r = mysqli_query($conn, $s);
            echo "<script>";
            echo "setTimeout(function() {";
            echo "    window.location.href = 'clients.php';";
            echo "}, 0);";
            echo "</script>";
        }
    } else {
      echo "<div class='no-requests'><p>No pending requests</p></div>";
    }
    ?>
</div>



</body>
</html>
