
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
  <h1>Reviews</h1>
</center>
<?php
include "../../../connection/connection.php";
if (isset($_GET['q'])) {
                  $id = $_GET['q'];
                $revquery = "SELECT * FROM reviews WHERE `post_id` = '$id'";
                $revres = mysqli_query($conn, $revquery);

                while ($row = mysqli_fetch_assoc($revres)) {
                    $n = $row['username'];
                    $d = $row['date'];
                    $r = $row['review'];
                    echo"<div class='revs'>";
                    echo"<center>";
                    echo "<h3>$n</h3>";
                    echo "<p>$r</p>";
                    echo "<p>$d</p>";
                    echo"</center>";
                    
                    echo"</div>";
                    echo"<br><br><br>";
                }
            } else {
                echo "No post ID submitted.";
            }
            ?>

            