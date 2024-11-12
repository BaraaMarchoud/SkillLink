<!DOCTYPE html>
<html>
<head>
    <title>Add Post</title>
    <link rel="stylesheet" href="css/post.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <style>
        
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
    include '../../connection/connection.php';
    session_start();
    $sql = "SELECT `profile` FROM user WHERE `username` = '{$_SESSION['username']}'";
    $res = mysqli_query($conn, $sql);
    if(mysqli_num_rows($res) == 0){
        header("location: logout.php");
    }
    else{
        $row = mysqli_fetch_assoc($res);
        $profileImage = $row['profile'];
        echo "<a href='profile.php'><img class='profile-image' src='images/profile_images/$profileImage' alt='Profile Image'></a>";
    }
    ?>
  </div>

  <div class="menu">
    <ul>
      <li><a href="../home.php">Home</a></li>
      <li><a href="findskiller.php">Find Skiller</a></li>
      <li><a href="clients.php">Requests</a></li>
      <li><a href="events.php">Events</a></li>
      <li><a href="offer.php">Offering</a></li>
    </ul>
  </div>

  <div class="rest">
   
    </div>
  </div>
<body>

<div class="post-page">

  <div class="post-box">
    <h2 class="post-title">Create a New Post</h2>

    <form class="post-form" method="POST" action="post.php" enctype="multipart/form-data">
      <input type="text" name="title" placeholder="Title" required>
      <textarea name="description" placeholder="Description" required></textarea>
      <input type="file" name="image" required>
      <button type="submit" name="submit">Post</button>
    </form>
    
   
</div>
</div>


<?php

if (isset($_POST['submit'])) {
  $username = $_SESSION['username'];
  $title = $_POST['title'];
  $description = $_POST['description'];

  $image_path = $_FILES['image']['name'];
  $tmp_name = $_FILES['image']['tmp_name'];
  $error =$_FILES['image']['error'];

 if($error === 0){
  $image_ex = pathinfo($image_path, PATHINFO_EXTENSION);
  $allowed_exs = array("jpg","png","jpeg");
  if(in_array($image_ex , $allowed_exs)){
    $query = "INSERT INTO `post` (`username`, `title`, `description`, `image`,`date`) VALUES ('$username', '$title', '$description', '$image_path',NOW())";
    $result = mysqli_query($conn, $query);
    if($result){
          move_uploaded_file($tmp_name, 'images/posts_images/' .$image_path);

          echo"<script>alert('Uploaded Successfully');</script>";

      }else{
          echo"<script>alert('You have already uploaded this file');</script>";
      }
  }else{
      echo"<script>alert('File must be image, word, txt, or pptx doucument');</script>";
  }

 }
}
?>
<script src="postscript.js"></script>
</body>
</html>