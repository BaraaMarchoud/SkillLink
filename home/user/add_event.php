<!DOCTYPE html>
<html>
<head>
    <title>Add Event</title>
    <link rel="stylesheet" href="css/add_event.css">
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
    $username = $_SESSION['username'];
    $ch = "SELECT * FROM `skilleduser` WHERE  `username` = '$username'";
    $chres = mysqli_query($conn,$ch);
    $num = mysqli_num_rows($chres);
    if($num === 0){
        echo "<script>";
                    echo "setTimeout(function() {";
                    echo "    alert('You must have at least 1 skill!');";
                    echo "    window.location.href = 'events.php';";
                    echo "}, 0);";;
                    echo "</script>";
    }else{
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
</div>
    <h2>Add Event</h2>

    <form action="" method="POST">
        <table>
            <tr>
                <th>Event Name:</th>
                <td><input type="text" name="event-name" required></td>
            </tr>
            <tr>
                <th>Description:</th>
                <td><textarea name="description" rows="5" required></textarea></td>
            </tr>
            <tr>
                <th>Location:</th>
                <td><input type="text" name="location" required></td>
            </tr>
            <tr>
                <th>Date:</th>
                <td><input type="date" name="date" required></td>
            </tr>
            <tr>
                <th>Seats:</th>
                <td><input type="number" name="seats" required></td>
            </tr>
            <tr>
                <th>Type:</th>
                <td>
                    <input type="radio" name="type" value="public" id="public" checked>
                    <label for="public">Public</label>
                    <input type="radio" name="type" value="private" id="private">
                    <label for="private">Private</label>
                </td>
            </tr>
            <tr>
                <td colspan="2"><input type="submit" name="submit" value="Add Event"></td>
            </tr>
        </table>
    </form>

    <?php
    include "../../connection/connection.php";
 

    if (isset($_POST['submit'])) {
        $eventName = $_POST['event-name'];
        $eventCreator = $_SESSION['username'];
        $description = $_POST['description'];
        $location = $_POST['location'];
        $date = $_POST['date'];
        $seats = $_POST['seats'];
        $type = $_POST['type'];
        $status = "upcoming";

        $insertQuery = "INSERT INTO events (eventName, eventCreator, description, date, location, seats, type, status)
                    VALUES ('$eventName', '$eventCreator', '$description', '$date', '$location', '$seats', '$type', '$status')";

        $insertResult = mysqli_query($conn, $insertQuery);

        if ($insertResult) {
            echo "<script>alert('Event added successfully.');</script>";
        } else {
            $error = mysqli_error($conn);
            echo "<script>alert('Failed to add event. Error: $error');</script>";
        }
    }
}
    ?>
</body>
</html>