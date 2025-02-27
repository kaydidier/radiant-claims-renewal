<?php
function sendMail($to, $subject, $message)
{
    $headers = "From: kundwadidier@gmail.com" . "\r\n" .
        "CC: florienwaka@gmail.com";

    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

    mail($to, $subject, $message, $headers);
}
