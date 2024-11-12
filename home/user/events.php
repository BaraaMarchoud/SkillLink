
<!DOCTYPE html>
<html>
<head>
  <title>Event Page</title>
  <link rel="stylesheet" href="css/events.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

  <style>

.menu{

margin-left: 23px;
}

    .event {
      position: relative;
      width: 100%;
      height: auto;
    }

    .background-image {
      position: relative;
      width: 100%;
    }

    .background-image img {
      width: 90%;
      height: 500px;
      border-radius: 10px;
      margin-left: 80px;
    }

    .event-description {
      position: absolute;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      text-align: center;
      color: #FFFFFF;
    }

    .create-event {
      font-family: 'Bayon';
      font-style: normal;
      font-weight: 400;
      font-size: 64px;
      line-height: 1.2;
      letter-spacing: 4px;
      margin-bottom: 16px;
    }

    .event-description p {
      font-family: 'Inter';
      font-style: normal;
      font-weight: 400;
      font-size: 24px;
      line-height: 1.5;
    }

    .get-started-button {
      display: block;
      margin: 16px auto;
      padding: 12px 24px;
      font-size: 16px;
      background-color: #0166FF;
      color: #000000;
      border: none;
      border-radius: 4px;
      cursor: pointer;
    }
    
    .event-container {
      display: flex;
      gap: 20px;
      overflow-x: scroll;
      padding: 20px;
    }
  
    
    .rectangle-active.focused {
  filter: none; 
  box-shadow: 0 0 10px rgba(0, 8, 0, 9.3); 
  background-color: red;
  height: 200px;
}

    .rectangle-active .reserve-event{
    background-color: #0166FF;
    color: white;
    border: none;
    padding: 10px 20px;
    border-radius: 9px;
    font-weight: bold;
    cursor: pointer;
    align-items: flex-end;
    }

    .rectangle-active .remove-event{
    background-color: #FFA800;
    color: white;
    border: none;
    padding: 10px 20px;
    border-radius: 9px;
    font-weight: bold;
    cursor: pointer;
    align-items: flex-end;
    }
    .rectangle-active p i {
        background-color:  #FFA800;
    }

    .logout-icon a {
    color: #ffffff; 
    font-size: 20px; 
    display: inline-block;
    vertical-align: middle;
    margin-top: 10px;
}

.logout-icon a:hover {
    color: #cccccc; 
    text-decoration: none; 
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
<div class="event">
  <div class="background-image">
    <img src="images/event_images/cover.jpeg" alt="">
  </div>
  <div class="event-description">
    <h1 class="create-event">Create Your Event</h1>
    <p>Share your knowledge and experience by hosting an event or workshop</p>
    <form action="add_event.php" method="POST">
    <button class="get-started-button">Create Event</button>
    </form>
  </div>
</div>
  
<section class="events" id="event">
  <div class="event-section">
    <div class="event-background">Upcoming Events</div>
    <h2 class="event-title">Upcoming Events</h2>
  </div>

  <div class="event-container">
    

  <?php
include "../../connection/connection.php";

$r = "SELECT * FROM events where `status` != 'finished' and `eventCreator` != '$username'";
$s = mysqli_query($conn, $r);

while ($row = mysqli_fetch_assoc($s)) {
    $id = $row['id'];
    $name = $row['eventCreator'];
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
    echo "<p class='event-location' style=color:red>$location</p>";
    echo "<p class='event-date' style=color:red>$date</p>";
    echo"<br><br><br><br><br>";

    echo "<div class='creator-profile'>";
    echo "<p class='creator-name'>$name</p>";

    $checkQuery = "SELECT * FROM event_reserved WHERE event_id = '$id' and `username` = '$username'";
    $checkResult = mysqli_query($conn, $checkQuery);

    if (mysqli_num_rows($checkResult) > 0) {
        echo "<form action='' method='POST'>";
        echo "<p><i>You have already reserved this event.</i></p>";
        echo "<input type='hidden' name='id' value='$id'>";
        echo "<input type='hidden' name='event-name' value='$title'>";
        echo "<input type='hidden' name='username' value='$username'>";
        echo "<button class='remove-event' name='remove-event' onClick='Remove()'>Remove</button>";
        echo "</form>";
    } else {
        ?>
      <a href="ajax/events.php?id=<?php echo $id; ?>">
      <?php
        echo "<button class='reserve-event' name='reserve-event' onClick='Reserve()'>Reserve</button>";
        echo"</a>";
    }

    echo "</div>";
    echo "</div>";
}

if (isset($_POST['reserve-event'])) {
    $id = $_POST['event-id'];
    $username = $_SESSION['username'];

    $checkQuery = "SELECT * FROM event_reserved WHERE event_id = '$id' AND username = '$username'";
    $checkResult = mysqli_query($conn, $checkQuery);

    if (mysqli_num_rows($checkResult) > 0) {
        echo "<script>alert('You have already reserved this event.');</script>";
    } else {
        $insertQuery = "INSERT INTO `event_reserved`(`event_id`, `username`, `date`) VALUES ('$id', '$username', NOW())";
        $insertResult = mysqli_query($conn, $insertQuery);

        if ($insertResult) {
            echo "<script>";
                    echo "setTimeout(function() {";
                    echo "    alert('Reserved Successfully!');";
                    echo "    window.location.href = 'events.php';";
                    echo "}, 0);";;
                    echo "</script>";
        }
    }
}
if (isset($_POST['remove-event'])) {
    $id = $_POST['id'];
    $name = $_POST['event-name'];

    $deleteQuery = "DELETE FROM `event_reserved` WHERE `event_id` = '$id' and `username` = '$username'";
    $deleteResult = mysqli_query($conn, $deleteQuery);

    if ($deleteResult) {
        echo "<script>";
        echo "setTimeout(function() {";
        echo "    alert('Removed Successfully!');";
        echo "    window.location.href = 'events.php';";
        echo "}, 0);";;
        echo "</script>";
    }
}
?>
 </div>
<div id="result"></div>
<div class="search-box" id="search-box">
    <input type="text" id="search_text" onkeyup="Search(this.value)" placeholder="Search...">
</div>
<script src="scripts/event.js"></script>
<script>
function Remove() {
    return confirm('Are you sure you want to remove your reservation for this event?');
}
</script>
     

</section>

<script>
  function Search(str) {
    if (str.length == 0) {
        location.reload();
        return;
    }else{
    fetch(`ajax/event.php?q=${str}`)
        .then(response => response.text())
        .then(data => {
            document.querySelector("#result").innerHTML = data;
            document.querySelector(".event").innerHTML = "";
            document.querySelector(".event-container").innerHTML = "";

        })
        .catch(error => console.log(error));
    }
}

        function Reserve() {
            return confirm("Are you sure you want to reserve this event?");
        }
</script>
</body>
</html>