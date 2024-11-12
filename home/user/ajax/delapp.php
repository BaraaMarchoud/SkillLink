<?php
include "../../../connection/connection.php";

if (isset($_GET['id'])) {
    $iddd = $_GET['id'];
    $q = "DELETE FROM `apply` WHERE `id` = '$iddd'";
    $res = mysqli_query($conn, $q);

    if ($res) {
        echo "<script>";
        echo "setTimeout(function() {";
        echo "    alert('Removed Successfully!');";
        echo "    window.location.href = '../profile.php';";
        echo "}, 0);";;
        echo "</script>";
    } else {
      echo "<script>alert('Error');</script>";
    }
}

?>