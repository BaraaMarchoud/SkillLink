<!DOCTYPE html>
<html>
<head>
  <title>Registration Form</title>
  <link rel="stylesheet" href="rstyle.css">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js" crossorigin="anonymous"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

  <style>
   
  </style>
</head>
<body>
<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
require "phpmailer/vendor/autoload.php";
?>

  <div class="container">
    <h2>Registration Form</h2>
    <form action="" method="POST">
      <div class="form-group">
        <label for="username">Username:</label>
        <input type="text" name="username" id="username" required>
      </div>
      <div class="form-group">
        <label for="lastName">Last Name:</label>
        <input type="text" name="lastName" id="lastName" required>
      </div>
      <div class="form-group">
        <label for="firstName">First Name:</label>
        <input type="text" name="firstName" id="firstName" required>
      </div>
      
      <div class="form-group">
        <label for="email">Email:</label>
        <input type="email" name="email" id="email" required>
      </div>
      <div class="form-group">
        <label>Gender:</label>
        <input type="radio" name = "gender" class="rad" value="male" required> Male<br>
        <input type="radio" name = "gender" class="rad" value="female" required> Female<br>
      </div>
      <div class="form-group">
        <label for="dob">Date of Birth:</label>
        <input type="date" name="dob" id="dob" required>
      </div>
      
      <div class="form-group">
    <label for="skill">Preferred Skill Category:</label>
    <select name="skill" id="skill">
        <option value="">Select a skill</option>
        <?php
        include "../connection/connection.php";
        $skillQuery = "SELECT * FROM cats ORDER BY FIELD(name, 'Other'), name";
        $skillResult = mysqli_query($conn, $skillQuery);
        while ($row = mysqli_fetch_assoc($skillResult)) {
            $skillId = $row['id'];
            $skillName = $row['name'];
            echo "<option value='$skillId'>$skillName</option>";
        }
        ?>
    </select>
</div>
<div id="other-input-container" style="display: none;">
    <label for="other-skill">Specify Other Skill:</label>
    <input type="text" name="oskill" id="other-skill" />
</div>

