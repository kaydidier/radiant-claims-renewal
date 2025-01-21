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

<!-- Logout Modal-->
<?php
$insurances = mysqli_query($mysqli, "SELECT * FROM insurance");
$provinces = mysqli_query($mysqli, "SELECT * FROM province");

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
                            <select class="form-control" aria-label="insurance" id="insurance" onchange="togglePlateNumber()">
                                <?php while ($insuranceRow = mysqli_fetch_array($insurances)) { ?>
                                    <option value="<?php echo $insuranceRow['insurance_id']; ?>">
                                        <?php echo $insuranceRow['insurance_name']; ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="firstname" class="form-label">Firstname</label>
                            <input type="text" class="form-control" id="firstname">
                        </div>
                        <div class="mb-3">
                            <label for="lastname" class="form-label">Lastname</label>
                            <input type="text" class="form-control" id="lastname">
                        </div>
                        <div class="mb-3">
                            <label for="gender" class="form-label">Gender</label>
                            <select class="form-control" id="gender">
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
                            <input type="email" class="form-control" id="email">
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password">
                        </div>
                        <div class="mb-3">
                            <label for="dob" class="form-label">Date of Birth</label>
                            <input type="date" class="form-control" id="dob" name="dob">
                        </div>
                    </div>
                    <div class="col">
                        <div class="mb-3">
                            <label for="province" class="form-label">Province</label>
                            <select class="form-control" id="province" name="province">
                                <option value="">Select Province</option>
                                <?php foreach ($provinces as $province) {
                                    echo '<option value="' . $province['proviceId'] . '">' . $province['provinceName'] . '</option>';
                                } ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="district" class="form-label">District</label>
                            <select class="form-control" id="district" name="district">
                            <option value="">Select Province First</option>

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
                            <div class="mb-3" id="plate">
                                <label for="plate" class="form-label">Plate Number</label>
                                <input type="text" class="form-control" id="plate" name="plate">
                            </div>
                            <div class="mb-3">
                                <label for="yellow" class="form-label">Yellow Paper</label>
                                <input type="text" class="form-control" id="yellow" name="yellow">
                            </div>
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

<!-- Page level plugins -->
<script src="../vendor/datatables/jquery.dataTables.min.js"></script>
<script src="../vendor/datatables/dataTables.bootstrap4.min.js"></script>

<!-- Page level custom scripts -->
<script src="../js/demo/datatables-demo.js"></script>

<!-- Custom scripts for all pages-->
<script src="../js/sb-admin-2.min.js"></script>