<!DOCTYPE html>
<html>
<head>
    <title>Posts Page</title>
    <link rel="stylesheet" href="user/css/home.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <style>

      #rateModal .modal-content{
        width: 400px;
      }
        .fa.fa-ellipsis-h {
            position: relative;
        }

        .options {
            display: none;
            position: absolute;
            background-color: #fff;
            padding: 10px;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.3);
        }

        .options a {
            display: inline;
            margin-bottom: 5px;
        }
        
        .rating-star {
            color: #ccc;
            cursor: pointer;
            font-size: 30px;
        }

        .rating-star.selected {
            color: #FFD700;
        }

        .rating-stars {
            display: flex;
            justify-content: center;
            align-items: center;
        }
    </style>
</head>
<body>
<div class="header">
   
   <div class="logout-icon" style="float: right; margin-right: 20px;">
   <a href="../log/logout.php">
           <i class="fa fa-sign-out" aria-hidden="true" title="Logout"></i>
       </a>
   </div>
  
</div>


    <div class="navbar">
        <div class="profile">
            <?php
            include '../connection/connection.php';
            session_start();
            $token = $_SESSION['token'];
            // echo "<script>alert('$token');</script>";
            if (!isset($_SESSION['username'])) {
                header("location: user/logout.php");
            } else {
                $username = $_SESSION['username'];
                $sql = "SELECT profile FROM user WHERE username = '$username'";
                $res = mysqli_query($conn, $sql);
                if (mysqli_num_rows($res) == 0) {
                    header("location: logout.php");
                } else {
                    $row = mysqli_fetch_assoc($res);
                    $profileImage = $row['profile'];
                    echo "<a href='user/profile.php'><img class='profile-image' src='user/images/profile_images/$profileImage' alt='Profile Image'></a>";
                }
            }
            ?>
        </div>

        <div class="menu">
            <ul>
                <li><a href="#">Home</a></li>
                <li><a href="user/findskiller.php">Find Skiller</a></li>
                <li><a href="user/clients.php">Requests</a></li>
                <li><a href="user/offer.php">Offering</a></li>
                <li><a href="user/events.php">Events</a></li>
                
            </ul>
        </div>

        <div class="rest">
            <a href="user/post.php"> <button class="add-posts-button">Add Posts</button></a>
            <div class="search-icon" id="search-icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24">
                    <circle cx="11" cy="11" r="8"></circle>
                    <path d="M21 21l-4.35-4.35"></path>
                </svg>
            </div>
        </div>
    </div>

    <div class="post-section">
        <div class="post-background">Browse User Posts</div>
        <h2 class="post-title">Browse User Posts</h2>
    </div>

    <div id="result"></div>

    <div class="posts" id="or">
    <?php
    if (isset($_POST['submitrate'])) {
        $rating = $_POST['rating'];
        $pid = $_POST['post_id'];
        $query = "INSERT INTO ratings (username, post_id, rating, date) 
                  VALUES ('$username', '$pid', '$rating', NOW()) 
                  ON DUPLICATE KEY UPDATE rating = '$rating', date = NOW()";
        $res = mysqli_query($conn, $query);
    }

    $q = "SELECT p.*, COALESCE(r.rating, 0) AS rating
          FROM post p 
          LEFT JOIN ratings r ON p.id = r.post_id AND r.username = '$username' 
          WHERE p.username != '$username' 
          ORDER BY p.date DESC";
    $r = mysqli_query($conn, $q);

    while ($row = mysqli_fetch_assoc($r)) {
        $name = $row['username'];
        $image = $row['image'];
        $title = $row['title'];
        $desc = $row['description'];
        $date = $row['date'];
        $id = $row['id'];
        $rating = $row['rating'];
        ?>
        <div class="post-card">
            <div class="image-container">
                <img src="user/images/posts_images/<?php echo $image; ?>" alt="Post Image">
                <div class="overlay">
                    <button class="btn review" onclick="openReviewModal('<?php echo $id; ?>')">Review</button>
                    <button class="btn rate" onclick="openRateModal('<?php echo $id; ?>', '<?php echo $rating; ?>')">Rate</button>
                </div>
            </div>
            <?php
              $y = "SELECT * FROM ratings where `post_id` = '$id'";
              $u = mysqli_query($conn, $y);
              $num = mysqli_num_rows($u);

              $rating = 0; 

              while ($row = mysqli_fetch_assoc($u)) {
                $rating += $row['rating'];
              }

              if ($num > 0) {
                $avg = $rating / $num;
                $avg = number_format($avg, 1); 
              } else {
                $avg = 0; 
              }
              ?>
              <p>
              <span><?php echo $name; ?></span>
              <span style="float: right;">
                
                <i class="fa fa-star" style="color: #FFD700;"></i>
                <?php echo $avg; ?>
              </span>
            </p>
            <?php
            echo"<h3><b>$title</h3></b>";
            echo"<p>$desc</p>";
            echo"<p>$date</p>";
            ?>
        </div>
    <?php
    }
    ?>
    </div>

    <div id="reviewModal" class="modal">
        <div class="modal-content">
            <span class="close-button" onclick="closeReviewModal()">×</span>
            <form action="" method="POST">
                <h3>Write Your Review</h3>
                <textarea id="review" name="review" placeholder="Type your review here..."></textarea>
                <button type="submit" name="submitrev" class="submitrev">Submit Review</button>
                <input type="hidden" id="postid" name="post_id">
            </form>
        </div>
    </div>

    <div id="rateModal" class="modal">
    <div class="modal-content">
        <span class="close-button" onclick="closeRateModal()">×</span>
        <center>
          <h1>Rate Post</h1>
        </center>
        <div class="rating-stars">
            <span class="rating-star fa fa-star" data-value="1"></span>
            <span class="rating-star fa fa-star" data-value="2"></span>
            <span class="rating-star fa fa-star" data-value="3"></span>
            <span class="rating-star fa fa-star" data-value="4"></span>
            <span class="rating-star fa fa-star" data-value="5"></span>
        </div>
        <form action="" method="POST">
            <input type="hidden" id="rating" name="rating">
            <input type="hidden" id="rate-post-id" name="post_id">
            <center>
            <button type="submit" name="submitrate" class="submitrate">Submit Rating</button>
            </center>
        </form>
    </div>
    </div>


    <?php

    if (isset($_POST['submitrev'])) {
        $review = $_POST['review'];
        $pid = $_POST['post_id'];
        $q = "INSERT INTO reviews(username, post_id, review, date) 
        VALUES ('$username', '$pid', '$review', NOW())";
        $res = mysqli_query($conn, $q);
        if ($res) {
            echo "<script>alert('Review Submitted Successfully');</script>";
        } else {
            echo "<script>alert('Error: " . mysqli_error($conn) . "');</script>";
        }
    }

    ?>

    <div class="search-box" id="search-box">
        <input type="text" id="search_text" placeholder="Search...">
    </div>
    <script src="user/scripts/home.js"></script>
    <script src="user/scripts/posts.js"></script>
    <script>
        function openReviewModal(postId) {
            document.getElementById("postid").value = postId;
            document.getElementById("reviewModal").style.display = "block";
        }

        function closeReviewModal() {
            document.getElementById("reviewModal").style.display = "none";
        }

        function openRateModal(postId, rating) {
            document.querySelectorAll('.rating-star').forEach(star => {
                star.classList.remove('selected');
            });

            document.getElementById("rateModal").style.display = "block";
            document.getElementById("rate-post-id").value = postId;
            setRating(rating);
        }

        function closeRateModal() {
            document.getElementById("rateModal").style.display = "none";
        }

        const stars = document.querySelectorAll('.rating-star');
        function setRating(rating) {
            stars.forEach((s, i) => {
                if (i < rating) {
                    s.classList.add('selected');
                } else {
                    s.classList.remove('selected');
                }
            });
            document.getElementById('rating').value = rating;
        }

        stars.forEach((star, index) => {
            star.addEventListener('click', () => {
                setRating(index + 1);
            });
        });

        document.querySelectorAll('.close-button').forEach(btn => {
            btn.onclick = function() {
                document.getElementById("reviewModal").style.display = "none";
                document.getElementById("rateModal").style.display = "none";
            };
        });
    </script>
</body>
</html>