<script>
$(document).ready(function() {
    $('#skill').on('change', function() {
        console.log('Skill change event triggered');
        if ($(this).val() === 'Other') {
            console.log('Other option selected');
            $('#other-input-container').show();
            $('#toggle-icon').css("margin-top", "17px");
        } else {
            console.log('Other option not selected');
            $('#other-input-container').hide();
            $('#toggle-icon').css("margin-top", "");

        }
    });

    // Check if the 'Other' option is selected on page load
    if ($('#skill').val() === 'Other') {
        console.log('Other option selected on page load');
        $('#other-input-container').show();
    }
});
</script>
      
      <div class="form-group ">
        <label for="password">Password:</label>
        <input type="password" name="password" id="password" required oninput="checkPasswordMatch()">
        <span class="toggle-icon" id="toggle-icon" onclick="togglePassword()" >
          <i class="fas fa-eye"></i>
        </span>
      </div>
      <div class="form-group password-toggle">
        <label for="confirmPassword">Confirm Password:</label>
        <input type="password" name="confirmPassword" id="confirmPassword" required oninput="checkPasswordMatch()">
       
        <span id="error-text" style="color: red; display: none;">Passwords do not match</span>
            <span id="password-requirements" style="color: red; display: none;">Password should be at least 8 character and must contain: <br>One Uppercase letter,<br> One Lowercase letter<br>One Special Character(!,$,*,^ ..etc).</span>

      </div>
      <div class="form-group">
        <input type="submit" value="Register" name="register" id="register">
      </div>
    </form>
  </div>

  <script>
     function checkPasswordMatch() {
    var passwordField = document.getElementById("password");
    var confirmPasswordField = document.getElementById("confirmPassword");
    var button = document.getElementById("register");
    var errorText = document.getElementById("error-text");
    var requirementsText = document.getElementById("password-requirements");
  
    if (passwordField.value === confirmPasswordField.value) {
      passwordField.style.border = "";
      errorText.style.display = "none";
      button.disabled = false;
      button.style.cursor = "pointer";
      button.style.backgroundColor = "black";
    } else {
      passwordField.style.border = "1px solid red";
      errorText.style.display = "block";
      button.disabled = true;
      button.style.cursor = "not-allowed";
    }
  
    var password = passwordField.value;
    var hasUpperCase = /[A-Z]/.test(password);
    var hasLowerCase = /[a-z]/.test(password);
    var hasSpecialChar = /[!@#$%^&*(),.?":{}|<>]/.test(password);
    var isLengthValid = password.length >= 8;
  
    if (!isLengthValid || !hasUpperCase || !hasLowerCase || !hasSpecialChar) {
      requirementsText.style.display = "block";
      button.style.cursor = "not-allowed";
      button.disabled = true;
    } else {
      requirementsText.style.display = "none";
      button.style.cursor = "pointer";
      button.disabled = false;
    }
  
         
   
   if(passwordField.value === "" || confirmPasswordField.value === ""){
    requirementsText.style.display = "none";
    errorText.style.display = "none";
   }
  }
  
  </script>
  <?php
  include "../connection/connection.php";

  if (isset($_POST['register'])) {
    if(isset($_POST['oskill'])){
      $skilll = $_POST['oskill'];
      if($skilll != ""){
      $skill = 'other';
      $q = "INSERT INTO `cats`(`id`, `name`) VALUES ('otherr','$skilll')";
      $r = mysqli_query($conn,$q);
      }else{
        $skill = $_POST['skill'];
        }
    }else{
    $skill = $_POST['skill'];
    }
      $username = $_POST['username'];
      $firstName = $_POST['firstName'];
      $lastName = $_POST['lastName'];
      $email = $_POST['email'];
      $gender = $_POST['gender'];
      $dob = $_POST['dob'];
      
      $password = $_POST['password'];
      $confirmPassword = $_POST['confirmPassword'];

      if ($password != $confirmPassword) {
          echo "<script>alert('The passwords do not match')</script>";
      } else {
          $checkingquery = "SELECT * FROM user WHERE `username` = '$username'";
          $checkingresult = mysqli_query($conn,$checkingquery);
          $checkinnumber = mysqli_num_rows($checkingresult);
          if($checkinnumber){
            echo "<script>alert('This username is already taken')</script>";
          }else{

          $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
          $activation_token = bin2hex(random_bytes(16));
          // $activation_token = hash("sha256", $activation_token);
          $sql = "INSERT INTO `user` (`username`, `fname`, `lname`, `email`, `gender`, `dob`, `cat`, `profile`, `password`,`verification_token`) VALUES ('$username', '$firstName', '$lastName', '$email' , '$gender', '$dob', '$skill', 'user.jpeg', '$hashedPassword','$activation_token')";
          if (mysqli_query($conn, $sql)) {
            $mail = new PHPMailer(true);
            try {
                $to = "$username <$email>";
                $subject = "Email Verification";
                $message = "Click here: http://localhost/Senior/log/activate-account.php?token=$activation_token&username=$username to activate your account.";
                
                $headers = "From: SkillLink <baraa.marchoudd@gmail.com>\r\n";
                $headers .= "Reply-To: baraa.marchoudd@gmail.com\r\n";
                
                if (mail($to, $subject, $message, $headers)) {
                    echo "<script>
                            setTimeout(function() {
                                alert('Verification email has been sent to your email Successfully!');
                                window.location.href = '../';
                            }, 0);
                          </script>";
                } else {
                    echo "Failed to send email.";
                }
            } catch (Exception $e) {
                echo "Message could not be sent. Mailer error: {$e->getMessage()}";
                exit;
            }
        } else {
            if ($conn->errno === 1062) {
                die("Email already taken");
            } else {
                die($conn->error . " " . $conn->errno);
            }
        }
      }
  }
}

  mysqli_close($conn);
  ?>

  <script src="script.js"></script>
</body>
</html>