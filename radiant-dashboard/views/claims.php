<?php include "../../includes/connection.php";

if (!isset($_SESSION['employeeid']) && !isset($_SESSION['clientid'])) {
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
        // include "../../includes/utils/sms.php";

        if (isset($_SESSION['clientid'])) {
            $clientQuery = $mysqli->query("SELECT * FROM clients WHERE id_client = " . $_SESSION['clientid']);
            $clientData = $clientQuery->fetch_array(MYSQLI_ASSOC);
            $firstname = $clientData['firstname'];
            $lastname = $clientData['lastname'];
            $phone = $clientData['phone'];
        }
        
        ?>
        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">
            <!-- Main Content -->
            <div id="content">
                <?php include "../views/layout/top_bar.php"; ?>
                <!-- Begin Page Content -->
                <div class="container-fluid">
                    <h1 class="h3 mb-2 text-gray-800">Claims</h1>
                    <?php
                    if (isset($_SESSION['employeeid'])) {
                        echo "<p class='mb-4'>View and Manage insurance claims with ease from this centralized interface.</p>";
                    } else {
                        echo "<p class='mb-4'>Create insurance claims with ease from this centralized interface.</p>";
                    }
                    ?>

                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <div class="row justify-content-end">
                                <div class="col-md-2 col-sm-12">
                                    <?php
                                    if (isset($_SESSION['employeeid'])) { ?><h6 class="m-0 text-primary">All available claims</h6> <?php } else { ?>
                                        <h6 class="m-0 text-primary">My claims</h6> <?php } ?>
                                </div>
                                <div class="col-md-8 col-sm-12"></div>
                                <div class="col-md-2 col-sm-12">
                                    <?php
                                    if (isset($_SESSION['clientid'])) {
                                    ?>
                                        <a href="#" class="btn btn-md btn-outline-primary btn-user d-flex align-items-center" data-toggle="modal" data-target="#addClaim">
                                            <i class="fas fa-fw fa-plus-circle"></i>
                                            <span class="ml-2">Add Claims</span>
                                        </a>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable">
                                    <thead>
                                        <tr>
                                            <th>Id</th>
                                            <th>Clients Names</th>
                                            <th>Description</th>
                                            <th>Amount <small class="text-muted">(RWF)</small></th>
                                            <th>Date Filed</th>
                                            <th>Status</th>
                                            <?php if (isset($_SESSION['employeeid'])) { ?><th>Actions</th> <?php } ?>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $allClaims = "";

                                        if (isset($_SESSION['employeeid'])) {
                                            $allClaims = mysqli_query($mysqli, "SELECT * FROM claim 
                                           LEFT JOIN clients ON claim.id_client = clients.id_client 
                                           LEFT JOIN insurance ON claim.insurance_id = insurance.insurance_id");
                                        } else {
                                            $allClaims = mysqli_query($mysqli, "SELECT * FROM claim 
                                           LEFT JOIN clients ON claim.id_client = clients.id_client 
                                           LEFT JOIN insurance ON claim.insurance_id = insurance.insurance_id
                                           WHERE claim.id_client = " . $_SESSION['clientid']);
                                        }

                                        $a = 1;
                                        while ($row = mysqli_fetch_array($allClaims)) {
                                        ?>
                                            <tr>
                                                <td><?php echo $a; ?></td>
                                                <td><?php echo ($row['firstname'] ? ucfirst($row['firstname']) : '') . " " . ($row['lastname'] ? ucfirst($row['lastname']) : ''); ?></td>
                                                <td><?php echo ucfirst($row['comments']); ?></td>
                                                <td><?php echo $row['claim_amount'] ? number_format($row['claim_amount'], 0, ',', ' ') : '0'; ?></td>
                                                <td><?php echo $row['date_filed']; ?></td>
                                                <td><?php if (strtolower($row['status']) == "approved") {
                                                        echo "<p class='text-success'>Approved</p>";
                                                    } elseif (strtolower($row['status']) == "pending") {
                                                        echo "<p class='text-warning'>Pending</p>";
                                                    } else {

                                                        echo "<p class='text-danger'>Declined</p>";
                                                    }
                                                    ?></td>
                                                <?php if (isset($_SESSION['employeeid']) && strtolower($row['status']) !== "declined") { ?>
                                                    <td>
                                                        <a href="./../../files/support/<?php echo $row['firstname']; ?>/<?php echo $row['support_file']; ?>" class="btn btn-sm btn-primary view-claim-btn" data-claim-view-id="<?php echo $row['claim_id']; ?>" target="_blank">
                                                            View file
                                                        </a>

                                                        <?php if (strtolower($row['status']) === "pending") { ?>
                                                            <a href="#" class="btn btn-sm btn-warning approve-claim-btn" data-toggle="modal" data-target="#approveClaimModal" data-claim-id="<?php echo $row['claim_id']; ?>">
                                                                Approve
                                                            </a>
                                                        <?php } ?>


                                                        <a href="#" class="btn btn-sm btn-danger decline-claim-btn" data-toggle="modal" data-target="#declineClaimModal" data-claim-decline-id="<?php echo $row['claim_id']; ?>">
                                                            Decline
                                                        </a>

                                                    </td>
                                                <?php } ?>
                                            </tr>
                                        <?php $a++;
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- Approve renwed insurance modal  -->
                        <?php
                        if (isset($_POST['confirmInsuranceClaim'])) {
                            $claimId = $mysqli->real_escape_string($_POST['claimId']);
                            $claimAmount = $mysqli->real_escape_string($_POST['claimAmount']);
                            $status = "approved";

                            // Delete the insurance record
                            $approveSql = "UPDATE claim SET status='$status', claim_amount = '$claimAmount' WHERE claim_id = '$claimId'";

                            if ($mysqli->query($approveSql)) {

                                $smsResult = sendSMS(
                                    $phone,
                                    "Hello, " . $firstname . " " . $lastname . " your insurance claim of " . $claimAmount . " RWF has been approved."
                                );

                                echo "<script type='text/javascript'>alert('Insurance claim have been approved successfully!'); window.location.href = window.location.href;</script>";
                            } else {
                                echo "<script type='text/javascript'>alert('Failed to approve insurance claim. Please try again.');</script>";
                            }
                        }
                        ?>
                        <div class="modal fade" id="approveClaimModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title fs-6 fw-lighter" id="exampleModalLabel">Are you sure you want to approve this insurance claim?</h5>
                                        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">×</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form method="POST" action="" enctype="multipart/form-data">
                                            <input type="hidden" name="claimId" id="claimIdInput">
                                            <div class="form-group">
                                                <label for="claimAmountInput">Claim Amount</label>
                                                <input type="text" name="claimAmount" id="claimAmountInput" class="form-control">
                                            </div>
                                            <div style="display: flex; gap: 8px; justify-content: end;">
                                                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                                                <button class="btn btn-primary" type="submit" name="confirmInsuranceClaim">Confirm</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Decline insurance Modal-->
                        <?php

                        if (isset($_POST['declineInsuranceClaim'])) {
                            $claimDeclineText = $mysqli->real_escape_string($_POST['claimDeclineText']);
                            $claimDeclineReason = $mysqli->real_escape_string($_POST['claimDeclineReason']);
                            $claimId = $mysqli->real_escape_string($_POST['claimDeclineId']);

                            // Validate user input
                            if (strtolower($claimDeclineText) === 'decline insurance claim') {
                                // Delete the insurance record
                                $updateSql = "UPDATE claim SET status='declined', decline_reason='$claimDeclineReason' WHERE claim_id = '$claimId'";

                                if ($mysqli->query($updateSql)) {

                                    $smsResult = sendSMS(
                                        $phone,
                                        "Hello, " . $firstname . " " . $lastname . " your insurance claim has been declined with the reason: " . $claimDeclineReason
                                    );

                                    echo "<script type='text/javascript'>alert('Insurance claim declined successfully!'); window.location.href = window.location.href;</script>";
                                } else {
                                    echo "<script type='text/javascript'>alert('Failed to decline insurance claim. Please try again.');</script>";
                                }
                            } else {
                                echo "<script type='text/javascript'>alert('Please type correct confirmation to proceed.');</script>";
                            }
                        }
                        ?>
                        <div class="modal fade" id="declineClaimModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                                            <input type="hidden" name="claimDeclineId" id="claimDeclineIdInput">
                                            <div class="mb-3">
                                                <label for="claimDeclineText" class="form-label">Write <strong>decline insurance claim</strong> to proceed</label>
                                                <input type="text" class="form-control" id="claimDeclineText" name="claimDeclineText" required>
                                            </div>
                                            <div class="form-floating">
                                                <textarea class="form-control" placeholder="Leave a reason here" id="claimDeclineReason" name="claimDeclineReason" required></textarea>
                                            </div>
                                            <div class="modal-footer">
                                                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                                                <button class="btn btn-danger" type="submit" name="declineInsuranceClaim">Decline</button>
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

    <!-- JavaScript to handle passing claim_id to the modal -->
    <script>
        $(document).ready(function() {
            $('.approve-claim-btn').on('click', function() {
                var claimId = $(this).data('claim-id');
                $('#claimIdInput').val(claimId);
            });

            $('.decline-claim-btn').on('click', function() {
                var claimId = $(this).data('claim-decline-id');
                $('#claimDeclineIdInput').val(claimId);
            });
        });
    </script>


</body>

</html>