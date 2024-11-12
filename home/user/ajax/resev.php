
<style>
  .revs {
    border: 2px solid #FFA800;
    border-radius: 10px;
}
h1{
  margin-bottom: 45px;
}
</style>
<center>
  <h1>Who Reserve</h1>
</center>
<?php
include "../../../connection/connection.php";
if (isset($_GET['evid'])) {
                  $id = $_GET['evid'];
                $revquery = "SELECT * FROM `event_reserved` WHERE `event_id` = '$id'";
                $revres = mysqli_query($conn, $revquery);

                while ($row = mysqli_fetch_assoc($revres)) {
                    $n = $row['username'];
                    $d = $row['date'];
                    echo"<div class='revs'>";
                    echo"<center>";
                    echo "<h3>$n</h3>";
                    echo "<p>$d</p>";
                    echo"</center>";
                    
                    echo"</div>";
                    echo"<br><br><br>";
                }
            } else {
                echo "No post ID submitted.";
            }
            ?>

            