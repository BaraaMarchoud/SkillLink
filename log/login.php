<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="lstyle.css"> 
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js" crossorigin="anonymous"></script>


</head>
<body>
    <div class="page-content">
        <div class="form-v10-content">
            <form class="form-detail" action="#" method="post" id="myform">
                <div class="form-left">
                    <h2>Login to Your Account</h2>
                    <div class="form-row">
                        <input type="text" name="username" id="username" placeholder="Username" required>
                    </div>
                    <div class="form-row">
                        <input type="password" name="password" id="password" placeholder="Password" required>
                        <span class="toggle-icon" id="toggle-icon" onclick="togglePassword()" >
                        <i class="fas fa-eye"></i>
                        </span>
                    </div>
                    <div class="form-row-last">
                        <input type="submit" name="login" class="register" value="Login">
                        <p class="login-text">Don't have an account? <a href="register.php" class="login-link">Sign up</a></p>
                        <p class="login-text">Forget Your Password? <a href="../reset/forget.php" class="login-link">Reset</a></p>
                    </div>
                </div>
                <div class="form-right">
                    <img src="background.jpeg" alt="Login Image" style="width:100%; height: auto; border-top-right-radius: 10px; border-bottom-right-radius: 10px;">
                </div>
            </form>
        </div>
    </div>
    <?php
session_start();
include "../connection/connection.php"; 

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM user WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password'])) {
            $token = $row['verification_token'];
            // echo "<script>alert('$token');</script>";
            if($token != NULL){
                echo "<script>alert('You need to activate your account');</script>";
           
            }else{
                $_SESSION['isLoggedIn'] = true;
                $_SESSION['username'] = $row['username'];
                $_SESSION['fname'] = $row['fname'];
                $_SESSION['lname'] = $row['lname'];
                $_SESSION['email'] = $row['email'];
                $_SESSION['dob'] = $row['dob'];
                $_SESSION['skill'] = $row['skill'];
                $_SESSION['role'] = $row['role'];
                $_SESSION['token'] = $row['verification_token'];
    
                header("location: ../home/home.php");
                exit();
            }
        } else {
            echo "<script>alert('Invalid password');</script>";
        }
    } else {
        echo "<script>alert('Invalid username');</script>";
    }
    $stmt->close();
}
$conn->close();
?>

<script src="script.js"></script>


</body>
</html>
