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
endif;

if (isset($_SESSION['employeeid'])):
    $employeeQuery = $mysqli->query("SELECT * FROM employees WHERE id_employee = " . $_SESSION['employeeid']);
    $employeeData = $employeeQuery->fetch_array(MYSQLI_ASSOC);
    $firstname = $employeeData['firstname'];
    $lastname = $employeeData['lastname'];
    $phone = $employeeData['phonenumber'];
    $email = $employeeData['email'];
    $dateOfBirth = $employeeData['date_of_birth'];
    $gender = $employeeData['gender'];
    $username = $employeeData['username'];
endif;

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_profile'])) {
    $newUsername = $mysqli->real_escape_string($_POST['new_username']);
    $currentPassword = $mysqli->real_escape_string($_POST['current_password']);
    $newPassword = $mysqli->real_escape_string($_POST['new_password']);
    $confirmPassword = $mysqli->real_escape_string($_POST['confirm_password']);

    if ($newPassword !== $confirmPassword) {
        echo "<script>alert('Passwords do not match');</script>";
        return;
    }

    $userType = isset($_SESSION['clientid']) ? 'client' : 'employee';
    $userId = $_SESSION[$userType . 'id'];
    $table = $userType . 's';
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
                                        <img src="https://picsum.photos/150" alt="Profile Picture" class="rounded-circle">
                                    </div>
                                    <p class="card-text text-center"><strong>Name:</strong> <?php echo ucwords($firstname) . " " . ucwords($lastname); ?></p>
                                    <p class="card-text text-center"><strong>Phone:</strong> <?php echo $phone; ?></p>
                                    <p class="card-text text-center"><strong>Email:</strong> <?php echo $email; ?></p>
                                    <p class="card-text text-center"><strong>Date of Birth:</strong> <?php echo $dateOfBirth; ?></p>
                                    <p class="card-text text-center"><strong>Gender:</strong> <?php echo $gender; ?></p>
                                    <p class="card-text text-center"><strong>Username:</strong> <?php echo $username; ?></p>
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
                                            <input type="text" class="form-control" id="new_username" name="new_username" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="current_password" class="form-label">Current Password</label>
                                            <input type="password" class="form-control" id="current_password" name="current_password" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="new_password" class="form-label">New Password</label>
                                            <input type="password" class="form-control" id="new_password" name="new_password" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="confirm_password" class="form-label">Confirm New Password</label>
                                            <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
                                        </div>
                                        <button type="submit" name="update_profile" class="btn btn-primary">Update</button>
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