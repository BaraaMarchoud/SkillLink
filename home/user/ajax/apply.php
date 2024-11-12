<style>
  .revs {
    border: 2px solid #FFA800;
    border-radius: 10px;
    padding: 20px;
  }

  h1 {
    margin-bottom: 45px;
  }

  .d {
    background-color: #FFA800;
    color: white;
    border: none;
    padding: 10px 20px;
    border-radius: 9px;
    font-weight: bold;
    cursor: pointer;
    display: block;
    margin-top: 10px;
  }

  .revs a{
    text-decoration: none;
  }

  .revs span{
    margin-left:300px;
  }
</style>

<h1>Who Applied</h1>

<?php
include "../../../connection/connection.php";
if (isset($_GET['ofid'])) {
    $id = $_GET['ofid'];
    $revquery = "SELECT * FROM `apply` WHERE `offer_id` = '$id'";
    $revres = mysqli_query($conn, $revquery);

    if (mysqli_num_rows($revres) > 0) {
        while ($row = mysqli_fetch_assoc($revres)) {
            $idd = $row['id'];
            $n = $row['username'];
            $d = $row['date'];

            $q = "SELECT * FROM user WHERE `username` = '$n'";
            $p = mysqli_query($conn,$q);
            $row = mysqli_fetch_assoc($p);
            $num = $row['num'];
            $whatsappLink = "https://wa.me/$num"; 


            echo "<div class='revs'>";
            echo "<h3>$n</h3>";
            echo "<p>$d</p>";
            echo"<a href='ajax/delapp.php?id=$idd'>";
            echo "<button name='dell' class='d'>Delete</button>";
            echo"</a>";
            echo"<a href='$whatsappLink'>";
            echo"<span style='float: right; '>";
           
            echo "<button class='d' style='    position: relative;
            top: -54px;'>Contact</button>";
            
            echo"</span>";
            echo"</a>";
            echo "</div>";
            echo "<br>";
        }
    } else {
        echo "No applications found.";
    }
} else {
    echo "No post ID submitted.";
}



?>
<!-- 
<script>
                      function del(ofId) {
                          fetch(`ajax/apply.php?ofid=${ofId}`)
                              .then(response => response.text())
                              .then(data => {
                                  document.getElementById("applyContent").innerHTML = data;
                                  document.getElementById("applyModal").style.display = "block";
                              })
                              .catch(error => console.log(error));
                      }
                  </script> -->