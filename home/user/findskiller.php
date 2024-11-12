<!DOCTYPE html>
<html>
<head>
  <title>Skillers</title>
  <link rel="stylesheet" href="css/find_skiller.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <style>

  .menu{
    margin-left: 23px;
  }
    
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
        <li><a href="offer.php">Offering</a></li>
        <li><a href="events.php">Events</a></li>
        
      </ul>
    </div>

    <div class="rest">
      <div class="search-icon" id="search-icon">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24">
          <circle cx="11" cy="11" r="8"></circle>
          <path d="M21 21l-4.35-4.35"></path>
        </svg>
      </div>
    </div>
  </div>

  <div id="result"></div>

  <div class="skiller-section">
    <div class="skiller-background">Browse Skilled User</div>
    <h2 class="skiller-title">Browse Skilled User</h2>
  </div>
  <div id="result">
    
  </div>

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
      
      <input type="hidden" id="receivedusername" name="receivedusername">
    </form>
  </div>
</div>
<div class="search-box" id="search-box">
              <input type="text" id="search_text" class="search_text" onkeyup="Search(this.value)" placeholder="Search...">
          </div>

<div class="skiller" id="or">
  <?php
$q = "SELECT DISTINCT u.username, u.profile, u.gender, u.cat
FROM skilleduser s
INNER JOIN user u ON s.username = u.username
WHERE u.username != '$username'";
  $rr = mysqli_query($conn, $q);

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

  if (isset($_POST['submitreq'])) {
    $name = $_SESSION['username'];
    $recname = $_POST['receivedusername'];
    $title = $_POST['title'];
    $desc = $_POST['message'];
    $num = "+961". $_POST['num']."";
    $q = "INSERT INTO `request`(`sentusername`, `receivedusername`, `title`, `description`, `num`, `date`, `Status`) 
          VALUES ('$name','$recname','$title','$desc','$num',NOW(),'pending')";
    $res = mysqli_query($conn, $q);
    if ($res) {
      echo "<script>alert('Request Sent Successfully');</script>";
    } else {
      echo "Error: " . mysqli_error($conn);
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
<script src="scripts/findskiller.js"></script>
 
</script>
</body>
</html>