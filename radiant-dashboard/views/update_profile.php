<?php
include "../../includes/connection.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $profile_image = $mysqli->real_escape_string($_POST['profile_image']);
    $firstname = $mysqli->real_escape_string($_POST['firstname']);
    $lastname = $mysqli->real_escape_string($_POST['lastname']);
    $phone = $mysqli->real_escape_string($_POST['phone']);
    $email = $mysqli->real_escape_string($_POST['email']);
    $dateOfBirth = $mysqli->real_escape_string($_POST['dateOfBirth']);
    $gender = $mysqli->real_escape_string($_POST['gender']);
    $id_column = isset($_SESSION['clientid']) ? 'id_client' : 'emp_id';
    $phone_column = isset($_SESSION['clientid']) ? 'phone' : 'phonenumber';
    $dateOfBirth_column = isset($_SESSION['clientid']) ? 'dob' : 'date_of_birth';

    $upload_dir = [
        'profile_pictures' => './../../files/profile_pictures/' . strtolower($firstname) . '/',
    ];

    foreach ($upload_dir as $dir) {
        if (!is_dir($dir)) {
            mkdir($dir, 0755, true);
        }
    }
     // Sanitize filenames
     $profile_picture = !empty($_FILES['profile_picture']['name']) ? time() . '_' . preg_replace('/[^A-Za-z0-9\-._]/', '', $_FILES['profile_picture']['name']) : '';

    $id = isset($_SESSION['clientid']) ? $_SESSION['clientid'] : $_SESSION['employeeid']; 
    $table = isset($_SESSION['clientid']) ? 'clients' : 'employees';
    $result = true;
    $uploadedFiles = [];

    $eighteenYearsAgo = date("Y-m-d", strtotime("-18 years"));
    if ($dateOfBirth > $eighteenYearsAgo) {
        echo "<script type='text/javascript'>alert('Only people above 18 years old are allowed to have vehicles');</script>";
    }
    if (!empty($_FILES['profile_picture']['tmp_name'])) {
        $result = $result && move_uploaded_file($_FILES['profile_picture']['tmp_name'], $upload_dir['profile_pictures'] . $profile_picture);
        $uploadedFiles[] = $profile_picture;
    }
    
    $updateFields = array();
    $updateFields[] = "firstname = '$firstname'";
    $updateFields[] = "lastname = '$lastname'";
    $updateFields[] = "$phone_column = '$phone'";
    $updateFields[] = "email = '$email'";
    $updateFields[] = "$dateOfBirth_column = '$dateOfBirth'";
    $updateFields[] = "sex = '$gender'";
    $updateFields[] = "profile_image = '$profile_image'";

    $query = "UPDATE $table SET " . implode(", ", $updateFields) . " WHERE $id_column   = $id";
    if ($mysqli->query($query)) {
        echo "<script>alert('Profile updated successfully. Please log in again.');</script>";
    } else {
        echo "<script>alert('Failed to update profile: " . $mysqli->error . "');</script>";
    }
}
