<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../log/phpmailer/vendor/autoload.php';

$mail = new PHPMailer(true);
$mail->isMail();

$to = "baraa.marchoud2244@gmail.com";
$subject = "Test Email";
$message = "This is a test email sent using the PHP mail() function.";
$headers = "From: baraa.marchoudd@gmail.com\r\n";
$headers .= "Reply-To: baraa.marchoudd@gmail.com\r\n";
$headers .= "X-Mailer: PHP/" . phpversion();

if (mail($to, $subject, $message, $headers)) {
    echo "Email sent successfully!";
} else {
    echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
}
?>