<?php
include "../../includes/connection.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $firstname = $mysqli->real_escape_string($_POST['firstname']);
    $lastname = $mysqli->real_escape_string($_POST['lastname']);
    $phone = $mysqli->real_escape_string($_POST['phone']);
    $email = $mysqli->real_escape_string($_POST['email']);
    $dateOfBirth = $mysqli->real_escape_string($_POST['dateOfBirth']);
    $gender = $mysqli->real_escape_string($_POST['gender']);
    $id_column = isset($_SESSION['clientid']) ? 'id_client' : 'emp_id';
    $phone_column = isset($_SESSION['clientid']) ? 'phone' : 'phonenumber';
    $dateOfBirth_column = isset($_SESSION['clientid']) ? 'dob' : 'date_of_birth';

    $upload_dirs = [
        'profile_pictures' => './../../files/profile_pictures/' . strtolower($firstname) . '/',
    ];

    foreach ($upload_dirs as $dir) {
        if (!is_dir($dir)) {
            mkdir($dir, 0755, true);
        }
    }
     // Sanitize filenames
     $profile_picture = !empty($_FILES['profile_picture']['name']) ? time() . '_' . preg_replace('/[^A-Za-z0-9\-._]/', '', $_FILES['profile_picture']['name']) : '';

    $id = isset($_SESSION['clientid']) ? $_SESSION['clientid'] : $_SESSION['employeeid']; 
    $table = isset($_SESSION['clientid']) ? 'clients' : 'admin';
    $result = true;
    $uploadedFiles = [];

    if (!empty($_FILES['profile_picture']['tmp_name'])) {
        if (move_uploaded_file($_FILES['profile_picture']['tmp_name'], $upload_dirs['profile_pictures'] . $profile_picture)) {
            $uploadedFiles[] = $profile_picture;
        } else {
            $result = false;
        }
    }
    
    $eighteenYearsAgo = date("Y-m-d", strtotime("-18 years"));
    if ($dateOfBirth > $eighteenYearsAgo) {
        echo "<script type='text/javascript'>alert('Only people above 18 years old are allowed to have vehicles');</script>";
    }
    
    $updateFields = array();
    $updateFields[] = "firstname = '$firstname'";
    $updateFields[] = "lastname = '$lastname'";
    $updateFields[] = "$phone_column = '$phone'";
    $updateFields[] = "email = '$email'";
    $updateFields[] = "$dateOfBirth_column = '$dateOfBirth'";
    $updateFields[] = "sex='$gender'";
    if(!empty($profile_picture)) $updateFields[] = "profile_image='$profile_picture'";

    $query = "UPDATE $table SET " . implode(", ", $updateFields) . " WHERE $id_column   = $id";
    if ($mysqli->query($query)) {
        echo "<script>alert('Failed to update profile: " . $profile_picture . "');</script>";
        header("Location: profile.php");
        exit();
    } else {
        echo "<script>alert('Failed to update profile: " . $mysqli->error . "');</script>";
    }
}
