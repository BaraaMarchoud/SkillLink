<?php
require("../../connection/connection.php");
    $id = $_POST['id'];
    $query = "DELETE FROM `request` WHERE `id` = '$id'";
    $result = mysqli_query($conn,$query);
?>