<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require __DIR__ . '/../../vendor/autoload.php';


function sendMail($to, $subject, $message){
try {
     // SMTP Configuration
$mail = new PHPMailer(true);

     $mail->isSMTP();
     $mail->Host       = $_ENV['MAIL_HOST'];
     $mail->SMTPAuth   = true;
     $mail->Username   = $_ENV['MAIL_USERNAME']; // Replace with your Gmail
     $mail->Password   = $_ENV['MAIL_PASSWORD'];   // Replace with your App Password
     $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
     $mail->Port       = 587;
 
     // Email Headers
     $mail->setFrom($_ENV['MAIL_FROM_ADDRESS'], $_ENV['MAIL_FROM_NAME']);
     $mail->addAddress($to, 'Client');
     $mail->Subject = $subject;
     $mail->Body    = $message;
 
     // Send Email
     if ($mail->send()) {
         echo 'Email sent successfully!';
     } else {
         echo 'Failed to send email.';
     }
} catch (\Throwable $th) {
    echo "Error: {$mail->ErrorInfo}";
}
}
// sendMail("waka.florien45@gmail.com", 'Test', 'Test message');
?>