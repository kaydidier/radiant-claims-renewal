<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require __DIR__ . '/../../vendor/autoload.php';


function sendMail($to, $subject, $message){
try {
     // SMTP Configuration
$mail = new PHPMailer(true);

     $mail->isSMTP();
     $mail->Host       = 'smtp.gmail.com';
     $mail->SMTPAuth   = true;
     $mail->Username   = 'kundwadidier@gmail.com'; // Replace with your Gmail
     $mail->Password   = 'uzuw hbdy xmwd bsso';   // Replace with your App Password
     $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
     $mail->Port       = 587;
 
     // Email Headers
     $mail->setFrom('kundwadidier@gmail.com', 'Radiant Insurance Company');
     $mail->addAddress($to, 'Client');
     $mail->Subject = $subject;
     $mail->Body    = $message;
 
     // Send Email
     if ($mail->send()) {   
         echo 'Email sent successfully!'. $to. "====> ". $subject. "====>" . $message;
     } else {
         echo 'Failed to send email.';
     }
} catch (\Throwable $th) {
    echo "Error: {$mail->ErrorInfo}";
}
}
?>