<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
<style>
    body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        section {
            background-color: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 400px;
        }

        h1 {
            text-align: center;
            margin-bottom: 30px;
        }

        form {
            display: flex;
            flex-direction: column;
        }

        label {
            font-weight: bold;
            margin-bottom: 10px;
        }

        input {
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            margin-bottom: 20px;
        }

        button {
            background-color: #FFA800;
            color: black;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-weight: bold;
            text-transform: uppercase;
        }

        button:hover {
            background-color: #e59700;
        }

        a {
            display: block;
            text-align: center;
            color: #FFA800;
            text-decoration: none;
            margin-top: 20px;
        }

        a:hover {
            color: #e59700;
        }
        .b{
            position: fixed;
            width: 1440px;
            height: 38px;
            background: #FFA800;
            top:0
            }
</style>
</head>
<body>
<div class="b">
    </div>


    <section>
            
           
        </div>
        <nav>
            <label for="SignIn">Verify your email</label>
           
        </nav>
        <form action="" id="SignInFormData" Method="POST">
        <input type="hidden" name="username" id="username" value = "<?php echo $_GET['U'];?>">
            <input type="number" name="code" id="code" placeholder="code" required>
           
            <span id="wrong-code" style="color: red; display: none;">Wrong Code</span>

            <span>
               
            </span><button type="submit" title="Verify" name ="lg" id = "signin" >Verify</button></span>
        
        </form>
    </section>


    <?php
require("../connection/connection.php");
if(isset($_POST['lg'])){
session_start();
$username = $_POST['username'];
$code = $_POST['code'];

$getUserQuery = "SELECT * FROM email_ver WHERE `username` = '$username' AND `code` = '$code'";
$run = mysqli_query($conn, $getUserQuery);
$cond = false;

if(mysqli_num_rows($run) > 0){
    $d = "DELETE FROM email_ver WHERE `Username` = '$username'";
    $dd = mysqli_query($conn,$d);
    echo "<script> window.location.href='ResetPass.php?U=" . $username . "'; </script>";       
}else{
    ?>
    <script>
        var errorText = document.getElementById("wrong-code");
        errorText.style.display = "block";
    </script>
    <?php
}
}

?>


</body>
</html>