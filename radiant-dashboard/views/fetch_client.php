<?php
include "../../includes/connection.php";

if (isset($_POST['client_id'])) {
    $clientId = $mysqli->real_escape_string($_POST['client_id']);
    
    $query = "SELECT * FROM clients WHERE id_client = '$clientId'";
    $result = $mysqli->query($query);
    
    if ($result && $result->num_rows > 0) {
        $client = $result->fetch_assoc();
        echo json_encode($client);
    } else {
        http_response_code(404);
        echo json_encode(['error' => 'Client not found']);
    }
} else {
    http_response_code(400);
    echo json_encode(['error' => 'No client ID provided']);
}
?> 