<?php

declare(strict_types=1);

require __DIR__ . '/../autoload.php';
require __DIR__ . '/../../../vendor/autoload.php';


use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
use Symfony\Component\Dotenv\Dotenv;

if (isset($_POST['email'])) {
    $dotenv = new Dotenv();
    $dotenv->loadEnv(__DIR__ . '/../../../.env');
    $password = $_ENV['EMAIL_PASSWORD'];
    $emailTo = $_POST['email'];

    try {
        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->Host = "smtp.gmail.com";
        $mail->SMTPAuth = "true";
        $mail->SMTPSecure = "tls";
        $mail->Port = "587";
        $mail->Username = "antmar0417@skola.goteborg.se";
        // Type a password here
        $mail->Password = "$password";
        $mail->Subject = "Password Reset";
        $mail->setFrom("antmar0417@skola.goteborg.se");
        $linkEmail = "http://localhost:8080/reset-password-link.php?email=" . $emailTo;
        $mail->isHTML(true);
        $mail->Body = "<h1>You requested a password reset! </h1>
            Click on <a href='$linkEmail'>this link</a> to reset the password";
        // Reciever
        $mail->addAddress($emailTo);
        $mail->Send();
        echo "Reset password link has been sent to your email!";

        $mail->smtpClose();
    } catch (Exception $e) {
        echo 'Error: ', $mail->ErrorInfo;
    }
    redirect('/index.php');
}
