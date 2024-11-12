<!DOCTYPE html>
<html>
<head>
    <title>Forgot Password</title>
    <link rel="stylesheet" href="lstyle.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js" crossorigin="anonymous"></script>
    <style>
        
    </style>
</head>
<body>
    <div class="container">
        <h2>Forgot Password</h2>
        <form action="" method="POST">
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" name="email" id="email" required>
            </div>
            <div class="form-group">
                <input type="submit" name="reset" value="Reset Password">
            </div>
        </form>
    </div>

    <?php
    include "../connection/connection.php";
    
    if (isset($_POST['reset'])) {
        // Retrieve the email entered by the user
        $email = $_POST['email'];

        // Check if the email exists in the database
        $query = "SELECT * FROM user WHERE email = ?";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $numRows = mysqli_num_rows($result);

        if ($numRows > 0) {
            // Generate a random password
            $newPassword = generateRandomPassword();

            // Update the user's password in the database
            $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
            $updateQuery = "UPDATE user SET password = ? WHERE email = ?";
            $updateStmt = mysqli_prepare($conn, $updateQuery);
            mysqli_stmt_bind_param($updateStmt, "ss", $hashedPassword, $email);
            mysqli_stmt_execute($updateStmt);

            // Send the new password to the user via email
            $to = $email;
            $subject = "Password Reset";
            $message = "Your new password: " . $newPassword;
            $headers = "From: your-email@example.com" . "\r\n" .
                "Reply-To: your-email@example.com" . "\r\n" .
                "X-Mailer: PHP/" . phpversion();

            if (mail($to, $subject, $message, $headers)) {
                echo "<script>alert('Your password has been reset. Please check your email for the new password.')</script>";
            } else {
                echo "<script>alert('Failed to send the email. Please try again later.')</script>";
            }
        } else {
            echo "<script>alert('Invalid email. Please try again.')</script>";
        }
    }

    function generateRandomPassword() {
        // Generate a random password of length 8
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $password = '';
        for ($i = 0; $i < 8; $i++) {
            $index = rand(0, strlen($characters) - 1);
            $password .= $characters[$index];
        }
        return $password;
    }
    
    mysqli_close($conn);
    ?>
</body>
</html>