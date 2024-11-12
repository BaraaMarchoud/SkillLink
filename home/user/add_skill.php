<?php

include "../../connection/connection.php";
session_start();

if (isset($_GET['skill_id'])) {
  $skillId = $_GET['skill_id'];
  $username = $_SESSION['username'];
  $sql = "INSERT INTO skilleduser (skill_idd, username) VALUES ('$skillId', '$username')";

  if (mysqli_query($conn, $sql)) {
    header("location:profile.php");
  } else {
    echo 'Error: ' . mysqli_error($conn);
  }
} else {
  echo 'Invalid skill ID.';
}
?>