<?php
include "../includes/connection.php";
include "../includes/utils/sms.php";
include "../includes/utils/sendMail.php";

// Get all active insurances that are nearing expiration (30 days before expiry)
$today = date('Y-m-d');
$thirtyDaysFromNow = date('Y-m-d', strtotime('+30 days'));

$query = "SELECT c.firstname, c.lastname, c.phone, c.end_date, i.insurance_name 
          FROM clients c 
          LEFT JOIN insurance i ON c.insurance_id = i.insurance_id 
          WHERE c.end_date BETWEEN '$today' AND '$thirtyDaysFromNow'
          AND c.id_client NOT IN (
              SELECT id_client FROM renewals 
              WHERE status IN ('requested', 'approved')
          )";

$result = $mysqli->query($query);

while ($row = $result->fetch_assoc()) {
    $daysRemaining = floor((strtotime($row['end_date']) - strtotime($today)) / (60 * 60 * 24));
    
    // Prepare SMS message
    $message = "Hello {$row['firstname']} {$row['lastname']}, your {$row['insurance_name']} insurance will expire in {$daysRemaining} days. Please login to your account to renew it.";
    
    // Send SMS
    // $smsResult = sendSMS($row['phone'], $message);
    sendMail($row['email'], "Ensurance Renewal Notice", $message);
    
    // Log the notification (optional)
    $logQuery = "INSERT INTO notification_logs (client_phone, message, sent_date) 
                 VALUES ('{$row['phone']}', '{$message}', NOW())";
    $mysqli->query($logQuery);
}

$mysqli->close(); 