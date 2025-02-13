<?php
include "../../includes/connection.php";

if (!isset($_SESSION['employeeid']) && !isset($_SESSION['clientid'])) {
    header("LOCATION: ../../index.php");
}
?>
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
                    <h1>Renewals</h1>
                    <p class="mb-4">Cancel, Renew expired, and Upgrade insurances with ease from this centralized interface.</p>

                    <div class="card shadow mb-4">
                        <?php if (isset($_SESSION['clientid'])) { ?>
                            <div class="card-header py-3">
                                <div class="row justify-content-end">
                                    <div class="col-md-2 col-sm-12">
                                        <h6 class="m-0 text-primary">All insurance renewals</h6>
                                    </div>
                                    <div class="col-md-8 col-sm-12"></div>
                                    <div class="col-md-2 col-sm-12">
                                        <a href="#" class="btn btn-md btn-outline-primary btn-user d-flex align-items-center" data-toggle="modal" data-target="#renewInsurance">
                                            <i class="fas fa-fw fa-plus-circle"></i>
                                            <span class="ml-2">New Renewal</span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>

                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable">
                                    <thead>
                                        <tr>
                                            <th>Id</th>
                                            <th>Name</th>
                                            <th>Insurance</th>
                                            <th>Renew Status</th>
                                            <th>Remaining <small>( days )</small></th>
                                            <th>Issued Date</th>
                                            <th>Expiration Date</th>
                                            <?php if (isset($_SESSION['employeeid'])) { ?><th>Actions</th> <?php } ?>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $allInsurances = "";

                                        if (isset($_SESSION['employeeid'])) {
                                            $allInsurances = mysqli_query($mysqli, "SELECT clients.insurance_id, id_client, firstname, lastname, start_date, end_date, insurance_name FROM clients LEFT JOIN insurance ON clients.insurance_id = insurance.insurance_id");
                                        } else {
                                            $allInsurances = mysqli_query($mysqli, "SELECT * FROM renewals 
                                            LEFT JOIN clients ON renewals.id_client = clients.id_client 
                                            LEFT JOIN insurance ON renewals.insurance_id = insurance.insurance_id");
                                        }

                                        $a = 1;
                                        $today = date('Y-m-d');

                                        while ($row = mysqli_fetch_array($allInsurances)) {
                                            $today_date = new DateTime($today);
                                            $end_date = new DateTime($row['end_date']);
                                            $interval = $today_date->diff($end_date);
                                            $days = $interval->days;
                                        ?>
                                            <tr>
                                                <td><?php echo $row['id_client']; ?></td>
                                                <td><?php echo ucfirst($row['firstname']) . " " . ucfirst($row['lastname']); ?></td>
                                                <td><?php echo ucwords($row['insurance_name']); ?></td>
                                                <td><?php if (strtolower($row['status']) == "approved") {
                                                        echo "<p class='text-success'>Approved</p>";
                                                    } else {
                                                        echo "<p class='text-danger'>Requested</p>";
                                                    }
                                                    ?></td>
                                                <td><?php echo $days; ?></td>
                                                <td><?php echo $row['start_date']; ?></td>
                                                <td><?php echo $row['end_date']; ?></td>

                                                <?php if (isset($_SESSION['employeeid'])) { ?>
                                                    <td>
                                                        <a href="#" class="btn btn-sm btn-warning btn-user" data-toggle="modal" data-target="#renewInsurance">
                                                            Approve
                                                        </a>
                                                        <a href="#" class="btn btn-sm btn-danger btn-user" data-toggle="modal" data-target="#cancelInsurance">
                                                            Decline
                                                        </a>
                                                    </td>
                                                <?php } ?>
                                            </tr>
                                        <?php
                                            $a++;
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- Renew insurance Modal-->
                        <?php

                        $clientId = $_SESSION['clientid'];

                        $insurances = $mysqli->query("SELECT clients.insurance_id, id_client, firstname, start_date, end_date, insurance_name FROM clients LEFT JOIN insurance ON clients.insurance_id = insurance.insurance_id WHERE id_client = " . $clientId);

                        // Renew Insurance Logic
                        if (isset($_POST['renewInsurance'])) {
                            $insuranceId = $mysqli->real_escape_string($_POST['insurance']);
                            $newStartDate = $mysqli->real_escape_string($_POST['newStartDate']);
                            $newEndDate = $mysqli->real_escape_string($_POST['newEndDate']);
                            $today = date('Y-m-d');

                            // Validate dates
                            if ($newStartDate < $today || $newEndDate < $newStartDate) {
                                echo "<script type='text/javascript'>alert('Invalid dates. Start date cannot be in the past, and end date must be after the start date.');</script>";
                            } else {
                                // Handle file upload for proof of payment
                                $proofFile = '';
                                if (!empty($_FILES['proof']['tmp_name'])) {
                                    $proofFile = time() . '_' . preg_replace('/[^A-Za-z0-9\-._]/', '', $_FILES['proof']['name']);
                                    $uploadDir = './../files/incomeproofs/';
                                    if (!is_dir($uploadDir)) {
                                        mkdir($uploadDir, 0755, true);
                                    }
                                }

                                // Update insurance dates in the database
                                $updateSql = "UPDATE clients SET start_date = '$newStartDate', end_date = '$newEndDate', proof_of_income='$proofFile' WHERE insurance_id = '$insuranceId' AND id_client = '$clientId'";

                                $insertSql = "INSERT INTO renewals(id_client, insurance_id, status) VALUES($clientId, $insuranceId, 'requested')";

                                if ($mysqli->query($updateSql) and $mysqli->query($insertSql)) {

                                    move_uploaded_file($_FILES['proof']['tmp_name'], $uploadDir . $proofFile);

                                    echo "<script type='text/javascript'>alert('Insurance renewed successfully!'); window.location.href = window.location.href;</script>";
                                } else {
                                    echo "<script type='text/javascript'>alert('Failed to renew insurance. Please try again.');</script>";
                                }
                            }
                        }
                        ?>
                        <div class="modal fade" id="renewInsurance" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Renew insurance</h5>
                                        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">×</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form method="POST" action="" enctype="multipart/form-data">

                                            <div class="mb-3">
                                                <label for="insurance" class="form-label">Insurance <small>( Select insurance for renewal )</small></label>
                                                <select class="form-control" id="insurance" name="insurance">
                                                    <?php while ($insuranceRow = mysqli_fetch_array($insurances)) { ?>
                                                        <option value="<?php echo $insuranceRow['insurance_id']; ?>">
                                                            <?php echo ucwords($insuranceRow['insurance_name']); ?>
                                                        </option>
                                                    <?php }
                                                    $a++; ?>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label for="newStartDate" class="form-label">New Issue Date <small>( Start date of the insurance )</small></label>
                                                <input type="date" class="form-control" id="newStartDate" name="newStartDate" required>
                                                <div class="invalid-feedback" id="sNdateFeedback">New issue date can't be in the past.</div>
                                            </div>
                                            <div class="mb-3">
                                                <label for="newEndDate" class="form-label">New Expiration Date <small>(New end date of the insurance )</small></label>
                                                <input type="date" class="form-control" id="newEndDate" name="newEndDate" required>
                                                <div class="invalid-feedback" id="eNdateFeedback">Expiration date can't be in the past.</div>
                                            </div>

                                            <div class="mb-3 d-flex flex-column">
                                                <label for="proof" class="form-label">Proof of payment</label>
                                                <input class="form-control" type="file" id="proof" name="proof">
                                            </div>
                                            <div class="modal-footer">
                                                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                                                <button class="btn btn-primary" type="submit" name="renewInsurance">Renew</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Delete/Cancel insurance Modal-->
                        <?php
                        // Cancel Insurance Logic
                        if (isset($_POST['cancelInsurance'])) {
                            $renewRetype = $mysqli->real_escape_string($_POST['renewRetype']);
                            $insuranceId = $mysqli->real_escape_string($_POST['insuranceId']);

                            // Validate user input
                            if (strtolower($renewRetype) === 'cancel insurance') {
                                // Delete the insurance record
                                $deleteSql = "DELETE FROM clients WHERE id_client = '$insuranceId'";
                                if ($mysqli->query($deleteSql)) {
                                    echo "<script type='text/javascript'>alert('Insurance canceled successfully!'); window.location.href = window.location.href;</script>";
                                } else {
                                    echo "<script type='text/javascript'>alert('Failed to cancel insurance. Please try again.');</script>";
                                }
                            } else {
                                // echo "<script type='text/javascript'>alert('Confirmation text is incorrect. Please type to proceed.');</script>";
                                echo $insuranceId;
                            }
                        }
                        ?>
                        <div class="modal fade" id="cancelInsurance" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title text-danger fs-6 fw-lighter" id="exampleModalLabel">Ready to cancel this insurance?</h5>
                                        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">×</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form method="POST" action="" enctype="multipart/form-data">
                                            <input type="hidden" id="insuranceId" name="insuranceId" value="<?php echo $row['insurance_id']; ?>">
                                            <div class="mb-3">
                                                <label for="renewRetype" class="form-label">Write <strong>cancel insurance</strong> to proceed</label>
                                                <input type="text" class="form-control" id="renewRetype" name="renewRetype" required>
                                            </div>
                                            <div class="modal-footer">
                                                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                                                <button class="btn btn-danger" type="submit" name="cancelInsurance">Submit</button>
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

</body>

</html>