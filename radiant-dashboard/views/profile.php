<?php
include "../../includes/connection.php";

if (!isset($_SESSION['employeeid']) && !isset($_SESSION['clientid'])) {
    header("LOCATION: ../../index.php");
    exit();
} ?>

<!DOCTYPE html>
<html lang="en">
<?php
include "../views/layout/header.php";

if (isset($_SESSION['clientid'])):
    $clientQuery = $mysqli->query("SELECT * FROM clients WHERE id_client = " . $_SESSION['clientid']);
    $clientData = $clientQuery->fetch_array(MYSQLI_ASSOC);
    $firstname = $clientData['firstname'];
    $lastname = $clientData['lastname'];
    $phone = $clientData['phone'];
    $email = $clientData['email'];
    $dateOfBirth = $clientData['dob'];
    $gender = $clientData['sex'];
    $username = $clientData['username'];
    $profile_picture = $clientData['profile_image'];
endif;

if (isset($_SESSION['employeeid'])):
    $employeeQuery = $mysqli->query("SELECT * FROM admin WHERE emp_id = " . $_SESSION['employeeid']);
    $employeeData = $employeeQuery->fetch_array(MYSQLI_ASSOC);
    $firstname = $employeeData['firstname'];
    $lastname = $employeeData['lastname'];
    $phone = $employeeData['phonenumber'];
    $email = $employeeData['email'];
    $dateOfBirth = $employeeData['date_of_birth'];
    $gender = $employeeData['sex'];
    $username = $employeeData['username'];
    $profile_picture = $employeeData['profile_image'];
