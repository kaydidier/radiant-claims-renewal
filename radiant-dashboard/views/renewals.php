<?php
include "../../includes/connection.php";
include "../../includes/utils/sms.php";
include "../../includes/utils/sendMail.php";
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

                if (isset($_SESSION['clientid'])) {
                    $clientQuery = $mysqli->query("SELECT * FROM clients WHERE id_client = " . $_SESSION['clientid']);
                    $clientData = $clientQuery->fetch_array(MYSQLI_ASSOC);
                    $firstname = $clientData['firstname'];
                    $lastname = $clientData['lastname'];
                    $phone = $clientData['phone'];
                    $email = $clientData['email'];
                }

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
                                        <?php
                                        if (isset($_SESSION['employeeid'])) {
                                        ?><h6 class="m-0 text-primary">All insurance renewals</h6>
                                        <?php } else {
                                        ?>
                                            <h6 class="m-0 text-primary">My renewals</h6>
                                        <?php
                                        } ?>
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
                                            <th>Renewal Amount</th>
                                            <th>Remaining <small>( days )</small></th>
                                            <th>Date Filed</th>
                                            <?php if (isset($_SESSION['employeeid'])) { ?><th>Actions</th> <?php } ?>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $allInsurances = "";

                                        if (isset($_SESSION['employeeid'])) {
                                            $allInsurances = mysqli_query($mysqli, "SELECT * FROM renewals 
                                            LEFT JOIN clients ON renewals.id_client = clients.id_client 
                                            LEFT JOIN insurance ON renewals.insurance_id = insurance.insurance_id");
                                        } else {
                                            $allInsurances = mysqli_query($mysqli, "SELECT * FROM renewals 
                                            LEFT JOIN clients ON renewals.id_client = clients.id_client 
                                            LEFT JOIN insurance ON renewals.insurance_id = insurance.insurance_id
                                            WHERE renewals.id_client = " . $_SESSION['clientid']);
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
                                                <td>
                                                    <?php if (strtolower($row['status']) == "approved") {
                                                        echo "<p class='text-success'>Approved</p>";
                                                    } elseif (strtolower($row['status']) == "requested") {
                                                        echo "<p class='text-warning'>Requested</p>";
                                                    } else {

                                                        echo "<p class='text-danger'>Declined</p>";
                                                    }
                                                    ?>
                                                </td>
                                                <td><?php 
    $renewalAmount = isset($row['renewal_amount']) && is_numeric(str_replace(',', '', $row['renewal_amount'])) 
        ? (float) str_replace(',', '', $row['renewal_amount']) 
        : 0;
    echo number_format($renewalAmount, 2); 
?></td>

                                                <td><?php echo $days; ?></td>
                                                <td><?php echo $row['date_filed']; ?></td>

                                                <?php if (isset($_SESSION['employeeid'])) { ?>
                                                    <td>
                                                        <?php if (strtolower($row['status']) != "approved") { ?>
                                                            <a href="#" class="btn btn-sm btn-warning my-1 approve-renewal-btn" data-toggle="modal" data-target="#approveInsuranceRenewalModal" data-renewal-id="<?php echo $row['renewal_id']; ?>">
                                                                Approve
                                                            </a>
                                                        <?php } ?>

                                                        <a href="./../../files/incomeproofs/<?php echo $row['firstname']; ?>/<?php echo $row['proof_of_income']; ?>" class="btn btn-sm btn-primary my-1 view-renewal-btn" data-renewal-view-id="<?php echo $row['renewal_id']; ?>" target="_blank">
                                                            View file
                                                        </a>

                                                        <?php if (strtolower($row['status']) !== "declined" && strtolower($row['status']) !== "approved"): ?>
                                                            <a href="#" class="btn btn-sm btn-danger my-1 decline-renewal-btn" data-toggle="modal" data-target="#declineInsuranceRenewalModal" data-renewal-decline-id="<?php echo $row['renewal_id']; ?>">
                                                                Decline
                                                            </a>
                                                        <?php endif; ?>

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
                        // Strictly for only clients
                        if (isset($_SESSION['clientid'])) {
                            $clientId = $_SESSION['clientid'];

                            $insurances = $mysqli->query("SELECT clients.insurance_id, id_client, firstname, start_date, end_date, insurance_name FROM clients LEFT JOIN insurance ON clients.insurance_id = insurance.insurance_id WHERE id_client = " . $clientId);

                            // Renew Insurance Logic
                            if (isset($_POST['renewInsurance'])) {
                                $insuranceId = $mysqli->real_escape_string($_POST['selectRenewInsurance']);
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
                                        $uploadDir = './../../files/incomeproofs/' . strtolower($firstname) . '/';
                                        if (!is_dir($uploadDir)) {
                                            mkdir($uploadDir, 0755, true);
                                        }
                                    }

                                    // Update insurance dates in the database
                                    $updateSql = "UPDATE clients SET start_date = '$newStartDate', end_date = '$newEndDate', proof_of_income='$proofFile' WHERE insurance_id = '$insuranceId' AND id_client = '$clientId'";

                                    $insertSql = "INSERT INTO renewals(id_client, insurance_id, status, date_filed) VALUES($clientId, $insuranceId, 'requested', NOW())";

                                    if ($mysqli->query($updateSql) && $mysqli->query($insertSql)) {

                                        move_uploaded_file($_FILES['proof']['tmp_name'], $uploadDir . $proofFile);

                                        // $smsResult = sendSMS(
                                        //     $phone,
                                        //     "Hello, " . $firstname . " " . $lastname . " your insurance renewal request has been received and is being processed."
                                        // );
                                        sendMail($email, "Insurance Renewal Request Received", "Hello, " . $firstname . " " . $lastname . " your insurance renewal request has been received and is being processed.");

                                        echo "<script type='text/javascript'>alert('Your insurance renewal request has been received and is being processed.'); window.location.href = window.location.href;</script>";
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
                                                    <label for="selectRenewInsurance" class="form-label">Insurance</label>
                                                    <select class="form-control" id="selectRenewInsurance" name="selectRenewInsurance">
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
                        <?php
                        }
                        ?>

                        <!-- Approve renwed insurance modal  -->
                        <?php
                        if (isset($_POST['confirmInsuranceRenewal'])) {
                            $renewalId = $mysqli->real_escape_string($_POST['renewalId']);
                            $renewalAmount = $mysqli->real_escape_string($_POST['renewalAmount']);
                            $status = "approved";

                            // Delete the insurance record
                            $approveSql = "UPDATE renewals SET status='$status', renewal_amount = '$renewalAmount' WHERE renewal_id = '$renewalId'";

                            $userQuery = $mysqli->query("
                            SELECT clients.* 
                            FROM clients 
                            JOIN renewals ON clients.id_client = renewals.id_client 
                            WHERE renewals.renewal_id = '$renewalId'
                        ");
                        
                                                        $userRecord = $userQuery->fetch_assoc();
                            if ($mysqli->query($approveSql)) {

                                // $smsResult = sendSMS(
                                //     $phone,
                                //     "Hello, " . $firstname . " " . $lastname . " your insurance renewal request has been approved."
                                // );
                                sendMail($userRecord['email'], "Insurance Renewal Approved", "Hello, " . $userRecord['firstname'] . " " . $userRecord['lastname'] . " your insurance renewal request has been approved.");

                                echo "<script type='text/javascript'>alert('Insurance renewal have been approved successfully!'); window.location.href = window.location.href;</script>";
                            } else {
                                echo "<script type='text/javascript'>alert('Failed to approve insurance renewal. Please try again.');</script>";
                            }
                        }
                        ?>
                        <div class="modal fade" id="approveInsuranceRenewalModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title fs-6 fw-lighter" id="exampleModalLabel">Are you sure you want to approve this insurance renewal?</h5>
                                        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">×</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form method="POST" action="" enctype="multipart/form-data">
                                            <input type="hidden" name="renewalId" id="renewalIdInput">
                                            <div class="form-group">
                                                <label for="renewalAmountInput">Renewal Amount</label>
                                                <input type="text" name="renewalAmount" id="renewalAmountInput" class="form-control">
                                            </div>
                                            <div style="display: flex; gap: 8px; justify-content: end;">
                                                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                                                <button class="btn btn-primary" type="submit" name="confirmInsuranceRenewal">Confirm</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Decline insurance Modal-->
                        <?php

                        if (isset($_POST['declineInsuranceRenewal'])) {
                            $renewDeclineText = $mysqli->real_escape_string($_POST['renewDeclineText']);
                            $renewDeclineReason = $mysqli->real_escape_string($_POST['renewDeclineReason']);
                            $renewalId = $mysqli->real_escape_string($_POST['renewalDeclineId']);

                            // Validate user input
                            if (strtolower($renewDeclineText) === 'decline insurance renewal') {
                                // Delete the insurance record
                                $updateSql = "UPDATE renewals SET status='declined', reason='$renewDeclineReason' WHERE renewal_id = '$renewalId'";

                                $userQuery = $mysqli->query("
                                SELECT clients.* 
                                FROM clients 
                                JOIN renewals ON clients.id_client = renewals.id_client 
                                WHERE renewals.renewal_id = '$renewalId'
                            ");
                            
                                                            $userRecord = $userQuery->fetch_assoc();

                                if ($mysqli->query($updateSql)) {

                                    // $smsResult = sendSMS(
                                    //     $phone,
                                    //     "Hello, " . $firstname . " " . $lastname . " your insurance renewal request has been declined because of: " . $renewDeclineReason . " and should be processed within 3 working days maximum."
                                    // );
                                    sendMail($userRecord['email'], "Insurance Renewal Declined", "Hello, " . $userRecord['firstname'] . " " . $userRecord['lastname'] . " your insurance renewal request has been declined because of: " . $renewDeclineReason . " and should be processed within 3 working days maximum.");

                                    echo "<script type='text/javascript'>alert('Insurance renewal declined successfully!'); window.location.href = window.location.href;</script>";
                                } else {
                                    echo "<script type='text/javascript'>alert('Failed to decline insurance renewal. Please try again.');</script>";
                                }
                            } else {
                                echo "<script type='text/javascript'>alert('Please type correct confirmation to proceed.');</script>";
                            }
                        }
                        ?>
                        <div class="modal fade" id="declineInsuranceRenewalModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title text-danger fs-6 fw-lighter" id="exampleModalLabel">Ready to decline this insurance renewal?</h5>
                                        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">×</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form method="POST" action="" enctype="multipart/form-data">
                                            <input type="hidden" name="renewalDeclineId" id="renewalDeclineIdInput">
                                            <div class="mb-3">
                                                <label for="renewDeclineText" class="form-label">Write <strong>decline insurance renewal</strong> to proceed</label>
                                                <input type="text" class="form-control" id="renewDeclineText" name="renewDeclineText" required>
                                            </div>
                                            <div class="form-floating">
                                                <textarea class="form-control" placeholder="Leave a reason here" id="renewDeclineReason" name="renewDeclineReason" required></textarea>
                                            </div>
                                            <div class="modal-footer">
                                                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                                                <button class="btn btn-danger" type="submit" name="declineInsuranceRenewal">Decline</button>
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

    <!-- JavaScript to handle passing renewal_id to the modal -->
    <script>
        $(document).ready(function() {
            $('.approve-renewal-btn').on('click', function() {
                var renewalId = $(this).data('renewal-id');
                $('#renewalIdInput').val(renewalId);
            });

            $('.decline-renewal-btn').on('click', function() {
                var renewalId = $(this).data('renewal-decline-id');
                $('#renewalDeclineIdInput').val(renewalId);
            });
        });
    </script>

</body>

</html>