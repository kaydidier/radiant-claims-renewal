<?php
include "../../includes/connection.php";

if (!isset($_SESSION['employeeid'])) {
    header("LOCATION: ../../index.php");
} ?>

<!DOCTYPE html>
<html lang="en">
<?php
include "../views/layout/header.php";
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


                    <!-- Page Heading -->
                    <h1 class="h3 mb-2 text-gray-800">Clients</h1>
                    <p class="mb-4">Add, edit, or remove client profiles with ease from this centralized interface.</p>

                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <div class="row justify-content-end">
                                <div class="col-md-2 col-sm-12">
                                    <h6 class="m-0 text-primary">All clients</h6>
                                </div>
                                <div class="col-md-8 col-sm-12"></div>
                                <div class="col-md-2 col-sm-12">
                                    <a href="#" class="btn btn-md btn-outline-primary btn-user d-flex align-items-center" data-toggle="modal" data-target="#addClient">
                                        <i class="fas fa-fw fa-plus-circle"></i>
                                        <span class="ml-2">Add Client</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable">
                                    <thead>
                                        <tr>
                                            <th>Id</th>
                                            <th>Names</th>
                                            <th>Phone Number</th>
                                            <th>Email</th>
                                            <th>ID Number</th>
                                            <th>Proof of Income</th>
                                            <th>Contract</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $allClients = mysqli_query($mysqli, "SELECT * FROM clients");
                                        $a = 1;
                                        while ($row = mysqli_fetch_array($allClients)) {
                                        ?>
                                            <tr>
                                                <td><?php echo $a; ?></td>
                                                <td><?php echo ucfirst($row['firstname']) . " " . ucfirst($row['lastname']); ?></td>
                                                <td><?php echo $row['phone']; ?></td>
                                                <td><?php echo $row['email']; ?></td>
                                                <td><?php echo $row['ID_no']; ?></td>
                                                <?php
                                                $incomeFilePath = './../../files/incomeproofs/' . strtolower($row['firstname']) . '/' . $row['proof_of_income'];
                                                $contractFilePath = './../../files/contracts/' . strtolower($row['firstname']) . '/' . $row['contract'];
                                                ?>
                                                <td>
                                                    <?php if (file_exists($incomeFilePath)) { ?>
                                                        <a href="<?php echo $incomeFilePath; ?>" target="_blank">View Proof of Income</a>
                                                    <?php } else { ?>
                                                        <span class="text-danger">File not found</span>
                                                    <?php } ?>
                                                </td>
                                                <td>
                                                    <?php if (file_exists($contractFilePath)) { ?>
                                                        <a href="<?php echo $contractFilePath; ?>" target="_blank">View Contract</a>
                                                    <?php } else { ?>
                                                        <span class="text-danger">File not found</span>
                                                    <?php } ?>
                                                </td>
                                                <td>
                                                    <a href="#" class="btn btn-sm btn-warning edit-client-btn" data-toggle="modal" data-target="#editClient" data-client-id="<?php echo $row['id_client']; ?>">
                                                        Edit
                                                    </a>
                                                    <a href="#" class="btn btn-sm btn-danger my-2 delete-client-btn" data-toggle="modal" data-target="#deleteClient" data-client-id="<?php echo $row['id_client']; ?>">
                                                        Delete
                                                    </a>
                                                </td>
                                            </tr>
                                        <?php
                                            $a++;
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- Edit Client Modal-->
                        <?php
                        $insurances = mysqli_query($mysqli, "SELECT * FROM insurance");
                        $provinces = mysqli_query($mysqli, "SELECT * FROM province");
                        $clientId = null;

                        if (isset($_POST['edit_client_id'])) {
                            $clientId = $mysqli->real_escape_string($_POST['edit_client_id']);

                            $clientSql = $mysqli->query("SELECT * FROM clients WHERE id_client = '$clientId'") or die($mysqli->error);
                            $client = mysqli_fetch_array($clientSql);
                        } else {
                            $client = null;
                        }

                        if (isset($_POST['edit_client'])) {
                            $i = 0;

                            // Sanitize and validate input data
                            $insurance = $mysqli->real_escape_string($_POST['insurance']);
                            $empId = $_SESSION['employeeid'];
                            $firstname = $mysqli->real_escape_string($_POST['firstname']);
                            $lastname = $mysqli->real_escape_string($_POST['lastname']);
                            $password = $mysqli->real_escape_string($_POST['password']);
                            $email = $mysqli->real_escape_string($_POST['email']);
                            $idno = $mysqli->real_escape_string($_POST['idno']);
                            $gender = $mysqli->real_escape_string($_POST['gender']);
                            $dob = $mysqli->real_escape_string($_POST['dob']);
                            $district = $mysqli->real_escape_string($_POST['district']);
                            $province = $mysqli->real_escape_string($_POST['province']);
                            $phone = $mysqli->real_escape_string($_POST['phone']);
                            $bankaccount = $mysqli->real_escape_string($_POST['bankaccount']);
                            $plate = $mysqli->real_escape_string($_POST['plate']);
                            $startDate = $mysqli->real_escape_string($_POST['startDate']);
                            $endDate = $mysqli->real_escape_string($_POST['endDate']);
                            $house = $mysqli->real_escape_string($_POST['upi']);

                            // Define upload directories
                            $upload_dirs = [
                                'licenses' => './../../files/licenses/' . strtolower($firstname) . '/',
                                'yellows' => './../../files/yellows/' . strtolower($firstname) . '/',
                                'incomeproofs' => './../../files/incomeproofs/' . strtolower($firstname) . '/',
                                'contracts' => './../../files/contracts/' . strtolower($firstname) . '/'
                            ];

                            // Create directories if they don't exist
                            foreach ($upload_dirs as $dir) {
                                if (!is_dir($dir)) {
                                    mkdir($dir, 0755, true);
                                }
                            }

                            // Sanitize filenames
                            $licenseFile = !empty($_FILES['license']['name']) ? time() . '_' . preg_replace('/[^A-Za-z0-9\-._]/', '', $_FILES['license']['name']) : '';
                            $yellowFile = !empty($_FILES['yellow']['name']) ? time() . '_' . preg_replace('/[^A-Za-z0-9\-._]/', '', $_FILES['yellow']['name']) : '';
                            $incomeFile = !empty($_FILES['income']['name']) ? time() . '_' . preg_replace('/[^A-Za-z0-9\-._]/', '', $_FILES['income']['name']) : '';
                            $contractFile = !empty($_FILES['contract']['name']) ? time() . '_' . preg_replace('/[^A-Za-z0-9\-._]/', '', $_FILES['contract']['name']) : '';

                            // Move uploaded files
                            $result = true;
                            $uploadedFiles = [];

                            // Check for duplicate entries excluding current client
                            $query = $mysqli->query("SELECT * FROM clients WHERE (email='$email' OR phone='$phone' OR ID_no='$idno' OR bank_account='$bankaccount') AND id_client != '$clientId'") or die($mysqli->error);

                            if (mysqli_num_rows($query) > 0) {
                                echo "<script type='text/javascript'>alert('Duplicate entry found');</script>";
                            } elseif (empty($insurance) || empty($firstname) || empty($lastname) || empty($email) || empty($idno) || empty($gender) || empty($dob) || empty($district) || empty($province) || empty($phone) || empty($bankaccount) || empty($startDate) || empty($endDate) || empty($password)) {
                                echo "<script type='text/javascript'>alert('Please fill in required fields');</script>";
                            } elseif ($dob > date("Y-m-d", (time() - (18 * 365 * 24 * 60 * 60)))) {
                                echo "<script type='text/javascript'>alert('Only people above 18 years old are allowed to have vehicles');</script>";
                            } else {
                                // Move files to dirs if uploaded
                                if (!empty($_FILES['license']['tmp_name'])) {
                                    $result = $result && move_uploaded_file($_FILES['license']['tmp_name'], $upload_dirs['licenses'] . $licenseFile);
                                    $uploadedFiles[] = $licenseFile;
                                }
                                if (!empty($_FILES['yellow']['tmp_name'])) {
                                    $result = $result && move_uploaded_file($_FILES['yellow']['tmp_name'], $upload_dirs['yellows'] . $yellowFile);
                                    $uploadedFiles[] = $yellowFile;
                                }
                                if (!empty($_FILES['income']['tmp_name'])) {
                                    $result = $result && move_uploaded_file($_FILES['income']['tmp_name'], $upload_dirs['incomeproofs'] . $incomeFile);
                                    $uploadedFiles[] = $incomeFile;
                                }
                                if (!empty($_FILES['contract']['tmp_name'])) {
                                    $result = $result && move_uploaded_file($_FILES['contract']['tmp_name'], $upload_dirs['contracts'] . $contractFile);
                                    $uploadedFiles[] = $contractFile;
                                }

                                // Build update query with only changed fields
                                $updateFields = array();
                                $updateFields[] = "firstname='$firstname'";
                                $updateFields[] = "lastname='$lastname'";
                                if (!empty($password)) $updateFields[] = "password='$password'";
                                $updateFields[] = "email='$email'";
                                $updateFields[] = "ID_no='$idno'";
                                $updateFields[] = "sex='$gender'";
                                $updateFields[] = "dob='$dob'";
                                $updateFields[] = "district='$district'";
                                $updateFields[] = "province='$province'";
                                $updateFields[] = "phone='$phone'";
                                $updateFields[] = "bank_account='$bankaccount'";
                                $updateFields[] = "insurance_id='$insurance'";
                                if (!empty($plate)) $updateFields[] = "plate_number='$plate'";
                                if (!empty($house)) $updateFields[] = "upi='$house'";
                                $updateFields[] = "start_date='$startDate'";
                                $updateFields[] = "end_date='$endDate'";
                                if (!empty($licenseFile)) $updateFields[] = "driving_license='$licenseFile'";
                                if (!empty($yellowFile)) $updateFields[] = "yellow_paper='$yellowFile'";
                                if (!empty($incomeFile)) $updateFields[] = "proof_of_income='$incomeFile'";
                                if (!empty($contractFile)) $updateFields[] = "contract='$contractFile'";

                                $updateSql = "UPDATE clients SET " . implode(", ", $updateFields) . " WHERE id_client='$clientId'";

                                if ($mysqli->query($updateSql)) {

                                    $smsResult = sendSMS(
                                        $phone,
                                        "Hello, " . $firstname . " " . $lastname . " Your details have been updated."
                                    );

                                    echo "<script type='text/javascript'>alert('Client updated successfully!');
                                    window.location.href = window.location.href;</script>";
                                } else {
                                    echo "<script type='text/javascript'>alert('Failed to update client: " . $mysqli->error . "');</script>";
                                }
                            }
                        }
                        ?>

                        <div class="modal fade" id="editClient" tabindex="-1" role="dialog" aria-labelledby="clientModalLabel"
                            aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel">
                            <div class="modal-dialog modal-xl" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Edit client</h5>
                                        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">×</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form method="POST" enctype="multipart/form-data" class="col">
                                            <input type="hidden" name="edit_client_id" id="edit_client_id">
                                            <div class="row">
                                                <div class="col">
                                                    <div class="mb-3">
                                                        <label for="edit_firstname" class="form-label">Firstname</label>
                                                        <input type="text" class="form-control" id="edit_firstname" name="firstname" value="<?php echo isset($client['firstname']) ? $client['firstname'] : ''; ?>">
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="edit_lastname" class="form-label">Lastname</label>
                                                        <input type="text" class="form-control" id="edit_lastname" name="lastname" value="<?php echo isset($client['lastname']) ? $client['lastname'] : ''; ?>">
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="edit_phone" class="form-label">Phone number</label>
                                                        <input type="phone" class="form-control" id="edit_phone" name="phone" value="<?php echo isset($client['phone']) ? $client['phone'] : ''; ?>">
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="edit_gender" class="form-label">Gender</label>
                                                        <select class="form-control" id="edit_gender" name="gender">
                                                            <option value="male" <?php echo (isset($client['sex']) && $client['sex'] == 'male') ? 'selected' : ''; ?>>Male</option>
                                                            <option value="female" <?php echo (isset($client['sex']) && $client['sex'] == 'female') ? 'selected' : ''; ?>>Female</option>
                                                        </select>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="edit_idno" class="form-label">ID number</label>
                                                        <input type="text" class="form-control" id="edit_idno" name="idno" value="<?php echo isset($client['ID_no']) ? $client['ID_no'] : ''; ?>">
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="edit_email" class="form-label">Email address</label>
                                                        <input type="email" class="form-control" id="edit_email" name="email" value="<?php echo isset($client['email']) ? $client['email'] : ''; ?>">
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="edit_dob" class="form-label">Date of Birth</label>
                                                        <input type="date" class="form-control" id="edit_dob" name="dob" onchange="validateDOB()" value="<?php echo isset($client['dob']) ? $client['dob'] : ''; ?>">
                                                        <div class="invalid-feedback" id="edit_dobFeedback">You must be over 18 years old.</div>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="edit_province" class="form-label">Province</label>
                                                        <select class="form-control" id="edit_province" name="province">
                                                            <?php
                                                            $province = mysqli_query($mysqli, "SELECT * from province");

                                                            $i = 0;
                                                            while ($row = mysqli_fetch_array($province)) { {
                                                                    $i++;
                                                                    if ($i == 1) {
                                                                        $initialProvince = $row['provinceId'];
                                                                    }

                                                            ?>
                                                                    <option <?php echo (isset($client['province']) && $client['province'] == $row['provinceId']) ? 'selected' : ''; ?> value="<?= $row['provinceId'] ?>"><?php echo $row['provinceName']; ?></option>
                                                            <?php

                                                                }
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="edit_district" class="form-label">District</label>
                                                        <select class="form-control" id="edit_district" name="district">
                                                            <option value="">Select Province First</option>
                                                            <?php
                                                            $district = mysqli_query($mysqli, "SELECT district.* from district,province WHERE province.provinceId=district.provinceId");

                                                            $i = 0;
                                                            while ($row = mysqli_fetch_array($district)) {
                                                            ?>
                                                                <option <?php echo (isset($client['district']) && $client['district'] == $row['districtId']) ? 'selected' : ''; ?> value="<?= $row['districtId'] ?>"> <?php echo $row['districtName']; ?></option>
                                                            <?php
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col">
                                                    <div class="mb-3">
                                                        <label for="edit_password" class="form-label">Password</label>
                                                        <input type="password" class="form-control" id="edit_password" name="password" value="<?php echo isset($client['password']) ? $client['password'] : ''; ?>">
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="edit_insurance" class="form-label">Insurance</label>
                                                        <select class="form-control" id="edit_insurance" name="insurance" onchange="toggleEditFieds()">
                                                            <?php while ($insuranceRow = mysqli_fetch_array($insurances)) { ?>
                                                                <option value="<?php echo $insuranceRow['insurance_id']; ?>" <?php echo (isset($client['insurance_id']) && $client['insurance_id'] == $insuranceRow['insurance_id']) ? 'selected' : ''; ?>>
                                                                    <?php echo ucwords($insuranceRow['insurance_name']); ?>
                                                                </option>
                                                            <?php }
                                                            $a++; ?>
                                                        </select>
                                                    </div>

                                                    <div style="display: none;" id="edit_motor">
                                                        <div class="mb-3">
                                                            <label for="edit_license" class="form-label">Driving License <small>(Valid driver's license for the vehicle)</small></label>
                                                            <input type="file" class="form-control" id="edit_license" name="license">
                                                            <?php if (isset($client['driving_license']) && !empty($client['driving_license'])) {
                                                                $licenseFilePath = './../../files/licenses/' . $client['firstname'] . '/' . $client['driving_license'];
                                                                if (file_exists($licenseFilePath)) { ?>
                                                                    <small>Current file: <a href="<?php echo $licenseFilePath; ?>" target="_blank"><?php echo $client['driving_license']; ?></a></small>
                                                                <?php } else { ?>
                                                                    <small class="text-danger">File not found</small>
                                                            <?php }
                                                            } ?>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="edit_plate" class="form-label">Plate Number <small>(Valid plate number for the vehicle)</small></label>
                                                            <input type="text" class="form-control" id="edit_plate" name="plate" value="<?php echo isset($client['plate_number']) ? $client['plate_number'] : ''; ?>">
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="edit_yellow" class="form-label">Yellow Paper <small>(Valid yellow paper for the vehicle)</small></label>
                                                            <input type="file" class="form-control" id="edit_yellow" name="yellow">
                                                            <?php if (isset($client['yellow_paper']) && !empty($client['yellow_paper'])) {
                                                                $yellowFilePath = './../../files/yellows/' . $client['firstname'] . '/' . $client['yellow_paper'];
                                                                if (file_exists($yellowFilePath)) { ?>
                                                                    <small>Current file: <a href="<?php echo $yellowFilePath; ?>" target="_blank"><?php echo $client['yellow_paper']; ?></a></small>
                                                                <?php } else { ?>
                                                                    <small class="text-danger">File not found</small>
                                                            <?php }
                                                            } ?>
                                                        </div>
                                                    </div>

                                                    <div class="mb-3" id="edit_upiDiv" style="display: none;">
                                                        <label for="edit_upi" class="form-label">UPI <small>(Unique Parcel Identifier )</small></label>
                                                        <input type="text" class="form-control" id="edit_upi" name="upi" value="<?php echo isset($client['upi']) ? $client['upi'] : ''; ?>">
                                                    </div>

                                                    <div class="mb-3">
                                                        <label for="edit_startDate" class="form-label">Issue Date <small>( Start date of the insurance )</small></label>
                                                        <input type="date" class="form-control" id="edit_startDate" name="startDate" onchange="validateSDate()" value="<?php echo isset($client['start_date']) ? $client['start_date'] : ''; ?>">
                                                        <div class="invalid-feedback" id="edit_sDateFeedback">Issue date can't be in the past.</div>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="edit_endDate" class="form-label">Expiration Date <small>( End date of the insurance )</small></label>
                                                        <input type="date" class="form-control" id="edit_endDate" name="endDate" onchange="validateEDate()" value="<?php echo isset($client['end_date']) ? $client['end_date'] : ''; ?>">
                                                        <div class="invalid-feedback" id="edit_eDateFeedback">Expiration date can't be in the past.</div>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="edit_bankaccount" class="form-label">Bank account <small>( Bank account different payments )</small></label>
                                                        <input required type="text" class="form-control" id="edit_bankaccount" name="bankaccount" value="<?php echo isset($client['bank_account']) ? $client['bank_account'] : ''; ?>">
                                                    </div>

                                                    <div class="mb-3">
                                                        <label for="edit_income" class="form-label">Proof of Income <small>( Preferably bank slip to support the insurance)</small></label>
                                                        <input type="file" class="form-control" id="edit_income" name="income">
                                                        <?php if (isset($client['proof_of_income']) && !empty($client['proof_of_income'])) {
                                                            $incomeFilePath = './../../files/incomeproofs/' . $client['firstname'] . '/' . $client['proof_of_income'];
                                                            if (file_exists($incomeFilePath)) { ?>
                                                                <small>Current file: <a href="<?php echo $incomeFilePath; ?>" target="_blank"><?php echo $client['proof_of_income']; ?></a></small>
                                                            <?php } else { ?>
                                                                <small class="text-danger">File not found</small>
                                                        <?php }
                                                        } ?>
                                                    </div>

                                                    <div class="mb-3">
                                                        <label for="edit_contract" class="form-label">Contract <small>( Signed agreements of involved parties )</small></label>
                                                        <input type="file" class="form-control" id="edit_contract" name="contract">
                                                        <?php if (isset($client['contract']) && !empty($client['contract'])) {
                                                            $contractFilePath = './../../files/contracts/' . $client['firstname'] . '/' . $client['contract'];
                                                            if (file_exists($contractFilePath)) { ?>
                                                                <small>Current file: <a href="<?php echo $contractFilePath; ?>" target="_blank"><?php echo $client['contract']; ?></a></small>
                                                            <?php } else { ?>
                                                                <small class="text-danger">File not found</small>
                                                        <?php }
                                                        } ?>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="modal-footer">
                                                <button class="btn btn-md btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                                                <button type="submit" id="edit_client" name="edit_client" class="btn btn-md btn-primary">Save Changes</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Delete Client Modal-->
                        <?php
                        if (isset($_POST['deleteClientBtn'])) {
                            $clientId = $mysqli->real_escape_string($_POST['clientId']);
                            $deleteConfirmText = $mysqli->real_escape_string($_POST['deleteConfirmText']);

                            // Validate confirmation text
                            if (strtolower($deleteConfirmText) === 'delete client') {
                                // Delete the client record
                                $deleteSql = "DELETE FROM clients WHERE id_client = '$clientId'";

                                if ($mysqli->query($deleteSql)) {

                                    echo "<script type='text/javascript'>alert('Client deleted successfully!'); window.location.href = window.location.href;</script>";
                                } else {
                                    echo "<script type='text/javascript'>alert('Failed to delete client. Please try again.');</script>";
                                }
                            } else {
                                echo "<script type='text/javascript'>alert('Please type correct confirmation to proceed.');</script>";
                            }
                        }
                        ?>
                        <div class="modal fade" id="deleteClient" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                            aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title text-danger" id="exampleModalLabel">Are you sure you want to remove this client?</h5>
                                        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">×</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form method="POST" action="">
                                            <input type="hidden" name="clientId" id="clientIdInput">
                                            <div class="mb-3">
                                                <label for="deleteConfirmText" class="form-label">Write <strong>delete client</strong> to proceed</label>
                                                <input type="text" class="form-control" id="deleteConfirmText" name="deleteConfirmText" required>
                                            </div>
                                            <div class="modal-footer">
                                                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                                                <button class="btn btn-danger" type="submit" name="deleteClientBtn">Delete</button>
                                            </div>
                                        </form>
                                    </div>
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

    <script>
        $(document).ready(function() {
            $('.edit-client-btn').click(function() {
                var clientId = $(this).data('client-id');
                $('#edit_client_id').val(clientId);
            });

            $('.delete-client-btn').click(function() {
                var clientId = $(this).data('client-id');
                $('#clientIdInput').val(clientId);
            });
        });

        function toggleEditFieds() {
            const insuranceSelect = document.getElementById('edit_insurance');
            const motorDiv = document.getElementById('edit_motor');
            const upiDiv = document.getElementById('edit_upiDiv');

            const selectedInsurance = insuranceSelect.options[insuranceSelect.selectedIndex].text;

            if (selectedInsurance.toLowerCase().includes('motor')) {
                motorDiv.style.display = 'block';
                upiDiv.style.display = 'none';
            } else if (selectedInsurance.toLowerCase().includes('house')) {
                motorDiv.style.display = 'none';
                upiDiv.style.display = 'block';
            } else {
                motorDiv.style.display = 'none';
                upiDiv.style.display = 'none';
            }
        }
    </script>

    <script>
        $(document).ready(function() {
            $('.edit-client-btn').click(function() {
                var clientId = $(this).data('client-id');

                // AJAX request to fetch client data
                $.ajax({
                    url: 'fetch_client.php', // Create this file to handle the request
                    type: 'POST',
                    data: {
                        client_id: clientId
                    },
                    dataType: 'json',
                    success: function(response) {
                        // Populate form fields with client data
                        $('#edit_client_id').val(clientId);
                        $('#edit_firstname').val(response.firstname);
                        $('#edit_lastname').val(response.lastname);
                        $('#edit_phone').val(response.phone);
                        $('#edit_gender').val(response.sex);
                        $('#edit_idno').val(response.ID_no);
                        $('#edit_email').val(response.email);
                        $('#edit_dob').val(response.dob);
                        $('#edit_province').val(response.province);
                        $('#edit_district').val(response.district);
                        $('#edit_insurance').val(response.insurance_id);
                        $('#edit_plate').val(response.plate_number);
                        $('#edit_upi').val(response.upi);
                        $('#edit_startDate').val(response.start_date);
                        $('#edit_endDate').val(response.end_date);
                        $('#edit_bankaccount').val(response.bank_account);

                        // Show/hide conditional fields based on insurance type
                        toggleEditFieds();
                    },
                    error: function(xhr, status, error) {
                        console.error('Error fetching client data:', error);
                        alert('Error loading client data. Please try again.');
                    }
                });
            });
        });
    </script>

</body>

</html>