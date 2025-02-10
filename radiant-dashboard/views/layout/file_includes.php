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
<div class="modal fade" id="addClaim" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <?php
    $insurances = mysqli_query($mysqli, "SELECT * FROM insurance");
    ?>
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Creat new claim</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" action="" enctype="multipart/form-data">

                    <div class="mb-3">
                        <label for="description" class="form-label">Claim description</label>
                        <textarea class="form-control" id="description" rows="3"></textarea>
                    </div>

                    <div class="mb-3 d-flex flex-column">
                        <label for="claimFile" class="form-label">Claim / Accident file</label>
                        <input class="form-control" type="file" id="claimFile">
                    </div>

                    <div class="mb-3">
                        <label for="insurance" class="form-label">Insurance</label>
                        <select class="form-control" id="insurancee" name="insurance" onchange="togglePlateNumber()">
                            <?php while ($insuranceRow = mysqli_fetch_array($insurances)) { ?>
                                <option value="<?php echo $insuranceRow['insurance_id']; ?>">
                                    <?php echo $insuranceRow['insurance_name']; ?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="property" class="form-label">Select you property</label>
                        <select class="form-control" id="property" name="property">
                            <option value="default property">
                                Select your property
                            </option>
                        </select>
                    </div>

                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                        <button class="btn btn-primary" type="submit" name="sendClaim">Send Claim</button>
                        <!-- <input type="submit" value="submit" name="saveInsurance"> -->
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Add Insurance Modal-->
<div class="modal fade" id="addInsurance" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <?php

    if (isset($_POST['saveInsurance'])) {
        $insuranceName = $mysqli->real_escape_string($_POST['InsuranceName']);

        $saveInsuranceQuery = $mysqli->mysqli_query("INSERT INTO insurance VALUES (NULL, '$insuranceName')");

        echo "<div class='toast' role='alert' aria-live='assertive' aria-atomic='true'>
                <div class='toast-header'>
                    <strong class='me-auto'>Bootstrap</strong>
                    <small>11 mins ago</small>
                    <button type='button' class='btn-close' data-bs-dismiss='toast' aria-label='Close'></button>
                </div>
                <div class='toast-body'>
                    Hello, world! This is a toast message.
                </div>
            </div>";
    }

    ?>
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Creat new insurance?</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" action="" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="InsuranceName" class="form-label">Insurance Name</label>
                        <input type="text" class="form-control" id="InsuranceName" name="InsuranceName">
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                        <button class="btn btn-primary" type="submit" name="saveInsurance">Submit</button>
                        <!-- <input type="submit" value="submit" name="saveInsurance"> -->
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</div>

<!-- Register client Modal-->
<?php
$insurances = mysqli_query($mysqli, "SELECT * FROM insurance");
$provinces = mysqli_query($mysqli, "SELECT * FROM province");

$i = 0;

// Register Client
// if (isset($_POST['save_client'])) {

//     $insurance = $mysqli->real_escape_string($_POST['insurance']);
//     $empId = $_SESSION['employeeid'];
//     $a = $mysqli->real_escape_string($_POST['firstname']);
//     $b = $mysqli->real_escape_string($_POST['lastname']);
//     $c = $mysqli->real_escape_string($_POST['password']);
//     $d = $mysqli->real_escape_string($_POST['email']);
//     $e = $mysqli->real_escape_string($_POST['idno']);
//     $f = $mysqli->real_escape_string($_POST['gender']);
//     $g = $mysqli->real_escape_string($_POST['dob']);
//     $h = $mysqli->real_escape_string($_POST['district']);
//     $i = $mysqli->real_escape_string($_POST['province']);
//     $j = $mysqli->real_escape_string($_POST['phone']);
//     $k = $mysqli->real_escape_string($_POST['bankaccount']);

//     $m = $mysqli->real_escape_string($_POST['plate']);
//     $q = $mysqli->real_escape_string($_POST['startDate']);
//     $r = $mysqli->real_escape_string($_POST['endDate']);
//     $today = new DateTime();

//     // Fix directory paths - remove backslashes and trailing spaces
//     $upload_dirs = [
//         'licenses' => './files/licenses/',
//         'yellows' => './files/yellows/',
//         'incomeproofs' => './files/incomeproofs/',
//         'contracts' => './files/contracts/'
//     ];

//     // Create directories if they don't exist
//     foreach ($upload_dirs as $dir) {
//         if (!is_dir($dir)) {
//             mkdir($dir, 0755, true);
//         }
//     }

//     // Sanitize filenames
//     $l = time() . '_' . preg_replace('/[^A-Za-z0-9\-._]/', '', $_FILES['license']['name']);
//     $n = time() . '_' . preg_replace('/[^A-Za-z0-9\-._]/', '', $_FILES['yellow']['name']);
//     $o = time() . '_' . preg_replace('/[^A-Za-z0-9\-._]/', '', $_FILES['income']['name']);
//     $p = time() . '_' . preg_replace('/[^A-Za-z0-9\-._]/', '', $_FILES['contract']['name']);

//     // Attempt to move all files
//     $result = true;
//     $result = true;
//     if (!empty($_FILES['license']['tmp_name'])) {
//         $result = $result && move_uploaded_file(
//             $_FILES['license']['tmp_name'],
//             $upload_dirs['licenses'] . $l
//         );
//     }
//     if (!empty($_FILES['yellow']['tmp_name'])) {
//         $result = $result && move_uploaded_file(
//             $_FILES['yellow']['tmp_name'],
//             $upload_dirs['yellows'] . $n
//         );
//     }
//     if (!empty($_FILES['income']['tmp_name'])) {
//         $result = $result && move_uploaded_file(
//             $_FILES['income']['tmp_name'],
//             $upload_dirs['incomeproofs'] . $o
//         );
//     }
//     if (!empty($_FILES['contract']['tmp_name'])) {
//         $result = $result && move_uploaded_file(
//             $_FILES['contract']['tmp_name'],
//             $upload_dirs['contracts'] . $p
//         );
//     }

//     $insertSql = "INSERT INTO clients(id_client, firstname, lastname, password, email, ID_no, sex, dob, district, province, phone, bank_account, driving_license, yellow_paper, plate_number, proof_of_income, contract, start_date, end_date, username, emp_id, insurance_id) VALUES (NULL, '$a', '$b', '$c', '$d', '$e', '$f','$g', '$h', '$i', '$j','$k','$l', '$m', '$n', '$o', '$p', '$q', '$r' ,'$a', '$empId', $insurance)";

//     $query = $mysqli->query("SELECT * FROM clients WHERE email='$d' OR phone='$j' OR ID_no='$e' OR bank_account='$k' ") or die($mysqli->error);

//     if (mysqli_num_rows($query) > 0) {

//         echo "<script type='text/javascript'>alert('Duplicate entry found');</script>";
//     } else if (empty($insurance) || empty($a) || empty($b) || empty($c) || empty($d) || empty($e) || empty($f) || empty($g) || empty($h) || empty($i) || empty($j) || empty($k) || empty($o) || empty($p) || empty($q) || empty($r)) {

//         echo "<script type='text/javascript'>alert('Please fill in required fields');</script>";
//     } else if ($q < $today || $r < $q) {

//         echo "<script type='text/javascript'>alert('Start date can't be in past and End date should be greater than start date ');</script>";
//     } else if ($g > date("Y-m-d", (time() - (18 * 365 * 24 * 60 * 60)))) {

//         echo "<script type='text/javascript'>alert('Only People above 18 years old are allowed to have vehicles');</script>";
//     } else {

//         // Move uploaded files 
//         if ($result) {

//             echo "The files " . htmlspecialchars($l) . "and" . htmlspecialchars($n) . " and " . htmlspecialchars($o) . "and" . htmlspecialchars($n) . " have been uploaded .";

//             $insert = mysqli_query($mysqli, $insertSql) or die(mysqli_error($mysqli));

//             if ($insert) {
//                 $_SESSION['clientregistration'] = mysqli_insert_id($mysqli);
//                 echo "<script type='text/javascript'>alert('Client have been successfully registerd and Insured!');

//     		window.location='initsession.php?clid=" . mysqli_insert_id($mysqli) . "';
//     		</script>";
//             } else {
//                 echo "<script type='text/javascript'>alert('Failed to save client due to insert errors');</script>";
//             }
//         } else {
//             echo "<script type='text/javascript'>alert('Sorry, there was an error uploading your files');</script>";

//         }
//     }
// }

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
    $plate = $mysqli->real_escape_string($_POST['plate']);
    $startDate = $mysqli->real_escape_string($_POST['startDate']);
    $endDate = $mysqli->real_escape_string($_POST['endDate']);
    $today = new DateTime();

    // Define upload directories
    $upload_dirs = [
        'licenses' => './../../files/licenses/',
        'yellows' => './../../files/yellows/',
        'incomeproofs' => './../../../files/incomeproofs/',
        'contracts' => './../../files/contracts/'
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

    // Check for duplicate entries
    $query = $mysqli->query("SELECT * FROM clients WHERE email='$email' OR phone='$phone' OR ID_no='$idno' OR bank_account='$bankaccount'") or die($mysqli->error);

    if (mysqli_num_rows($query) > 0) {
        echo "<script type='text/javascript'>alert('Duplicate entry found');</script>";
    } elseif (empty($insurance) || empty($firstname) || empty($lastname) || empty($password) || empty($email) || empty($idno) || empty($gender) || empty($dob) || empty($district) || empty($province) || empty($phone) || empty($bankaccount) || empty($incomeFile) || empty($contractFile) || empty($startDate) || empty($endDate)) {
        echo "<script type='text/javascript'>alert('Please fill in required fields');</script>";
    } elseif ($dob > date("Y-m-d", (time() - (18 * 365 * 24 * 60 * 60)))) {
        echo "<script type='text/javascript'>alert('Only people above 18 years old are allowed to have vehicles');</script>";
    } else {
        // Insert client data into the database
        $insertSql = "INSERT INTO clients (id_client, firstname, lastname, password, email, ID_no, sex, dob, district, province, phone, bank_account, driving_license, yellow_paper, plate_number, proof_of_income, contract, start_date, end_date, username, emp_id, insurance_id) 
                      VALUES (NULL, '$firstname', '$lastname', '$password', '$email', '$idno', '$gender', '$dob', '$district', '$province', '$phone', '$bankaccount', '$licenseFile', '$yellowFile', '$plate', '$incomeFile', '$contractFile', '$startDate', '$endDate', '$firstname', '$empId', $insurance)";

        $insert = $mysqli->query($insertSql) or die($mysqli->error);

        if ($insert) {
            $_SESSION['clientregistration'] = $mysqli->insert_id;
            echo "<script type='text/javascript'>alert('Client has been successfully registered and insured!');
                  window.location='initsession.php?clid=" . $mysqli->insert_id . "';
                  </script>";
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
                                <input type="phone" class="form-control" id="phone" name="phone">
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
                                <input type="text" class="form-control" id="idno" name="idno">
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
                                <select class="form-control" id="insurance" name="insurance" onchange="togglePlateNumber()">
                                    <?php while ($insuranceRow = mysqli_fetch_array($insurances)) { ?>
                                        <option value="<?php echo $insuranceRow['insurance_id']; ?>">
                                            <?php echo $insuranceRow['insurance_name']; ?>
                                        </option>
                                    <?php }
                                    $a++; ?>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="startDate" class="form-label">Issue Date</label>
                                <input type="date" class="form-control" id="startDate" name="startDate" onchange="validateSDate()">
                                <div class="invalid-feedback" id="sDateFeedback">Issue date can't be in the past.</div>
                            </div>
                            <div class="mb-3">
                                <label for="endDate" class="form-label">Expiration Date</label>
                                <input type="date" class="form-control" id="endDate" name="endDate" onchange="validateEDate()">
                                <div class="invalid-feedback" id="eDateFeedback">Expiration date can't be in the past.</div>
                            </div>
                            <div class="mb-3">
                                <label for="bankaccount" class="form-label">Bank account</label>
                                <input required type="text" class="form-control" id="bankaccount" name="bankaccount">
                            </div>

                            <div style="display: none;" id="motor">
                                <div class="mb-3">
                                    <label for="license" class="form-label">Driving license</label>
                                    <input type="file" class="form-control" id="license" name="license">
                                </div>
                                <div class="mb-3">
                                    <label for="plate" class="form-label">Plate Number</label>
                                    <input type="text" class="form-control" id="plate" name="plate">
                                </div>
                                <div class="mb-3">
                                    <label for="yellow" class="form-label">Yellow Paper</label>
                                    <input type="file" class="form-control" id="yellow" name="yellow">
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="income" class="form-label">Proof of Income</label>
                                <input required type="file" class="form-control" id="income" name="income">
                            </div>

                            <div class="mb-3">
                                <label for="contract" class="form-label">Contract</label>
                                <input required type="file" class="form-control" id="contract" name="contract">
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button class="btn btn-md btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                        <button type="submit" id="save_client" name="save_client" class="btn btn-md btn-primary">Create</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    function validateSDate() {
        const sDateInput = document.getElementById('startDate');
        const sDateFeedback = document.getElementById('sDateFeedback');
        const submitBtn = document.getElementById('save_client');
        var today = new Date();
        const sDateValue = new Date(sDateInput.value);
        var monthDifference = sDateValue.getMonth() - today.getMonth() +
            (12 * (sDateValue.getFullYear() - today.getFullYear()));

        if (monthDifference < 0 || (monthDifference === 0 && today.getDate() < sDateValue.getDate())) {
            sDateInput.classList.remove('is-invalid');
            sDateFeedback.style.display = 'none';
        } else {
            sDateInput.classList.add('is-invalid');
            sDateFeedback.style.display = 'block';
        }
    }

    function validateEDate() {
        const eDateInput = document.getElementById('endDate');
        const eDateFeedback = document.getElementById('eDateFeedback');
        const submitBtn = document.getElementById('save_client');
        const eDateValue = new Date(eDateInput.value);
        var today = new Date();
        var monthDifference = eDateValue.getMonth() - today.getMonth() +
            (12 * (eDateValue.getFullYear() - today.getFullYear()));

        if (monthDifference < 0 || (monthDifference === 0 && today.getDate() < eDateValue.getDate())) {
            eDateInput.classList.remove('is-invalid');
            eDateFeedback.style.display = 'none';
        } else {
            eDateInput.classList.add('is-invalid');
            eDateFeedback.style.display = 'block';
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

    function togglePlateNumber() {
        const insuranceSelect = document.getElementById('insurance');
        const motorDiv = document.getElementById('motor');
        const selectedInsurance = insuranceSelect.options[insuranceSelect.selectedIndex].text;

        if (selectedInsurance.toLowerCase().includes('motor')) {
            motorDiv.style.display = 'block';
        } else {
            motorDiv.style.display = 'none';
        }
    }
</script>

<!-- Bootstrap core JavaScript-->
<script src="../vendor/jquery/jquery.min.js"></script>
<script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

<!-- Core plugin JavaScript-->
<script src="../vendor/jquery-easing/jquery.easing.min.js"></script>

<script>
    $(document).ready(function() {
        $('select[name="province"]').change(function() {
            var province = $(this).val();

            $("#district").load("../../../ajax/loadprovince.php?province=" + province);
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