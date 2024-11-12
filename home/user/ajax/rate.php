
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
  <h1>Rates</h1>
</center>
<?php
include "../../../connection/connection.php";
if (isset($_GET['q'])) {
                  $id = $_GET['q'];
                $revquery = "SELECT * FROM ratings WHERE `post_id` = '$id' order by `date` desc";
                $revres = mysqli_query($conn, $revquery);

                while ($row = mysqli_fetch_assoc($revres)) {
                    $n = $row['username'];
                    $d = $row['date'];
                    $r = $row['rating'];
                    echo"<div class='revs'>";
                    echo"<center>";
                    echo "<h3>$n</h3>";
                    ?>
                    <p>
                    <span><?php echo "$r "; ?></span>
                        <i class="fa fa-star" style="color: #FFD700;"></i>
                        <br>
                        <?php echo $d;
                         ?>
                   
                    </p>
                    <?php
                    echo"</center>";
                    
                    echo"</div>";
                    echo"<br><br><br>";
                }
            } else {
                echo "No post ID submitted.";
            }
            ?>

            