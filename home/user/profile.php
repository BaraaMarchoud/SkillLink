<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link rel="stylesheet" href="css/profile.css">
  <link rel="stylesheet" href="css/clients.css">
  <link rel="stylesheet" href="css/events.css">
  <link rel="stylesheet" href="css/home.css">
  <link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css'>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>


</head>

<body>
  <style>
    .skills {
      width: auto;
    }

    .skills-container {
      display: grid;
      grid-template-columns: repeat(3, 1fr);
      gap: 20px;
    }

    .skill-card {
      background-color: #f2f2f2;
      padding: 20px;
      border-radius: 10px;
      box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .skill-card a {
      text-decoration: none;
      color: #333;
    }

    .posts {
      overflow-x: scroll;
    }

    #rate {
      background-color: #007bff;
    }


    .b {
      width: 290px;
      border: 2px solid #FFA800;
      border-radius: 10px;
      font-size: 400px;
    }
  </style>
  <?php
    include '../../connection/connection.php';
    session_start();
    $name = $_SESSION['username'];
    $p = true;
    if(isset($_GET['username'])){
        $username = $_GET['username'];
        $p = false;
    }else{
    $username = $name;
    }
    
    $sql = "SELECT `profile` FROM user WHERE `username` = '$name'";
    $res = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($res);
    if(mysqli_num_rows($res) == 0){
        header("location: logout.php");
    }
    
 ?>
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
   if(!$p){
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
        <li><a href="offer.php">Offering</a></li>
        <li><a href="events.php">Events</a></li>
        
      </ul>
    </div>

    <div class="rest">
    </div>
  </div>
  <div class="container">
    <div class="main-body">
      <div class="row gutters-sm">
        <div class="col-md-4 mb-3">
          <div class="card">
            <div class="card-body">
              <div class="d-flex flex-column align-items-center text-center">
                <?php ?>
                <form action="" method="POST" enctype="multipart/form-data">
                  <?php 
                    $sql = "SELECT * FROM user WHERE `username` = '$username'";
                    $res = mysqli_query($conn, $sql);
                   while( $row = mysqli_fetch_assoc($res)){
                    $profileImage = $row['profile'];
                    $username = $row['username'];
                    $cat_id = $row['cat'];
                    $num = $row['num'];
                    $location = $row['location'];
                    $fullname = $row['fname'] . " ".$row['lname'];
                    $email = $row['email'];
                    $dob = $row['dob'];
                    $r = "SELECT `name` FROM cats WHERE `id` = '$cat_id'";
                    $s = mysqli_query($conn, $r);

                        while ($catRow = mysqli_fetch_assoc($s)) {
                        $cat = $catRow['name'];
                       ?>
                  <div class="image-container">
                    <?php if($p){?>
                    <a href="profile.php">
                      <?php
                        }?>
                      <img class="profile-image" src="images/profile_images/<?php echo $profileImage; ?>"
                        alt="Profile Image" class="rounded-circle" width="150">
                    </a>
                    <?php if($p){?>
                    <label for="image-input" class="image-icon">
                      <i class="fa fa-camera"></i>
                      <input type="file" id="image-input" name="image" style="display: none;">
                    </label>
                  </div>
                  <button class="add-posts-button" name="submitt">Save</button>

                  <?php
                        }else{
                          echo"</div>";
                        }
                        echo'<div class="mt-3">';
                        echo"  <h4>$username</h4>";
                        echo"  <h4>$cat</h4>";
                        }
                        }
                    ?>
              </div>
            </div>
            </form>
            <?php
                        if (isset($_POST['submitt'])) {
                            $image_path = $_FILES['image']['name'];
                            $tmp_name = $_FILES['image']['tmp_name'];
                            $error =$_FILES['image']['error'];
                          
                           if($error === 0){
                            $image_ex = pathinfo($image_path, PATHINFO_EXTENSION);
                            $allowed_exs = array("jpg","png","jpeg");
                            if(in_array($image_ex , $allowed_exs)){
                                $s = "UPDATE `user` SET `profile` = '$image_path' WHERE `username` = '$username'";
                                $result = mysqli_query($conn, $s);
                                if ($result) {
                                  move_uploaded_file($tmp_name, 'images/profile_images/' .$image_path);
                                    echo "<script>";
                                            echo "setTimeout(function() {";
                                            echo "    window.location.href = 'profile.php';";
                                            echo "}, 0);";;
                                            echo "</script>";
                                }
                            }else{
                                echo"<script>alert('File must be image, word, txt, or pptx doucument');</script>";
                            }
                          
                           }
                          }
                    ?>
          </div>
        </div>
        <div class="card mt-3">
          <ul class="list-group list-group-flush">

          <?php 
          if($p){
            ?>
            <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
              <button id="skillButton" class="b">
                <h5>Skill</h5>
              </button>
            </li>

            <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
              <button id="postButton" class="b">
                <h5>Posts</h5>
              </button>
            </li>


            <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
              <button id="requestButton" class="b">
                <h5>Request</h5>
              </button>
            </li>

            <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
              <button id="clientButton" class="b">
                <h5>Clients</h5>
              </button>
            </li>



            <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
              <button id="eventsButton" class="b">
                <h5>Events</h5>
              </button>
            </li>

            <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
              <button id="offerButton" class="b">
                <h5>Offers</h5>
              </button>
            </li>
            <?php
          }else{
            ?>
            <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
              <button id="skillButton" class="b">
                <h5>Skill</h5>
              </button>
            </li>

            <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
              <button id="postButton" class="b">
                <h5>Posts</h5>
              </button>
            </li>

            <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
              <button id="eventsButton" class="b">
                <h5>Events</h5>
              </button>
            </li>

           

            <li class="l" hidden>
              <button id="requestButton" class="b">
                <h5>Request</h5>
              </button>
            </li>
            <li class="l" hidden>
              <button id="clientButton"  class="b">
                <h5>Clients</h5>
              </button>
            </li>

            <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
              <button id="offerButton" class="b">
                <h5>Offers</h5>
              </button>
            </li>

            <?php
          }
          ?>

            

          </ul>
        </div>
      </div>

      <?php

if (isset($_POST['submitrev'])) {
  $review = $_POST['review'];
  $q = "INSERT INTO skilllink_reviews(username, review, date) 
  VALUES ('$username', '$review', NOW())";
  $res = mysqli_query($conn, $q);
  if ($res) {
      echo "<script>alert('Review Submitted Successfully');</script>";
  } else {
      echo "<script>alert('Error: " . mysqli_error($conn) . "');</script>";
  }
}

      ?>

      <div id="reviewModall" class="modal">
        <div class="modal-content">
            <span class="close-button" onclick="closeReviewModall()">×</span>
            <form action="" method="POST">
                <h3>Write Your Review</h3>
                <textarea id="review" name="review" placeholder="Type your review here..."></textarea>
                <button type="submit" name="submitrev" class="submitrev">Submit Review</button>
                <input type="hidden" id="postid" name="post_id">
            </form>
        </div>
    </div>

      <?php
      if($p){
        echo '<button class="button" id="log" onclick="openReviewModall()">Review</button>';
      }else{
        echo "<button class='button' id='log' onclick='openReqModal()'>Request</button>";
      }

      if (isset($_POST['submitreq'])) {
        $name = $_SESSION['username'];
        $title = $_POST['title'];
        $desc = $_POST['message'];
        $num = "+961". $_POST['num']."";
        $q = "INSERT INTO `request`(`sentusername`, `receivedusername`, `title`, `description`, `num`, `date`, `Status`) 
              VALUES ('$name','$username','$title','$desc','$num',NOW(),'pending')";
        $res = mysqli_query($conn, $q);
        if ($res) {
          echo "<script>alert('Request Sent Successfully');</script>";
        } else {
          echo "Error: " . mysqli_error($conn);
        }
      }
          ?>

<div id="requestModal" class="modal">
  <div class="modal-content">
    <span class="close-button">×</span>
    <h2>Send Request</h2>
    <form action="" method="POST">
      <table>
        <tr>
          <td>
            <label for="title">Title:</label>
          </td>
          <td>
            <input type="text" name="title" required>
          </td>
        </tr>
        <tr>
          <td>
            <label for="desc">Description:</label>
          </td>
          <td>
            <textarea id="message" name="message" placeholder="Type your message here..." required></textarea>
          </td>
        </tr>
        <tr>
          <td>
            <label for="num">Phone Number:</label>
          </td>
          <td>
            <input type="number" id="num" name="num" placeholder="76152249" required></input>
          </td>
        </tr>
      </table>
      <button type="submit" name="submitreq">Send</button>
      
    </form>
  </div>
</div>
          <script>
               function openReviewModall() {
            document.getElementById("reviewModall").style.display = "block";
        }

        function closeReviewModal() {
            document.getElementById("reviewModall").style.display = "none";
        }
  function openReqModal() {
        document.getElementById("requestModal").style.display = "block";
    }
</script>


      <style>
        #log {
          position: fixed;
          bottom: 20px;
          right: 20px;
        }
        .button {
          display: inline-block;
          padding: 10px 20px;
          background: black;
          color: #fff;
          text-decoration: none;
          border-radius: 10px;
          transition: background-color 0.3s ease-in-out;
      }
      #reviewContent{
        color: black;
      }
      .modal {
        overflow: scroll;
      }

      .modal-content {
        overflow: scroll;
        width: 750px;
        margin-left: 320px;
        border: 2px solid #0166FF;
        border-radius: 14px;
      }
      </style>


      <div class="col-md-8">
        <form action="" method='POST'>
          <div class="card mb-3">
            <div class="card-body">
              <div class="row">
                <div class="col-sm-3">
                  <h6 class="mb-0">Full Name</h6>
                </div>
                <div class="col-sm-9 text-secondary">
                  <?php  echo" $fullname" ?>
                </div>
              </div>
              <hr>
              <div class="row">
                <div class="col-sm-3">
                  <h6 class="mb-0">Email</h6>
                </div>
                <div class="col-sm-9 text-secondary">
                  <?php echo"$email" ?>
                </div>
              </div>
              <hr>
              <div class="row">
                <div class="col-sm-3">
                  <h6 class="mb-0">Phone</h6>
                </div>
                <div class="col-sm-9 text-secondary">
                  <?php if($p){echo"<input value = '$num' type='text' name = 'num' style='border:none'></input>"; }
                      else{
                        echo"<h6>$num </h6>"; 
                        }?></div>
              </div>
              <hr>
              <div class="row">
                <div class="col-sm-3">
                  <h6 class="mb-0">Date of Birth</h6>
                </div>
                <div class="col-sm-9 text-secondary">
                  <?php if($p){echo"<input value = '$dob' type='text' name = 'dob' style='border:none'></input>"; }
                      else{
                        echo"<h6>$dob </h6>"; 
                        }?></div>
              </div>
              <hr>
              <div class="row">
                <div class="col-sm-3">
                  <h6 class="mb-0">Location</h6>
                </div>
                <div class="col-sm-9 text-secondary">
                  <?php if($p){echo"<input value = '$location' type='text' name = 'location' style='border:none'></input>"; }
                      else{
                        echo"<h6>$location </h6>"; 
                        }?>
                </div>
              </div>
              <hr>
              <div class="row">
                <div class="col-sm-12">
                  <?php if($p){?>
                  <button class="add-posts-button" name='submit'>Save </button>
                  <?php }?>
                </div>
              </div>
            </div>
        </form>
        <?php
                if(isset($_POST['submit'])){
                    $num = $_POST['num'];
                    $dob = $_POST['dob'];
                    $location = $_POST['location'];

                    $s = "UPDATE `user` SET `dob`='$dob',`num`='$num',`location`='$location' WHERE `username` = '$username'";
                    $res = mysqli_query($conn,$s);
                    if ($res) {
                        echo "<script>";
                                echo "setTimeout(function() {";
                                echo "    window.location.href = 'profile.php';";
                                echo "}, 0);";;
                                echo "</script>";
                    }
                }
                ?>
      </div>

      <div class="skills">
        <div class="card h-100" id="skillsContent">
          <?php if($p){  ?>
          <h4 style="margin-left:10px">Add Skills </h4>
          <ul>
            <?php
                          $sql = "SELECT s.*
                          FROM skill s
                          LEFT JOIN skilleduser su ON s.skill_id = su.skill_idd AND su.username = '$username'
                          WHERE su.username IS NULL";                          
                          $result = mysqli_query($conn, $sql);
                          ?><div class="skills-container"><?php
                          while ($row = mysqli_fetch_assoc($result)) {?>
              <div class="skill-card">
                <?php
                            $skillId = $row['skill_id'];
                            $skillName = $row['skill_name'];?>
                <a href="add_skill.php?skill_id=<?php echo $skillId; ?>"><?php echo $skillName; ?></a>
              </div>
              <?php
                   }
                      ?>
          </ul>
          <div class="other">
            <form action="" method="POST">
              <table>
                <tr>
                  <td>
                    <h4>Other:</h4>
                  </td>
                  <td>
                    <input name="skill_name" style="border:none">
                  </td>
                </tr>
                <tr>
                  <td colspan="2">
                    <button class="add-posts-button" name="submittt">Save</button>
                  </td>
                </tr>
              </table>
            </form>
            <?php
                    if (isset($_POST['submittt'])) {
                      $skill_name = $_POST['skill_name'];

                      $query = "INSERT INTO skill (skill_name,cat_id) VALUES ('$skill_name','other')";
                      $result = mysqli_query($conn, $query);

                      if (!$result) {
                        echo "<script>alert('This Skill already exists')</script>";
                      }
                    }


                  }else{
                    ?>

            <section class="events" id="event">
              <div class="event-section">
              </div>
              <div class="event-container">
                <?php
                    
                    $r = "SELECT * FROM events where `status` != 'finished' and `eventCreator` = '$username'";
                    $s = mysqli_query($conn, $r);
                    
                    while ($row = mysqli_fetch_assoc($s)) {
                        $id = $row['id'];
                        $title = $row['eventName'];
                        $desc = $row['description'];
                        $date = $row['date'];
                        $location = $row['location'];
                        $seats = $row['seats'];
                        $type = $row['type'];
                        $status = $row['status'];
                    
                        echo "<div class='rectangle-active'>";
                        echo "<h3 class='event-name'>$title</h3>";
                        echo "<p class='event-descriptionn'>$desc</p>";
                        echo "<p class='event-location'>$location</p>";
                        echo "<p class='event-date'>$date</p>";
                        echo "<div class='creator-profile'>";
                        echo "<p class='creator-name'>$username</p>";
                    
                        $checkQuery = "SELECT * FROM event_reserved WHERE event_id = '$id' AND `username` = '$name'";
                        $checkResult = mysqli_query($conn, $checkQuery);
                    
                        if (mysqli_num_rows($checkResult) > 0) {
                            echo "<form action='' method='POST'>";
                            echo "<p><i>You have already reserved this event.</i></p>";
                            echo "<input type='hidden' name='event-id' value='$id'>";
                            echo "<input type='hidden' name='event_name' value='$title'>";
                            echo "<input type='hidden' name='username' value='$name'>";
                            echo "<button class='remove-event' name='remove-event'>Remove</button>";
                            echo "</form>";
                        } else {
                            echo "<form action='' method='POST'>";
                            echo "<input type='hidden' name='event-id' value='$id'>";
                            echo "<input type='hidden' name='event_name' value='$title'>";
                            echo "<button class='reserve-event' name='reserve-event'>Reserve</button>";
                            echo "</form>";
                        }
                    
                        echo "</div>";
                        echo "</div>";
                    }
                    
                    if (isset($_POST['reserve-event'])) {
                        $ev_name = $_POST['event_name'];
                        $id = $_POST['event-id'];
                    
                        $checkQuery = "SELECT * FROM event_reserved WHERE event_id = '$id' AND username = '$name'";
                        $checkResult = mysqli_query($conn, $checkQuery);
                    
                        if (mysqli_num_rows($checkResult) > 0) {
                            echo "<script>alert('You have already reserved this event.');</script>";
                        } else {
                            $insertQuery = "INSERT INTO `event_reserved`(`event_id`, `username`, `date`) VALUES ('$id', '$name', NOW())";
                            $insertResult = mysqli_query($conn, $insertQuery);
                    
                            if ($insertResult) {
                                echo "<script>";
                                echo "setTimeout(function() {";
                                echo "    alert('Reserved Successfully!');";
                                echo "    window.location.href = 'profile.php?username=" . $username . "';";
                                echo "}, 0);";
                                echo "</script>";
                            }else{
                              echo"<script>alert('Error')</script>";
                            }
                            }
                        }
                    }
                    if (isset($_POST['remove-event'])) {
                        $id = $_POST['event-id'];
                        $ev_name = $_POST['event_name'];
                    
                    
                        $deleteQuery = "DELETE FROM `event_reserved` WHERE `event_id` = '$id' and `event_id` = '$id' and `username` = '$name'";
                        $deleteResult = mysqli_query($conn, $deleteQuery);
                    
                        if ($deleteResult) {
                            echo "<script>";
                            echo "setTimeout(function() {";
                            echo "    alert('Removed Successfully!');";
                            echo "    window.location.href = 'profile.php?username=" . $username . "';";
                            echo "}, 0);";
                            echo "</script>";
                        }
                      }
                    
                    
                    ?>

                <script>
                  function Remove() {
                    return confirm('Are you sure you want to remove your reservation for this event?');
                  }
                </script>
              </div>

            </section>

            <script>
              function Reserve() {
                return confirm("Are you sure you want to reserve this event?");
              }
            </script>

          </div>

        </div>
      </div>
    </div>
  </div>
  </div>

  </div>

  </div>

  </div>
  </div>

  <div id="eventContent" style="display: none;">
    <div class="event-container">
      <?php 
                     $r = "SELECT * FROM events where `eventCreator` = '$username'";
                     $s = mysqli_query($conn, $r);
                     
                     if($num = mysqli_num_rows($s)){
                     
                     while ($row = mysqli_fetch_assoc($s)) {
                         $id = $row['id'];
                         $title = $row['eventName'];
                         $desc = $row['description'];
                         $date = $row['date'];
                         $location = $row['location'];
                         $seats = $row['seats'];
                         $type = $row['type'];
                         $status = $row['status'];
                     
                         echo "<div class='rectangle-active'>";
                         echo "<h3 class='event-name'>$title</h3>";
                         echo "<p class='event-descriptionn'>$desc</p>";
                         echo "<p class='event-location'>$location</p>";
                         echo "<p class='event-date'>$date</p>";
                         echo "<div class='creator-profile'>";
                         echo "<p class='creator-name'>$username</p>";
                         if(!$p){
                         $checkQuery = "SELECT * FROM `event_reserved` WHERE `event_id` = '$id' AND `username` = '$name'";
                        $checkResult = mysqli_query($conn, $checkQuery);
                    
                        if (mysqli_num_rows($checkResult) != 0) {
                            echo "<form action='' method='POST'>";
                            echo "<p><i>You have already reserved this event.</i></p>";
                            echo "<input type='hidden' name='event-id' value='$id'>";
                            echo "<input type='hidden' name='event_name' value='$title'>";
                            echo "<input type='hidden' name='username' value='$name'>";
                            echo "<button class='remove-event' name='remove'>Remove</button>";
                            echo "</form>";
                        } else {
                            echo "<form action='' method='POST'>";
                            echo "<input type='hidden' name='event-id' value='$id'>";
                            echo "<input type='hidden' name='event_name' value='$title'>";
                            echo "<button class='reserve-event' name='reserve'>Reserve</button>";
                            echo "</form>";
                        }
                    
                        echo "</div>";
                        echo "</div>";
                      }else{
                        echo "<input type='hidden' name='event-id' value='$id'>";
                        echo "<input type='hidden' name='event_name' value='$title'>";
                        echo '<button class="reserve-event" id="review" onclick="openReserveModal(' . $id . ')">Who Reserve</button>';

                        }
                    }
                    
                    if (isset($_POST['reserve'])) {
                        $ev_name = $_POST['event_name'];
                        $id = $_POST['event-id'];
                    
                        $checkQuery = "SELECT * FROM event_reserved WHERE event_id = '$id' AND username = '$username'";
                        $checkResult = mysqli_query($conn, $checkQuery);
                    
                        if (mysqli_num_rows($checkResult) > 0) {
                            echo "<script>alert('You have already reserved this event.');</script>";
                        } else {
                            $insertQuery = "INSERT INTO `event_reserved`(`event_id`, `event_name`, `username`, `date`) VALUES ('$id','$ev_name', '$name', NOW())";
                            $insertResult = mysqli_query($conn, $insertQuery);
                    
                            if ($insertResult) {
                                echo "<script>";
                                echo "setTimeout(function() {";
                                echo "    alert('Reserved Successfully!');";
                                echo "    window.location.href = 'profile.php?username=" . $username . "';";
                                echo "}, 0);";
                                echo "</script>";
                            }else{
                              echo"<script>alert('Error')</script>";
                            }
                            }
                        }
                    
                    if (isset($_POST['remove'])) {
                        $id = $_POST['event-id'];
                        $ev_name = $_POST['event_name'];
                    
                    
                        $deleteQuery = "DELETE FROM `event_reserved` WHERE `event_id` = '$id' and `event_id` = '$id' and `username` = '$name'";
                        $deleteResult = mysqli_query($conn, $deleteQuery);
                    
                        if ($deleteResult) {
                            echo "<script>";
                            echo "setTimeout(function() {";
                            echo "    alert('Removed Successfully!');";
                            echo "    window.location.href = 'profile.php?username=" . $username . "';";
                            echo "}, 0);";
                            echo "</script>";
                        }
                      }
                    }else{
                      echo"<h4>No events</h4>";
                    }


                    ?>
                    <div id="reviewModal" class="modal">
                    <div class="modal-content">
                      <span class="close-button" onclick="closeReviewModal()">×</span>
                      <div id="reviewContent"></div>
                    </div>
                  </div>


                  <style>
                    #reviewContent{
                      color: black;
                    }
                    .modal {
                      overflow: scroll;
                    }

                    .modal-content {
                      overflow: scroll;
                      width: 750px;
                      margin-left: 320px;
                      border: 2px solid #0166FF;
                      border-radius: 14px;
                    }
                  </style>
                  <script>
                    function openReserveModal(eventId) {
                      fetch(`ajax/resev.php?evid=${eventId}`)
                        .then(response => response.text())
                        .then(data => {
                          document.getElementById("reviewContent").innerHTML = data;
                          document.getElementById("reviewModal").style.display = "block";
                        })
                        .catch(error => console.log(error));
                    }

                    function closeReviewModal() {
                      document.getElementById("reviewContent").innerHTML = "";
                      document.getElementById("reviewModal").style.display = "none";
                    }
                    </script>

    </div>
  </div>

  <div id="clientsContent" style="display: none;">
    <?php
                      $query = "SELECT * FROM request WHERE `receivedusername` = '$username' AND `status` = 'accepted'";
                      $skillResult = mysqli_query($conn, $query);

                      if (mysqli_num_rows($skillResult) > 0) {
                          echo "<div class='container'>";
                          echo "<h2>Your Clients</h2>";
                          while ($row = mysqli_fetch_assoc($skillResult)) {
                            $namee = $row['sentusername'];
                            $desc = $row['description'];
                            $num = $row['num'];
                            $date = $row['date'];
                              echo "<div class='request'>";
                              echo "<center><p> You accepted $namee request </center></p>";
                              echo "<p> $desc</p>";
                              echo "<p> $date</p>";
                              $whatsappLink = "https://wa.me/$num";  
                              echo "<form action='' method='POST'>";
                              echo "<button name='contact' value='" . $whatsappLink . "'>Contact</button>";
                              echo "</form>";
                              echo "</div>";

                              if(isset($_POST['contact'])){
                                echo "<script>";
                                          echo "setTimeout(function() {";
                                          echo "    window.location.href = '$whatsappLink';";
                                          echo "}, 0);";;
                                          echo "</script>";
                              }
                              
                          }
                          echo "</div>";
                      } else {
                          echo "<h5>No Accepted requests.</h5>";
                      }
                      ?>
  </div>

  <div id="requestContent" style="display: none;">
    <?php

                      $query = "SELECT * FROM request WHERE `sentusername` = '$username' AND `status` = 'pending'";
                      $skillResult = mysqli_query($conn, $query);

                      

                      if (mysqli_num_rows($skillResult) > 0) {
                        echo "<h2 style='margin-left:10px'>Your Requests</h2>";
                          echo "<div class='container'>";
                          
                          while ($row = mysqli_fetch_assoc($skillResult)) {
                            $nameee = $row['receivedusername'];
                            $desc = $row['description'];
                            $date = $row['date'];
                            $id = $row['id'];
                              echo "<div class='request'>";
                              echo "<center><p> You Requested $nameee </center></p>";
                              echo "<p> $desc</p>";
                              echo "<p> $date</p>";
                              ?>
    <a onclick="removereq('<?php echo $id;?>')"><button>Remove</button></a>
    <?php
                              echo "</div>";

                              
                              
                          }
                          echo "</div>";
                      } else {
                          echo "<h5>You dont have any Client.</h5>";
                      }
                      ?>
  </div>

  <div id="postContent" style="display: none;">
    <div class="posts">
      <?php
                  $q = "SELECT * FROM `post` WHERE `username` = '$username' ORDER BY `date` DESC";
                  $r = mysqli_query($conn, $q);
                  while ($row = mysqli_fetch_assoc($r)) {
                      $nam = $row['username'];
                      $image = $row['image'];
                      $title = $row['title'];
                      $desc = $row['description'];
                      $date = $row['date'];
                      $id = $row['id'];
                      echo '<div class="post-card">';
                      echo '<div class="image-container">';
                      echo '<img src="images/posts_images/' . $image . '" alt="Post Image">';
                      echo '<div class="overlay">';
                      echo '<button class="btn review" id="review" onclick="openReviewModal(' . $id . ')">Review</button>';
                      echo '<button class="btn rate" id="rate" onclick="openRateModal(' . $id . ')">Rate</button>';
                      echo '</div>';
                      echo '</div>';
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
        <span><?php echo $nam; ?></span>
        <span style="float: right;">

          <i class="fa fa-star" style="color: #FFD700;"></i>
          <?php echo $avg; ?>
        </span>
      </p>
      <?php
                      echo "<h3>$title</h3>";
                      echo "<p>$desc</p>";
                      echo "<p>$date</p>";
                      echo '</div>';
                  }
                  ?>
    </div>

    <div id="reviewModal" class="modal">
      <div class="modal-content">
        <span class="close-button" onclick="closeReviewModal()">×</span>
        <div id="reviewContent"></div>
      </div>
    </div>

    <div id="rateModal" class="modal">
      <div class="modal-content">
        <span class="close-button" onclick="closeRateModal()">×</span>
        <div id="rateContent"></div>
      </div>
    </div>
  </div>

  <style>
    .modal {
      overflow: scroll;
    }

    .modal-content {
      overflow: scroll;
      width: 750px;
      margin-left: 320px;
      border: 2px solid #0166FF;
      border-radius: 14px;
    }
  </style>

  <script>
    function openReviewModal(postID) {
      fetch(`ajax/reviews.php?q=${postID}`)
        .then(response => response.text())
        .then(data => {
          document.getElementById("reviewContent").innerHTML = data;
          document.getElementById("reviewModal").style.display = "block";
        })
        .catch(error => console.log(error));
    }

    function closeReviewModal() {
      document.getElementById("reviewContent").innerHTML = "";
      document.getElementById("reviewModal").style.display = "none";
    }

    function openRateModal(postID) {
      fetch(`ajax/rate.php?q=${postID}`)
        .then(response => response.text())
        .then(data => {
          document.getElementById("rateContent").innerHTML = data;
          document.getElementById("rateModal").style.display = "block";
        })
        .catch(error => console.log(error));
    }

    function closeRateModal() {
      document.getElementById("rateContent").innerHTML = "";
      document.getElementById("rateModal").style.display = "none";
    }
    window.onclick = function(event) {
    var modal = document.getElementById("reviewModal");
    var rmodal = document.getElementById("rateModal");
    if (event.target === modal || event.target === rmodal) {
        modal.style.display = "none";
        rmodal.style.display = "none";
    }
};
  </script>

  <div id="skillContent" style="display: none;">
    <h4 style="margin-left:10px">Skills</h4>
    <ul>
      <?php
                      $sql = "SELECT s.*, su.* 
                      FROM skill s 
                      LEFT JOIN skilleduser su 
                      ON s.skill_id = su.skill_idd
                      WHERE su.username = '$username'";

                          $result = mysqli_query($conn, $sql);
                          ?><div class="skills-container"><?php
                          while ($row = mysqli_fetch_assoc($result)) {?>
        <div class="skill-card">
          <?php
                            $skillId = $row['skill_id'];
                            $skillName = $row['skill_name'];?>
                            <?php if($p){ ?>
          <a href="remove_skill.php?skill_id=<?php echo $skillId; ?>"><?php echo $skillName; ?></a>
          <?php } else{
            echo $skillName;
          }
          ?>
        </div>
        <?php
                   }
                      ?>
    </ul>
  </div>

  <div id="offerContent" style="display: none;">

    <?php
                        echo "<center><h2>Offers</h2></center>";
                    if ($p) {
                      $query = "SELECT * FROM offers WHERE username = '$name'";
                      $offerResult = mysqli_query($conn, $query);
                  
                      if (mysqli_num_rows($offerResult) > 0) {
                          echo "<div class='container'>";
                          
                          while ($row = mysqli_fetch_assoc($offerResult)) {
                              $id = $row['id'];
                              $na = $row['username'];
                              $tit = $row['title'];
                              $date = $row['date'];
                              $desc = $row['description'];
                              $cat_id = $row['cat_id'];

                              $qu = "SELECT `name` FROM `cats` WHERE `id` = '$cat_id'";
                              $qures = mysqli_query($conn,$qu);
                              $row = mysqli_fetch_assoc($qures);
                              $cat_name = $row['name'];
                              
                              echo "<div class='request'>";
                              echo "<center><p>$cat_name</p></center>";
                              echo "<center><p>$tit</p></center>";
                              echo "<p>$desc</p>";
                              echo "<p>$date</p>";
                              echo "<button name='wh' onclick='openApplyModal($id)'>Who Applies</button>";
                              echo "<span style='float: right;'>";
                              echo "<form action='' method='POST'>";
                              echo "<button name='del'>Delete</button>";
                              echo "<input type='hidden' name='id' value='$id'>";
                              echo "</form>";
                              echo "</span>";
                              echo "</div>";
                          }
                  
                          if (isset($_POST['del'])) {
                              $id = $_POST['id'];
                              $r = "DELETE FROM `offers` WHERE `id` = '$id'";
                              $s = mysqli_query($conn, $r);
                              echo "<script>";
                              echo "setTimeout(function() {";
                              echo "    window.location.href = 'profile.php';";
                              echo "    alert('Deleted Successfully!');";
                              echo "}, 0);";
                              echo "</script>";
                          }
                  
                          echo "</div>";
                      } else {
                          echo "<h5>You dont have any offer.</h5>";
                      }
                  } else {
                    $q = "SELECT * FROM `offers` 
                    WHERE `username` = '$username' 
                    AND `id` NOT IN (SELECT `offer_id` FROM `apply` WHERE `apply`.`username` = '$_SESSION[username]')";
                    $s = mysqli_query($conn, $q);
                  
                      echo "<center>";
                      while ($row = mysqli_fetch_assoc($s)) {
                          $id = $row['id'];
                          $n = $row['username'];
                          $tit = $row['title'];
                          $date = $row['date'];
                          $desc = $row['description'];
                          $sal = $row['salary'];
                          $cname = $row['cat_id'];

                          $qu = "SELECT `name` FROM `cats` WHERE `id` = '$cat_id'";
                          $qures = mysqli_query($conn,$qu);
                          $row = mysqli_fetch_assoc($qures);
                          $cat_name = $row['name'];
                          
                          $q = "SELECT * FROM user WHERE `username` = '$username'";
                          $p = mysqli_query($conn,$q);
                          $row = mysqli_fetch_assoc($p);
                          $num = $row['num'];
                          $whatsappLink = "https://wa.me/$num"; 

                          echo "<div class='request'>";
                          echo "<center><p>$cat_name</p></center>";

                          echo "<center><p>$tit</p></center>";
                          echo "<p>$desc</p>";
                          echo "<p>$date</p>";
                          echo "<p>$sal</p>";
                          echo"<span style='float: left;'>";
                          echo"<a href='ajax/eapp.php?cname=$cname&ofid=$id&user=$username'>";
                          echo "<button name='apply'>Easy Apply</button>";
                          echo"</span>";
                          echo"<span style='float: right;'>";
                          echo"<a href='$whatsappLink'>";
                          echo "<button class='rejected' name='contact'>Contact</button>";
                          echo"</a>";
                          echo"</span>";
                          echo"<br><br>";
                          
                          echo "</div>";
                      }
                      echo "</center>";
                  }
                  ?>
                  
                  <div id="applyModal" class="modal">
                      <div class="modal-content">
                          <span class="close-button" onclick="closeApplyModal()">×</span>
                          <div id="applyContent"></div>
                      </div>
                  </div>
                  
                  <style>
                      #reviewContent {
                          color: black;
                      }
                      .modal {
                          overflow: scroll;
                      }
                      .modal-content {
                          overflow: scroll;
                          width: 750px;
                          margin-left: 320px;
                          border: 2px solid #0166FF;
                          border-radius: 14px;
                      }
                  </style>
                  
                  <script>
                      function openApplyModal(ofId) {
                          fetch(`ajax/apply.php?ofid=${ofId}`)
                              .then(response => response.text())
                              .then(data => {
                                  document.getElementById("applyContent").innerHTML = data;
                                  document.getElementById("applyModal").style.display = "block";
                              })
                              .catch(error => console.log(error));
                      }
                  
                      function closeApplyModal() {
                          document.getElementById("applyContent").innerHTML = "";
                          document.getElementById("applyModal").style.display = "none";
                      }
                  </script>

  </div>

  <script src='scripts/profile.js'></script>
  <script src=scripts/posts.js> </script> <script
    src='https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/js/bootstrap.bundle.min.js'></script>

</body>

</html>