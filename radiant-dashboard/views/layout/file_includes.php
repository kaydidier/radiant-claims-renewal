<?php
// include "../../includes/utils/sms.php";

if (isset($_SESSION['clientid'])) {
    $clientQuery = $mysqli->query("SELECT * FROM clients WHERE id_client = " . $_SESSION['clientid']);
    $clientData = $clientQuery->fetch_array(MYSQLI_ASSOC);
    $firstnameUser = $clientData['firstname'];
    $lastnameUser = $clientData['lastname'];
    $phoneUser = $clientData['phone'];
}
?>
<!-- Scroll to Top Button-->
<a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
</a>

<!-- Logout Modal-->
<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                <a class="btn btn-primary" href="../../logout.php">Logout</a>
            </div>
        </div>
    </div>
</div>

<!-- Add claim Modal-->
<?php
if (isset($_SESSION['clientid'])) {
    $clientId = $_SESSION['clientid'];

    // Get logged in client insurances
    $insurances = $mysqli->query("SELECT clients.insurance_id, id_client, firstname, insurance_name FROM clients LEFT JOIN insurance ON clients.insurance_id = insurance.insurance_id WHERE id_client = " . $clientId);

    // Get logged in client data
    $userSql = $mysqli->query("SELECT * FROM clients WHERE id_client = " . $clientId);

    $fetch = $userSql->fetch_array(MYSQLI_ASSOC);
    $firstname = $fetch['firstname'];

    if (isset($_POST['createClaim'])) {
        // Sanitize and validate input data
        $insurance = $mysqli->real_escape_string($_POST['insuranceClaims']);
        $plate = $mysqli->real_escape_string($_POST['plateClaim']);
        $nid = $fetch['ID_no'];
        $comments = $mysqli->real_escape_string($_POST['claimComments']);
        $bId = $mysqli->real_escape_string($_POST['buildingClaimId']);
        $upi = $mysqli->real_escape_string($_POST['upiClaimInput']);
        $status = 'pending';
        $claimTime = date('Y-m-d H:i', time());

        // Define upload directories
        $upload_dirs = [
            'licenses' => './../../files/licenses/' . strtolower($firstname) . '/',
            'yellows' => './../../files/yellows/' . strtolower($firstname) . '/',
            'police' => './../../files/police/' . strtolower($firstname) . '/',
            'support' => './../../files/support/' . strtolower($firstname) . '/'
        ];

        // Create directories if they don't exist
        foreach ($upload_dirs as $dir) {
            if (!is_dir($dir)) {
                mkdir($dir, 0755, true);
            }
        }

        // Sanitize filenames
        $licenseFile = time() . '_' . preg_replace('/[^A-Za-z0-9\-._]/', '', $_FILES['driversLicenseFile']['name']);
        $yellowFile = time() . '_' . preg_replace('/[^A-Za-z0-9\-._]/', '', $_FILES['yellowFile']['name']);
        $policeFile = time() . '_' . preg_replace('/[^A-Za-z0-9\-._]/', '', $_FILES['policeFile']['name']);
        $supportFile = time() . '_' . preg_replace('/[^A-Za-z0-9\-._]/', '', $_FILES['claimSupportFile']['name']);

        // Move uploaded files
        $result = true;
        $uploadedFiles = [];

        if (empty($insurance) || empty($nid) || empty($comments) || empty($supportFile)) {
            echo "<script type='text/javascript'>alert('Please fill in required fields');</script>";
        } else {
            // Move files to dirs
            if (!empty($_FILES['claimSupportFile']['tmp_name'])) {
                $result = $result && move_uploaded_file($_FILES['claimSupportFile']['tmp_name'], $upload_dirs['support'] . $supportFile);
                $uploadedFiles[] = $supportFile;
            }
            if (!empty($_FILES['yellowFile']['tmp_name'])) {
                $result = $result && move_uploaded_file($_FILES['yellowFile']['tmp_name'], $upload_dirs['yellows'] . $yellowFile);
                $uploadedFiles[] = $yellowFile;
            }
            if (!empty($_FILES['driversLicenseFile']['tmp_name'])) {
                $result = $result && move_uploaded_file($_FILES['driversLicenseFile']['tmp_name'], $upload_dirs['licenses'] . $licenseFile);
                $uploadedFiles[] = $licenseFile;
            }
            if (!empty($_FILES['policeFile']['tmp_name'])) {
                $result = $result && move_uploaded_file($_FILES['policeFile']['tmp_name'], $upload_dirs['police'] . $policeFile);
                $uploadedFiles[] = $policeFile;
            }

            $updateFields = array();
            if (!empty($licenseFile)) $updateFields[] = "driving_license='$licenseFile'";
            if (!empty($yellowFile)) $updateFields[] = "yellow_paper='$yellowFile'";
            if (!empty($upi)) $updateFields[] = "upi='$upi'";
            if (!empty($bId)) $updateFields[] = "building_number='$bId'";
            if (!empty($plate)) $updateFields[] = "plate_number='$plate'";
            if (!empty($nid)) $updateFields[] = "ID_no='$nid'";

            // Insert client data into the database
            $insertSql = "INSERT INTO claim (id_client, insurance_id, claim_time, comments, police_file, support_file, status, date_filed) VALUES( '$clientId', '$insurance', '$claimTime', '$comments', " . ($policeFile ? "'$policeFile'" : "NULL") . ", '$supportFile', '$status', NOW()) ";
            
            $updateSql = "UPDATE clients SET " . implode(", ", $updateFields) . " WHERE insurance_id = '$insurance' AND id_client = '$clientId'";

            $insert = $mysqli->query($insertSql) or die($mysqli->error);
            $update = $mysqli->query($updateSql) or die($mysqli->error);

            if ($insert && $update) {

                $smsResult = sendSMS(
                    $phoneUser,
                    "Hello, " . $firstnameUser . " " . $lastnameUser . " your insurance claim has been sent."
                );

                echo "<script type='text/javascript'>alert('Claim has been sent successfully!');
                window.location.href = window.location.href;
                      </script>";
            } else {
                echo "<script type='text/javascript'>alert('Failed to send claim');</script>";
            }
        }
    }

?>
    <div class="modal fade" id="addClaim" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Create new claim <?php echo $firstname ?></h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="" enctype="multipart/form-data">

                        <div class="mb-3">
                            <label for="insuranceClaims" class="form-label">Insurance</label>
                            <select class="form-control" id="insuranceClaims" name="insuranceClaims" onchange="toggleClaimsFieds()" required>
                                <?php while ($insuranceRow = mysqli_fetch_array($insurances)) { ?>
                                    <option value="<?php echo $insuranceRow['insurance_id']; ?>">
                                        <?php echo $insuranceRow['insurance_name']; ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </div>

                        <div class="mb-3 d-flex flex-column">
                            <label for="claimSupportFile" class="form-label">Supporting documents <small>Photos of the accident, Etc </small></label>
                            <input class="form-control" type="file" id="claimSupportFile" name="claimSupportFile">
                        </div>

                        <div id="motorClaims" style="display: none;">

                            <div class="mb-3 d-flex flex-column">
                                <label for="policeFile" class="form-label">Police documents <small>Police Abstract Report </small></label>
                                <input class="form-control" type="file" id="policeFile" name="policeFile" value="<?php echo $fetch['police_file'] ?>">
                            </div>

                            <div class="mb-3 d-flex flex-column">
                                <label for="driversLicenseFile" class="form-label">Copy of the Driver’s Driving License </label>
                                <input class="form-control" type="file" id="driversLicenseFile" name="driversLicenseFile" value="<?php echo $fetch['driving_license'] ?>">
                            </div>

                            <div class="mb-3 d-flex flex-column">
                                <label for="yellowFile" class="form-label">Yellow paper</label>
                                <input class="form-control" type="file" id="yellowFile" name="yellowFile" value="<?php echo $fetch['yellow_paper'] ?>">
                            </div>


                            <div class="mb-3">
                                <label for="plateClaim" class="form-label">Plate number</label>
                                <input type="text" class="form-control" id="plateClaim" name="plateClaim" rows="3" value="<?php echo $fetch['plate_number'] ?>" />
                            </div>

                        </div>

                        <div id="houseClaims" style="display: none;">

                            <div class="mb-3">
                                <label for="upiClaimInput" class="form-label">UPI <small>(Unique Parcel Identifier )</small></label>
                                <input type="text" class="form-control" id="upiClaimInput" name="upiClaimInput" value="<?php echo $fetch['upi'] ?>">
                            </div>

                            <div class="mb-3">
                                <label for="buildingClaimId" class="form-label">ID of the building</label>
                                <input type="text" class="form-control" id="buildingClaimId" name="buildingClaimId" value="<?php echo $fetch['building_number'] ?>">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="nidClaim" class="form-label">NID number</label>
                            <input type="text" class="form-control" id="nidClaim" name="nidClaim" rows="3" value="<?php echo $fetch['ID_no'] ?>" disabled />
                        </div>

                        <div class="mb-3">
                            <label for="claimComments" class="form-label">Comments</label>
                            <textarea class="form-control" id="claimComments" name="claimComments" rows="3" required></textarea>
                        </div>
                </div>



                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <button class="btn btn-primary" type="submit" name="createClaim">Send Claim</button>
                </div>
                </form>
            </div>
        </div>
    </div>
    </div>
<?php  } ?>

<!-- Add Insurance Modal-->
<?php

if (isset($_POST['saveInsurance'])) {
    $insuranceName = $mysqli->real_escape_string(strtolower($_POST['InsuranceName']));

    // Check if insurance already exists
    $existingInsurance = $mysqli->query("SELECT * FROM insurance WHERE insurance_name='$insuranceName'");

    if ($existingInsurance->num_rows > 0) {
        echo "<script type='text/javascript'>alert('Insurance with this name already exists!');</script>";
    } else {
        $saveInsuranceQuery = $mysqli->query("INSERT INTO insurance VALUES (NULL, '$insuranceName')");

        if ($saveInsuranceQuery) {
            echo "<script type='text/javascript'>alert('New insurance created successfully'); window.location.href = window.location.href;</script>";
        } else {
            echo "<script type='text/javascript'>alert('Failed to create insurance. Please try again.');</script>";
        }
    }
}

?>
<div class="modal fade" id="addInsurance" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Create new insurance</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" action="" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="InsuranceName" class="form-label">Insurance Name</label>
                        <input type="text" class="form-control" id="InsuranceName" name="InsuranceName" required>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                        <button class="btn btn-primary" type="submit" name="saveInsurance">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Register client Modal-->
<?php
$insurances = mysqli_query($mysqli, "SELECT * FROM insurance");
$provinces = mysqli_query($mysqli, "SELECT * FROM province");

$i = 0;

if (isset($_POST['save_client'])) {
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
    $bankname = $mysqli->real_escape_string($_POST['bankname']);
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
    $licenseFile = time() . '_' . preg_replace('/[^A-Za-z0-9\-._]/', '', $_FILES['license']['name']);
    $yellowFile = time() . '_' . preg_replace('/[^A-Za-z0-9\-._]/', '', $_FILES['yellow']['name']);
    $incomeFile = time() . '_' . preg_replace('/[^A-Za-z0-9\-._]/', '', $_FILES['income']['name']);
    $contractFile = time() . '_' . preg_replace('/[^A-Za-z0-9\-._]/', '', $_FILES['contract']['name']);

    // Move uploaded files
    $result = true;
    $uploadedFiles = [];

    // Check for duplicate entries
    $query = $mysqli->query("SELECT * FROM clients WHERE email='$email' OR phone='$phone' OR ID_no='$idno' OR bank_account='$bankaccount'") or die($mysqli->error);

    if (mysqli_num_rows($query) > 0) {
        echo "<script type='text/javascript'>alert('Duplicate entry found');</script>";
    } elseif (empty($insurance) || empty($firstname) || empty($lastname) || empty($password) || empty($email) || empty($idno) || empty($gender) || empty($dob) || empty($district) || empty($province) || empty($phone) || empty($bankaccount) || empty($incomeFile) || empty($contractFile) || empty($startDate) || empty($endDate)) {
        echo "<script type='text/javascript'>alert('Please fill in required fields');</script>";
    } elseif ($dob > date("Y-m-d", (time() - (18 * 365 * 24 * 60 * 60)))) {
        echo "<script type='text/javascript'>alert('Only people above 18 years old are allowed to have vehicles');</script>";
    } else {

        // Move files to dirs
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

        // Insert client data into the database
        $insertSql = "INSERT INTO clients (id_client, firstname, lastname, password, email, ID_no, sex, dob, district, province, phone, bank_account, bankname, driving_license, yellow_paper, plate_number, upi, proof_of_income, contract, start_date, end_date, username, emp_id, insurance_id, created_at) 
                        VALUES (NULL, '$firstname', '$lastname', '$password', '$email', '$idno', '$gender', '$dob', '$district', '$province', '$phone', '$bankaccount', '$bankname', '$licenseFile', '$yellowFile', '$plate', '$house', '$incomeFile', '$contractFile', '$startDate', '$endDate', '$firstname', '$empId', '$insurance', NOW())";

        $insert = $mysqli->query($insertSql) or die($mysqli->error);

        if ($insert) {

            $smsResult = sendSMS(
                $phone,
                "Hello, " . $firstname . " " . $lastname . "Welcome to Radiant Insurance. Your account has been created successfully. You can now login to your account using Username: " . $firstname . " and Password: " . $password . " to manage your insurance claims and renewals."
            );
            echo "<script type='text/javascript'>alert('Client has been registered and insured successfully!');
            window.location.href = window.location.href;
                  </script>";
            //   window.location='initsession.php?clid=" . $mysqli->insert_id . "';
        } else {
            echo "<script type='text/javascript'>alert('Failed to save client due to insert errors');</script>";
        }
    }
}

?>

<div class="modal fade" id="addClient" tabindex="-1" role="dialog" aria-labelledby="clientModalLabel"
    aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add new client</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" enctype="multipart/form-data" class="col">
                    <div class="row">
                        <div class="col">
                            <div class="mb-3">
                                <label for="firstname" class="form-label">Firstname</label>
                                <input type="text" class="form-control" id="firstname" name="firstname">
                            </div>
                            <div class="mb-3">
                                <label for="lastname" class="form-label">Lastname</label>
                                <input type="text" class="form-control" id="lastname" name="lastname">
                            </div>
                            <div class="mb-3">
                                <label for="phone" class="form-label">Phone number</label>
                                <input type="phone" class="form-control" id="phone" name="phone" maxlength="10">
                            </div>
                            <div class="mb-3">
                                <label for="gender" class="form-label">Gender</label>
                                <select class="form-control" id="gender" name="gender">
                                    <option value="male">Male</option>
                                    <option value="female">Female</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="idno" class="form-label">ID number</label>
                                <input type="text" class="form-control" id="idno" name="idno" maxlength="16">
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email address</label>
                                <input type="email" class="form-control" id="email" name="email">
                            </div>
                            <div class="mb-3">
                                <label for="dob" class="form-label">Date of Birth</label>
                                <input type="date" class="form-control" id="dob" name="dob" onchange="validateDOB()">
                                <div class="invalid-feedback" id="dobFeedback">You must be over 18 years old.</div>
                            </div>
                            <div class="mb-3">
                                <label for="province" class="form-label">Province</label>
                                <select class="form-control" id="province" name="province">
                                    <?php
                                    $province = mysqli_query($mysqli, "SELECT * from province");

                                    $i = 0;
                                    while ($row = mysqli_fetch_array($province)) { {
                                            $i++;
                                            if ($i == 1) {
                                                $initialProvince = $row['provinceId'];
                                            }

                                    ?>
                                            <option <?= @$_POST['province'] == $row['provinceId'] ? "selected" : "" ?> value="<?= $row['provinceId'] ?>"><?php echo $row['provinceName']; ?></option>
                                    <?php

                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="district" class="form-label">District</label>
                                <select class="form-control" id="district" name="district">
                                    <option value="">Select Province First</option>
                                    <?php
                                    $district = mysqli_query($mysqli, "SELECT district.* from district,province WHERE province.provinceId=district.provinceId and district.provinceId='$initialProvince'");

                                    $i = 0;
                                    while ($row = mysqli_fetch_array($district)) {


                                    ?>
                                        <option <?= @$_POST['district'] == $row['districtId'] ? "selected" : "" ?> value="<?= $row['districtId'] ?>"> <?php echo $row['districtName']; ?></option>
                                    <?php

                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="col">
                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" class="form-control" id="password" name="password">
                            </div>
                            <div class="mb-3">
                                <label for="insurance" class="form-label">Insurance</label>
                                <select class="form-control" id="insurance" name="insurance" onchange="toggleFieds()">
                                    <?php while ($insuranceRow = mysqli_fetch_array($insurances)) { ?>
                                        <option value="<?php echo $insuranceRow['insurance_id']; ?>">
                                            <?php echo ucwords($insuranceRow['insurance_name']); ?>
                                        </option>
                                    <?php }
                                    $a++; ?>
                                </select>
                            </div>

                            <div style="display: none;" id="motor">
                                <div class="mb-3">
                                    <label for="license" class="form-label">Driving license <small>( Valid drivers license for the vihicle)</small> </label>
                                    <input type="file" class="form-control" id="license" name="license">
                                </div>
                                <div class="mb-3">
                                    <label for="plate" class="form-label">Plate Number <small>( Valid plate number for the vihicle)</small></label>
                                    <input type="text" class="form-control" id="plate" name="plate">
                                </div>
                                <div class="mb-3">
                                    <label for="yellow" class="form-label">Yellow Paper <small>( Valid yellow paper for the vihicle)</small></label>
                                    <input type="file" class="form-control" id="yellow" name="yellow">
                                </div>
                            </div>

                            <div class="mb-3" id="upiDiv" style="display: none;">
                                <label for="upi" class="form-label">UPI <small>(Unique Parcel Identifier )</small></label>
                                <input type="text" class="form-control" id="upi" name="upi">
                            </div>

                            <div class="mb-3">
                                <label for="startDate" class="form-label">Issue Date <small>( Start date of the insurance )</small></label>
                                <input type="date" class="form-control" id="startDate" name="startDate">
                                <div class="invalid-feedback" id="sDateFeedback">Issue date can't be in the past.</div>
                            </div>
                            <div class="mb-3">
                                <label for="endDate" class="form-label">Expiration Date <small>( End date of the insurance )</small></label>
                                <input type="date" class="form-control" id="endDate" name="endDate">
                                <div class="invalid-feedback" id="eDateFeedback">Expiration date can't be in the past.</div>
                            </div>

                            <div class="mb-3">
                                <label for="bankname" class="form-label">Bank name</label>
                                <input required type="text" class="form-control" id="bankname" name="bankname">
                            </div>

                            <div class="mb-3">
                                <label for="bankaccount" class="form-label">Bank account <small>( Bank account different payments )</small></label>
                                <input required type="text" class="form-control" id="bankaccount" name="bankaccount">
                            </div>

                            <div class="mb-3">
                                <label for="income" class="form-label">Proof of payment <small>( Preferably bank slip to support the insurance)</small></label>
                                <input required type="file" class="form-control" id="income" name="income">
                            </div>

                            <div class="mb-3">
                                <label for="contract" class="form-label">Contract <small>( Signed agreements of involved parties )</small></label>
                                <input required type="file" class="form-control" id="contract" name="contract">
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button class="btn btn-md btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                        <button type="submit" id="save_client" name="save_client" class="btn btn-md btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    const eDateInput = document.getElementById('endDate');
const sDateInput = document.getElementById('startDate');
const eDateFeedback = document.getElementById('eDateFeedback');
const submitBtn = document.getElementById('save_client');

sDateInput.addEventListener('change', validateDates);
eDateInput.addEventListener('change', validateDates);


    function validateDates() {
    const sDateValue = new Date(sDateInput.value);
    const eDateValue = new Date(eDateInput.value);

    if (eDateValue > sDateValue) {
        eDateInput.classList.remove('is-invalid');
        eDateFeedback.style.display = 'none';
        submitBtn.disabled = false; // Enable the submit button
    } else {
        eDateInput.classList.add('is-invalid');
        eDateFeedback.style.display = 'block';
        eDateFeedback.innerText = 'End date must be after the start date.';
        submitBtn.disabled = true; // Disable the submit button
    }
}

    // Validating date of birth when registering a client 
    function validateDOB() {
        const dobInput = document.getElementById('dob');
        const dobFeedback = document.getElementById('dobFeedback');
        const submitBtn = document.getElementById('save_client');
        const dobValue = new Date(dobInput.value);
        const today = new Date();
        const age = today.getFullYear() - dobValue.getFullYear();
        const monthDifference = today.getMonth() - dobValue.getMonth();

        if (monthDifference < 0 || (monthDifference === 0 && today.getDate() < dobValue.getDate())) {
            age--;
        }

        if (age < 18) {
            dobInput.classList.add('is-invalid');
            dobFeedback.style.display = 'block';
            // submitBtn.disabled = true;
        } else {
            // submitBtn.disabled = false;
            dobInput.classList.remove('is-invalid');
            dobFeedback.style.display = 'none';
        }
    }

    function toggleFieds() {
        const insuranceSelect = document.getElementById('insurance');
        const motorDiv = document.getElementById('motor');
        const upiDiv = document.getElementById('upiDiv');
        const selectedInsurance = insuranceSelect.options[insuranceSelect.selectedIndex].text;

        if (selectedInsurance.toLowerCase().includes('motor')) {
            motorDiv.style.display = 'block';
            upiDiv.style.display = 'none';
        } else if (selectedInsurance.toLowerCase().includes('house')) {
            upiDiv.style.display = 'block';
            motorDiv.style.display = 'none';
        } else {
            motorDiv.style.display = 'none';
            upiDiv.style.display = 'none';
        }
    }

    function toggleClaimsFieds() {

        const insuranceClaimsSelect = document.getElementById('insuranceClaims');
        const motorClaimsDiv = document.getElementById('motorClaims');
        const upiClaimsDiv = document.getElementById('houseClaims');

        const selectedInsurance = insuranceClaimsSelect.options[insuranceClaimsSelect.selectedIndex].text;

        if (selectedInsurance.toLowerCase().includes('motor')) {
            motorClaimsDiv.style.display = 'block';
            upiClaimsDiv.style.display = 'none';
        } else if (selectedInsurance.toLowerCase().includes('house')) {
            motorClaimsDiv.style.display = 'none';
            upiClaimsDiv.style.display = 'block';
        } else {
            motorClaimsDiv.style.display = 'none';
            upiClaimsDiv.style.display = 'none';
        }
    }
</script>

<!-- Bootstrap core JavaScript-->
<script src="../vendor/jquery/jquery.min.js"></script>
<script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

<!-- Core plugin JavaScript-->
<script src="../vendor/jquery-easing/jquery.easing.min.js"></script>

<script>
    $(document).ready(function () {
    $('select[name="province"]').change(function () {
        var province = $(this).val();

        $.get("/radiant-claims-renewal/ajax/loadprovince.php", { province: province }, function (data) {
            $("#district").html(data);
        });
    });
});

</script>

<!-- Page level plugins -->
<script src="../vendor/datatables/jquery.dataTables.min.js"></script>
<script src="../vendor/datatables/dataTables.bootstrap4.min.js"></script>

<!-- Page level custom scripts -->
<script src="../js/demo/datatables-demo.js"></script>

<!-- Custom scripts for all pages-->
<script src="../js/sb-admin-2.min.js"></script>