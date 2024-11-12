<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
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
<body>


    <section>

        <nav>
           <center>
            <label for="SignUp">Reset Pass</label>
            </center>
        </nav>
       
        <form action="" id="SignUpFormData" Method = "POST">    
           <input type="hidden" name="username" value = "<?php echo $_GET['U'] ; ?>">
            <input type="password" name="password2" id="password2" placeholder="password" required oninput="checkPasswordMatch()">
            <input type="password" placeholder="Confirm Password" id="cpassword" name="cpassword" required oninput="checkPasswordMatch()">
            <span id="error-text" style="color: red; display: none;">Passwords do not match</span>
            <span id="password-requirements" style="color: red; display: none;">Password should be at least 8 character and must contain: <br>One Uppercase letter,<br> One Lowercase letter<br>One Special Character(!,$,*,^ ..etc).</span>

            <span>
            <input type="checkbox" name="" id="show-password2"  onclick="togglePasswordVisibility2()">
                <label for="staySignedUp"> show-password</label>
            </span>
            <button type="submit" name ="reg"title="Reset Password" id="signup">Reset Password</button>

        </form>
    </section>

    <script>
 
function checkPasswordMatch() {
  var passwordField = document.getElementById("password2");
  var cpasswordField = document.getElementById("cpassword");
  var button = document.getElementById("signup");
  var errorText = document.getElementById("error-text");
  var requirementsText = document.getElementById("password-requirements");
  var password = passwordField.value;
  var hasUpperCase = /[A-Z]/.test(password);
  var hasLowerCase = /[a-z]/.test(password);
  var hasSpecialChar = /[!@#$%^&*(),.?":{}|<>]/.test(password);
  var isLengthValid = password.length >= 8;
  if(cpasswordField.value === ""){

  }
  
  else if (!isLengthValid || !hasUpperCase || !hasLowerCase || !hasSpecialChar) {
    requirementsText.style.display = "block";
    button.disabled = true;
    button.style.cursor = "not-allowed";
    button.style.backgroundColor = "gray";
    
    passwordField.style.border = "1px solid red";
    errorText.style.display = "none";
   
  } else if (passwordField.value !== cpasswordField.value) {
    requirementsText.style.display = "none";
    button.disabled = true;
    button.style.cursor = "not-allowed";
    button.style.backgroundColor = "gray";
    
    passwordField.style.border = "1px solid red";
    errorText.style.display = "block";
    
  } else {
    requirementsText.style.display = "none";
    errorText.style.display = "none";
    button.disabled = false;
    button.style.cursor = "pointer";
    button.style.backgroundColor = "#FFA800";
  }
}
        function togglePasswordVisibility2() {
 var passwordField = document.getElementById("password2");
 var cpasswordField = document.getElementById("cpassword")
 var showPasswordCheckbox = document.getElementById("show-password2");

 if (showPasswordCheckbox.checked) {
   passwordField.type = "text";
   cpasswordField.type="text";
 } else {
    cpasswordField.type="password";
   passwordField.type = "password";
 }
}
 
 
</script>

<?php


?>
    <?php
    
    require("../connection/connection.php");
    
  
    if(isset($_POST["reg"])){
        $password = $_POST["password2"];
        $username = $_POST["username"];
        $password = password_hash($password,PASSWORD_DEFAULT);

        $up = "UPDATE user SET `password` = '$password' where `username` = '$username'";
        $upp = mysqli_query($conn,$up);


        echo "<script> window.location.href='../log/login.php'; </script>";       

    }

    
    
    ?>
</body>
</html>