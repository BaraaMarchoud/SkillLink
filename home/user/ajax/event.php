<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../css/events.css">

</head>
<body>
    

<div class="event-container">

<?php
session_start();
include "../../../connection/connection.php";
if (isset($_GET['q'])) {
    $searchValue = $_GET['q'];
    $username = $_SESSION['username'];

$r = "SELECT * FROM events where `status` != 'finished' and `eventCreator` != '$username' and lower(`eventName`) LIKE '%$searchValue%' ";
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
    echo "<p class='event-location'>$location</p>";
    echo "<p class='event-date'>$date</p>";
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
}
?>

</div>
</body>
</html>