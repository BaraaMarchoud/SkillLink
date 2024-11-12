<div class="posts">
  <?php
  session_start();
  include "../../../connection/connection.php";
  if (isset($_POST['search_text'])) {
    $searchValue = $_POST['search_text'];
    $username = $_SESSION['username'];
    $q = "SELECT * FROM `post` WHERE lower(`title`) LIKE '%$searchValue%' and `username` != '$username' ORDER BY `date` desc";
    $r = mysqli_query($conn, $q);
    if ($r) {
      while ($row = mysqli_fetch_assoc($r)) {
        $name = $row['username'];
        $image = $row['image'];
        $title = $row['title'];
        $desc = $row['description'];
        $date = $row['date'];
        $id = $row['id'];
        echo '<div class="post-card">';
        echo '<div class="image-container">';
        echo '<img src="user/images/posts_images/' . $image . '" alt="Post Image">';
        echo '<div class="overlay">';
        echo '<button class="btn review">Review</button>';
        echo '<button class="btn rate">Rate</button>';
        echo '</div>';
        echo '</div>';
        echo "<p>$name</p>";
        echo "<h3>$title</h3>";
        echo "<p>$desc</p>";
        echo "<p>$date</p>";
        echo "<form method='POST' action=''>";
        echo "<input type='hidden' name='post_id' value='$id'>";
        echo '</div>';
        echo "</form>";
      }
    } else {
        echo"fuck you";
      echo mysqli_error($conn); // Display the error if the query fails
    }
  }
  ?>
</div>

<div id="reviewModal" class="modal">
  <div class="modal-content">
    <span class="close-button">×</span>
    <form action="" method="POST">
      <h3>Write Your Review</h3>
      <textarea id="review" name="review" placeholder="Type your review here..." required></textarea>
      <button type="submit" name="submitrev" class="submitrev">Submit Review</button>
      <input type="hidden" id="postid" name="post_id">
    </form>
  </div>
</div>

<?php
if (isset($_POST['submitrev'])) {
  $review = $_POST['review'];
  $pid = $_POST['post_id'];
  echo "<script>alert('$pid')</script>";
  $q = "INSERT INTO `reviews`(`username`, `post_id`, `review`, `date`) 
        VALUES ('$username','$pid','$review', NOW())";
  $res = mysqli_query($conn, $q);
}
?>

<script src="user/scripts/posts.js"></script>
