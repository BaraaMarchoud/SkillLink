<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../log/phpmailer/vendor/autoload.php';

try {
    $mail = new PHPMailer(true);
    $mail->isMail();
    $mail->setFrom('baraa.marchoudd@gmail.com', 'SkillLink');
    $mail->addAddress('baraa.marchoud2244@gmail.com', 'You');
    $mail->Subject = 'Here is the subject';
    $mail->Body = 'This is the body of the message.';

    if ($mail->send()) {
        echo 'Message has been sent';
    } else {
        echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
    }
} catch (Exception $e) {
    echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
}
?>