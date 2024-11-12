<!DOCTYPE html>
<html>
<head>
    <title>Add New Offer</title>
    <link rel="stylesheet" href="css/post.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <style>
        
    </style>
</head>
<html>
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
    $username = $_SESSION['username'];
    $sql = "SELECT `profile` FROM user WHERE `username` = '$username'";
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
    <h2 class="post-title">Add New Offer</h2>

    <form class="post-form" method="POST" action="" >
    <label for='category_id'></label>
    <select name='category_id' required>
        <?php
        $cat = "SELECT * FROM cats";
        $catres = mysqli_query($conn, $cat);
    while($row = mysqli_fetch_assoc($catres)){
        $id = $row['id'];
        $name = $row['name'];
        echo "<option value='$id'>$name</option>";
    }
    echo "</select>";
    echo "<br>";
    ?>
      <input type="text" name="title" placeholder="Title" required>
      <textarea name="description" placeholder="Description" required></textarea>
      <input type="text" name="salary" placeholder="Salary" required>
      <button type="submit" name="submit">Post</button>
    </form>
    
   <?php


if (isset($_POST['submit'])) {
    $category_id = $_POST['category_id'];
    $title = $_POST['title'];
    $description = $_POST['description'];
    $salary = $_POST['salary'];

    $query = "INSERT INTO `offers`(`username`, `title`, `cat_id`, `description`, `salary`, `date`)
              VALUES ('$username' , '$title', '$category_id', '$description','$salary', NOW())";
    $res =  mysqli_query($conn, $query);
    if($res){

        echo"<script>alert('Uploaded Successfully');</script>";

    }else{
        echo 'Error: ' . mysqli_error($conn);    }
    
}
   ?>
</div>
</div>

</body>
</html>