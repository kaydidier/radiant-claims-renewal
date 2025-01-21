<!-- get_districts.php -->
<?php
include '/path/to/connection.php'; // Update the path to your connection.php file

if(isset($_POST['province_id'])) {

    // Prepare and execute query
    $stmt = $conn->prepare("SELECT id, name FROM districts WHERE provinceId = ? ORDER BY name");
    $stmt->bind_param("i", $_POST['provinceId']);
    $stmt->execute();
    $result = $stmt->get_result();
    
    // Generate options
    $output = '<option value="">Select District</option>';
    while ($district = $result->fetch_assoc()) {
        $output .= '<option value="'.$district['districtId'].'">'.$district['districtName'].'</option>';
    }
    
    echo $output;

    // Close connections
    $stmt->close();
    $conn->close();
} else {
    echo '<option value="">Invalid province selection</option>';
}
?>