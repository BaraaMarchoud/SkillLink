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
    <section>
        <h1>Reset Password</h1>
        <form action="" id="SignInFormData" method="POST">
            <label for="username">Enter Your Username</label>
            <input type="text" name="username" id="username" placeholder="Username">
            <button type="submit" title="Send Code" name="lg" id="signin">Send Code</button>
        </form>
        <a href="../log/login.php">Back to Login</a>
    </section>

    <?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;


require '../log/phpmailer/vendor/autoload.php';
require("../connection/connection.php");

if (isset($_POST["lg"])) {
    $username = $_POST["username"];

    $stmt = $conn->prepare("SELECT email, username, fname FROM user WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $email = $row["email"];
        $name = $row["fname"];

        $mail = new PHPMailer(true);

        try {
            $to = "$email";
            $subject = "Reset Password";
            $verification_code = substr(number_format(time() * rand(), 0, '', ''), 0, 6);
            $message = "Dear $name,\n\nYour verification code is: $verification_code";

            $mail->setFrom("baraa.marchoudd@gmail.com");
            $mail->addAddress($to);
            $mail->Subject = $subject;
            $mail->Body = $message;

            if ($mail->send()) {
                $stmt = $conn->prepare("INSERT INTO email_ver(username, code) VALUES (?, ?)");
                $stmt->bind_param("ss", $username, $verification_code);
                $stmt->execute();

                echo "<script>
                    setTimeout(function() {
                        alert('Code for resetting password has been sent to your email successfully!');
                    }, 0);
                    window.location.href = 'email_verification_resetpass.php?U=$username';
                </script>";
                exit();
            } else {
                error_log("Failed to send email. Reason: " . $mail->ErrorInfo);
                // echo "<script>alert('Failed to send email. Please try again later.');</script>";
            }
        } catch (Exception $e) {
            echo("Exception occurred while sending email: " . $e->getMessage());
            // echo "<script>alert('An error occurred. Please try again later.');</script>";
        }
    } else {
        echo "<script>alert('$username not found!');</script>";
    }
}
?>
</body>
</html>