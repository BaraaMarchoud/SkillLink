<?php
include "../../../connection/connection.php";
session_start();
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $username = $_SESSION['username'];

    $checkQuery = "SELECT * FROM event_reserved WHERE event_id = '$id' and  username = '$username'";
    $checkResult = mysqli_query($conn, $checkQuery);

    if (mysqli_num_rows($checkResult) > 0) {
        echo "<script>alert('You have already reserved this event.');</script>";
    } else {
        $insertQuery = "INSERT INTO `event_reserved`(`event_id`, `username`, `date`) VALUES ('$id', '$username', NOW())";
        $insertResult = mysqli_query($conn, $insertQuery);

        if ($insertResult) {
            echo "<script>";
                    echo "setTimeout(function() {";
                    echo "    window.location.href = '../events.php';";
                    echo "}, 0);";;
                    echo "</script>";
        }
    }
}


?>