<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once __DIR__ . '/vendor/autoload.php'; // Ensure PHPMailer is autoloaded

$mail = new PHPMailer(true);

try {
    // Server settings
    $mail->SMTPDebug = 0; // Set to 0 to suppress debug output
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = getenv('iamisaacyakubu3@gmail.com'); // Use environment variable for username
    $mail->Password = getenv(''); // Use environment variable for password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = 587;

    // Recipients
    $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
    $name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
    $subject = filter_var($_POST['subject'], FILTER_SANITIZE_STRING);
    $message = htmlspecialchars($_POST['message']);
    $siteOwnersEmail = getenv('iamisaacyakubu3@gmail.com'); // Use environment variable for recipient email

    $mail->setFrom($email, $name);
    $mail->addAddress($siteOwnersEmail);
    $mail->addReplyTo($email, $name);

    // Content
    $mail->isHTML(true);
    $mail->Subject = $subject;
    $mail->Body = $message;

    $mail->send();
    echo "OK";
} catch (Exception $e) {
    error_log("Mailer Error: " . $mail->ErrorInfo); // Log the error for debugging
    echo "An error occurred. Please try again later."; // Generic error message for users
} finally {
    $mail->smtpClose(); // Correct method to close the SMTP connection
}
