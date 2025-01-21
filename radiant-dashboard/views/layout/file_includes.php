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

?>

<div class="modal fade" id="addClient" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add new client</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" action="" enctype="multipart/form-data" class="row">
                    <div class="col">
                        <div class="mb-3">
                            <label for="insurance" class="form-label">Insurance</label>
                            <select class="form-control" id="insurance" name="insurance" onchange="togglePlateNumber()">
                                <?php while ($insuranceRow = mysqli_fetch_array($insurances)) { ?>
                                    <option value="<?php echo $insuranceRow['insurance_id']; ?>">
                                        <?php echo $insuranceRow['insurance_name']; ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="firstname" class="form-label">Firstname</label>
                            <input type="text" class="form-control" id="firstname" name="firstname">
                        </div>
                        <div class="mb-3">
                            <label for="lastname" class="form-label">Lastname</label>
                            <input type="text" class="form-control" id="lastname" name="lastname">
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
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password" name="password">
                        </div>
                        <div class="mb-3">
                            <label for="dob" class="form-label">Date of Birth</label>
                            <input type="date" class="form-control" id="dob" name="dob" onchange="validateDOB()">
                            <div class="invalid-feedback" id="dobFeedback">You must be over 18 years old.</div>
                        </div>
                    </div>
                    <div class="col">
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
                        <div class="mb-3">
                            <label for="sector" class="form-label">Sector</label>
                            <input type="text" class="form-control" id="sector" name="sector">
                        </div>
                        <div class="mb-3">
                            <label for="bankaccount" class="form-label">Bank account</label>
                            <input type="text" class="form-control" id="bankaccount" name="bankaccount">
                        </div>
                        <div style="display: none;" id="motor">
                            <div class="mb-3">
                                <label for="license" class="form-label">Driving license</label>
                                <input type="text" class="form-control" id="license" name="license">
                            </div>
                            <div class="mb-3">
                                <label for="plate" class="form-label">Plate Number</label>
                                <input type="text" class="form-control" id="plate" name="plate">
                            </div>
                            <div class="mb-3">
                                <label for="yellow" class="form-label">Yellow Paper</label>
                                <input type="text" class="form-control" id="yellow" name="yellow">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="income" class="form-label">Proof of Income</label>
                            <input type="text" class="form-control" id="income" name="income">
                        </div>

                        <div class="mb-3">
                            <label for="contract" class="form-label">Contract</label>
                            <input type="text" class="form-control" id="contract" name="contract">
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </div>
    </div>
</div>

<script>
    // Validating date of birth when registering a client 
    function validateDOB() {
        const dobInput = document.getElementById('dob');
        const dobFeedback = document.getElementById('dobFeedback');
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
        } else {
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