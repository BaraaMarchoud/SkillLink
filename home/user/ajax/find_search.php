<link rel="stylesheet" href="../css/find_skiller.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>




<div class="skiller">
    <?php
    include "../../../connection/connection.php";
    if (isset($_GET['q'])) {
        session_start();
        $searchValue = $_GET['q'];
        $username = $_SESSION['username'];
        $qq = "SELECT DISTINCT u.username, u.profile, u.gender, u.cat
                FROM skilleduser s
                INNER JOIN user u ON s.username = u.username
                WHERE LOWER(u.username) LIKE '%$searchValue%' AND u.username != '$username'";
        $rr = mysqli_query($conn, $qq);

        if($num = mysqli_num_rows($rr)){

        while ($skilledUserRow = mysqli_fetch_assoc($rr)) {
            $image = $skilledUserRow['profile'];
            $username = $skilledUserRow['username'];
            $cat_id = $skilledUserRow['cat'];
            $gender = $skilledUserRow['gender'];

            $r = "SELECT `name` FROM cats WHERE `id` = '$cat_id'";
            $s = mysqli_query($conn, $r);

            while ($catRow = mysqli_fetch_assoc($s)) {
                $cat = $catRow['name'];

                echo '<div class="skiller-card">';
                echo "<center><p><b>$username</b></p></center>";
                echo "<center><p><b>$cat</b></p></center>";
                echo "<center><p><b>$gender</b></p></center>";
                ?>
                   <div class="image-container">
                      <img src="images/profile_images/<?php echo $image; ?>" alt="Post Image 1">
                      <div class="overlay">
                        <a href="profile.php?username=<?php echo $username; ?>">
                            <button class="overlay-buttonn">View Profile</button>
                        </a>
                        <button class="overlay-button" onclick="openReviewModal('<?php echo $username; ?>')">Send Request</button>
                        </div>
                    </div>
            <?php
                echo '</div>';
              }
            
        }
    }else{
        echo "<center><h1> No Result Found</center></p>";
    }

        if (isset($_POST['submitreq'])) {
            $name = $_SESSION['username'];
            $recname = $_POST['receivedusername'];
            $title = $_POST['title'];
            $desc = $_POST['message'];
            $num = $_POST['num'];
            $q = "INSERT INTO `request`(`sentusername`, `receivedusername`, `title`, `description`, `num`, `date`, `Status`) 
                VALUES ('$name','$recname','$title','$desc','$num',NOW(),'pending')";
            $res = mysqli_query($conn, $q);
            if ($res) {
                echo "<script>alert('Request Sent Successfully');</script>";
            } else {
                echo "Error: " . mysqli_error($conn);
            }
        }
    }
    ?>
</div>

<script>
    
    function openReviewModal(username) {
        document.getElementById("receivedusername").value = username;
        document.getElementById("requestModal").style.display = "block";
    }
</script>