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
                    <h1>Renewals</h1>
                    <p class="mb-4">Cancel, Renew expired, and Upgrade insurances with ease from this centralized interface.</p>

                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <div class="row">
                                <div class="col-md-12 col-sm-12">
                                    <small class="m-0 text-primary">All available insuraces with their statuses</small>
                                </div>
                            </div>
                        </div>

                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable">
                                    <thead>
                                        <tr>
                                            <th>Id</th>
                                            <th>Client Name</th>
                                            <th>Insurance</th>
                                            <th>Status</th>
                                            <th>Remaining <small>( days )</small></th>
                                            <th>Issued Date</th>
                                            <th>Expiration Date</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $allInsurances = mysqli_query($mysqli, "SELECT clients.insurance_id, firstname, lastname, start_date, end_date, insurance_name FROM clients LEFT JOIN insurance ON clients.insurance_id = insurance.insurance_id");
                                        $a = 1;
                                        $today = date('Y-m-d');

                                        while ($row = mysqli_fetch_array($allInsurances)) {
                                            $today_date = new DateTime($today);
                                            $end_date = new DateTime($row['end_date']);
                                            $interval = $today_date->diff($end_date);
                                            $days = $interval->days;
                                        ?>
                                            <tr>
                                                <td><?php echo $a; ?></td>
                                                <td><?php echo ucfirst($row['firstname']) . " " . ucfirst($row['lastname']); ?></td>
                                                <td><?php echo ucwords($row['insurance_name']); ?></td>
                                                <td><?php if ($days > 0) {
                                                        echo "<p class='text-success'>Active</p>";
                                                    } else {
                                                        echo "<p class='text-danger'>Expired</p>";
                                                    }
                                                    ?></td>
                                                <td><?php echo $days; ?></td>
                                                <td><?php echo $row['start_date']; ?></td>
                                                <td><?php echo $row['end_date']; ?></td>
                                                <td>
                                                    <a href="#" class="btn btn-sm btn-warning btn-user" data-toggle="modal" data-target="#renewInsurance">
                                                        Renew
                                                    </a>
                                                    <a href="#" class="btn btn-sm btn-danger btn-user" data-toggle="modal" data-target="#cancelInsurance">
                                                        Cancel
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

                        <!-- Renew insurance Modal-->
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
                                                <label for="startDate" class="form-label">New Issue Date <small>( Start date of the insurance )</small></label>
                                                <input type="date" class="form-control" id="startDate" name="startDate">
                                                <div class="invalid-feedback" id="sDateFeedback">Issue date can't be in the past.</div>
                                            </div>
                                            <div class="mb-3">
                                                <label for="endDate" class="form-label">New Expiration Date <small>( End date of the insurance )</small></label>
                                                <input type="date" class="form-control" id="endDate" name="endDate">
                                                <div class="invalid-feedback" id="eDateFeedback">Expiration date can't be in the past.</div>
                                            </div>

                                            <div class="mb-3 d-flex flex-column">
                                                <label for="proof" class="form-label">Proof of payment</label>
                                                <input class="form-control" type="file" id="proof">
                                            </div>
                                            <div class="modal-footer">
                                                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                                                <button class="btn btn-primary" type="submit" name="saveInsurance">Renew</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Delete/Cancel insurance Modal-->
                        <div class="modal fade" id="cancelInsurance" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title text-danger fs-6 fw-lighter" id="exampleModalLabel">Ready to cancel this insurance ? </h5>
                                        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">×</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form method="POST" action="" enctype="multipart/form-data">
                                            <div class="mb-3">
                                                <label for="InsuranceName" class="form-label">Write <strong>cancel insurance</strong> to proceed</label>
                                                <input type="text" class="form-control" id="InsuranceName" name="InsuranceName">
                                            </div>
                                            <div class="modal-footer">
                                                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                                                <button class="btn btn-danger" type="submit" name="saveInsurance">Submit</button>
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