endif;

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_password'])) {
    $newUsername = $mysqli->real_escape_string($_POST['new_username']);
    $currentPassword = $mysqli->real_escape_string($_POST['current_password']);
    $newPassword = $mysqli->real_escape_string($_POST['new_password']);
    $confirmPassword = $mysqli->real_escape_string($_POST['confirm_password']);

    if ($newPassword !== $confirmPassword) {
        echo "<script>alert('Passwords do not match');</script>";
        return;
    }

    $userType = isset($_SESSION['clientid']) ? 'client' : 'admin';
    $userId = $_SESSION[$userType . 'id'];
    $table = isset($_SESSION['clientid']) ? 'clients' : 'admin';
    $idField = isset($_SESSION['clientid']) ? 'id_client' : 'emp_id';

    $result = $mysqli->query("SELECT password FROM $table WHERE $idField = $userId");
    $row = $result->fetch_assoc();

    if ($currentPassword !== $row['password']) {
        echo "<script>alert('Current password is incorrect');</script>";
        return;
    }

    $updateQuery = "UPDATE $table SET username='$newUsername', password='$newPassword' WHERE $idField = $userId";

    if ($mysqli->query($updateQuery)) {
        session_unset();
        session_destroy();
        echo "<script>alert('Profile updated successfully. Please log in again.'); window.location.href = '../../login.view.php';</script>";
    } else {
        echo "<script>alert('Failed to update profile: " . $mysqli->error . "');</script>";
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_profile'])) {
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
        'profile_picture' => './../../files/profile_pictures/' . strtolower($firstname) . '/',
    ];

    foreach ($upload_dir as $dir) {
        if (!is_dir($dir)) {
            mkdir($dir, 0755, true);
        }
    }

    // Initialize profile_picture variable
    $profile_picture = '';

    // Only process profile picture if a file was uploaded
    if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] === UPLOAD_ERR_OK) {
        $profile_picture = time() . '_' . preg_replace('/[^A-Za-z0-9\-._]/', '', $_FILES['profile_picture']['name']);
        $target_path = $upload_dir['profile_picture'] . $profile_picture;
        
        // Delete existing profile picture if it exists
        if (!empty($clientData['profile_image']) || !empty($employeeData['profile_image'])) {
            $old_picture = $upload_dir['profile_picture'] . ($clientData['profile_image'] ?? $employeeData['profile_image']);
            if (file_exists($old_picture)) {
                unlink($old_picture);
            }
        }

        if (!move_uploaded_file($_FILES['profile_picture']['tmp_name'], $target_path)) {
            echo "<script>alert('Failed to upload profile picture');</script>";
            exit();
        }
    }

    $id = isset($_SESSION['clientid']) ? $_SESSION['clientid'] : $_SESSION['employeeid'];
    $table = isset($_SESSION['clientid']) ? 'clients' : 'admin';
    $result = true;
    $uploadedFiles = [];

    $eighteenYearsAgo = date("Y-m-d", strtotime("-18 years"));
    if ($dateOfBirth > $eighteenYearsAgo) {
        echo "<script type='text/javascript'>alert('Only people above 18 years old are allowed to have vehicles');</script>";
    }

    // Remove the duplicate profile_image field and the debug code
    $updateFields = array();
    $updateFields[] = "firstname = '$firstname'";
    $updateFields[] = "lastname = '$lastname'";
    $updateFields[] = "$phone_column = '$phone'";
    $updateFields[] = "email = '$email'";
    $updateFields[] = "$dateOfBirth_column = '$dateOfBirth'";
    $updateFields[] = "sex='$gender'";
    if (!empty($profile_picture)) {
        $updateFields[] = "profile_image='$profile_picture'";
    }

    $query = "UPDATE $table SET " . implode(", ", $updateFields) . " WHERE $id_column = $id";

    // Remove the print_r and die statements
    if ($mysqli->query($query)) {
        echo "<script>alert('Profile updated successfully');</script>";
        header("Location: profile.php");
        exit();
    } else {
        echo "<script>alert('Failed to update profile: " . $mysqli->error . "');</script>";
    }
}
?>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">
        <?php
        include "../views/layout/sidebar.php";
        ?>
        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">
            <!-- Main Content -->
            <div id="content">
                <?php
                include "../views/layout/top_bar.php";
                ?>
                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <h1 class="h3 mb-2 text-gray-800">Profile</h1>
                    <p class="mb-4">Welcome back to your profile page <strong><?php echo ucwords($firstname); ?></strong> ,</p>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title text-center">Personal Information</h5>
                                    <div class="text-center mb-3">
                                        <img src="<?php echo "./../../files/profile_pictures/" . strtolower($firstname) . "/" . $profile_picture; ?>" alt="Profile Picture" class="rounded-circle h-50 w-50">
                                    </div>
                                    <div class="profile-info">
                                        <form id="profileForm" method="POST" action="" enctype="multipart/form-data" class="d-none">
                                            <div class="form-group mb-2">
                                                <label>Profile Picture:</label>
                                                <input type="file" class="form-control" name="profile_picture" accept="image/*" id="profile_picture" required>
                                            </div>
                                            <div class="form-group mb-2">
                                                <label>First Name:</label>
                                                <input type="text" class="form-control" name="firstname" value="<?php echo $firstname; ?>">
                                            </div>
                                            <div class="form-group mb-2">
                                                <label>Last Name:</label>
                                                <input type="text" class="form-control" name="lastname" value="<?php echo $lastname; ?>">
                                            </div>
                                            <div class="form-group mb-2">
                                                <label>Phone:</label>
                                                <input type="tel" class="form-control" name="phone" value="<?php echo $phone; ?>">
                                            </div>
                                            <div class="form-group mb-2">
                                                <label>Email:</label>
                                                <input type="email" class="form-control" name="email" value="<?php echo $email; ?>">
                                            </div>
                                            <div class="form-group mb-2">
                                                <label>Date of Birth:</label>
                                                <input type="date" class="form-control" name="dateOfBirth" value="<?php echo $dateOfBirth; ?>">
                                            </div>
                                            <div class="form-group mb-2">
                                                <label>Gender:</label>
                                                <select class="form-control" name="gender">
                                                    <option value="Male" <?php echo ($gender == 'Male') ? 'selected' : ''; ?>>Male</option>
                                                    <option value="Female" <?php echo ($gender == 'Female') ? 'selected' : ''; ?>>Female</option>
                                                    <option value="Other" <?php echo ($gender == 'Other') ? 'selected' : ''; ?>>Other</option>
                                                </select>
                                            </div>
                                            <div class="text-center mt-3">
                                                <button type="submit" class="btn btn-primary" name="update_profile">Save Changes</button>
                                                <button type="button" class="btn btn-secondary" onclick="toggleEdit()">Cancel</button>
                                            </div>
                                        </form>

                                        <div id="profileInfo">
                                            <p class="card-text text-center"><strong>Name:</strong> <?php echo ucwords($firstname) . " " . ucwords($lastname); ?></p>
                                            <p class="card-text text-center"><strong>Phone:</strong> <?php echo $phone; ?></p>
                                            <p class="card-text text-center"><strong>Email:</strong> <?php echo $email; ?></p>
                                            <p class="card-text text-center"><strong>Date of Birth:</strong> <?php echo $dateOfBirth; ?></p>
                                            <p class="card-text text-center"><strong>Gender:</strong> <?php echo $gender; ?></p>
                                            <p class="card-text text-center"><strong>Username:</strong> <?php echo $username; ?></p>
                                            <div class="text-center mt-3">
                                                <button class="btn btn-primary" onclick="toggleEdit()">Edit Profile</button>
                                            </div>
                                        </div>
                                    </div>

                                    <script>
                                        function toggleEdit() {
                                            const form = document.getElementById('profileForm');
                                            const info = document.getElementById('profileInfo');
                                            form.classList.toggle('d-none');
                                            info.classList.toggle('d-none');
                                        }
                                    </script>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">Change Username and Password</h5>
                                    <form method="POST" action="">
                                        <div class="mb-3">
                                            <label for="new_username" class="form-label">New Username</label>
                                            <input type="text" class="form-control" id="new_username" name="new_username" autocomplete="off" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="current_password" class="form-label">Current Password</label>
                                            <input type="password" class="form-control" id="current_password" name="current_password" autocomplete="off" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="new_password" class="form-label">New Password</label>
                                            <input type="password" class="form-control" id="new_password" name="new_password" autocomplete="off" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="confirm_password" class="form-label">Confirm New Password</label>
                                            <input type="password" class="form-control" id="confirm_password" name="confirm_password" autocomplete="off" required>
                                        </div>
                                        <button type="submit" name="update_password" class="btn btn-primary">Update</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.container-fluid -->
            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <?php
            include "../views/layout/footer.php";
            ?>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <?php
    include "../views/layout/file_includes.php";
    ?>

</body>

</html>