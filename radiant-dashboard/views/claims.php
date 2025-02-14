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
                                            <th>Date</th>
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
                                            $claimDateTime = new DateTime($row['claim_time']);
                                            $claimDate = $claimDateTime->format('d-m-Y');
                                        ?>
                                            <tr>
                                                <td><?php echo $a; ?></td>
                                                <td><?php echo ucfirst($row['firstname']) . " " . ucfirst($row['lastname']); ?></td>
                                                <td><?php echo $row['comments']; ?></td>
                                                <td><?php echo $claimDate; ?></td>
                                                <td><?php echo $row['status']; ?></td>
                                                <?php if (isset($_SESSION['employeeid']) && strtolower($row['status']) != "declined") { ?>
                                                    <td>
                                                        <?php if (strtolower($row['status']) != "pending") { ?>
                                                            <a href="#" class="btn btn-sm btn-warning approve-renewal-btn" data-toggle="modal" data-target="#approveInsuranceModal" data-renewal-id="<?php echo $row['claim_id']; ?>">
                                                                Approve
                                                            </a>
                                                        <?php } ?>

                                                        <a href="./../../files/support/<?php echo $row['firstname']; ?>/<?php echo $row['support_file']; ?>" class="btn btn-sm btn-primary view-renewal-btn" data-renewal-view-id="<?php echo $row['claim_id']; ?>" target="_blank">
                                                            View file
                                                        </a>

                                                        <a href="#" class="btn btn-sm btn-danger decline-renewal-btn" data-toggle="modal" data-target="#declineInsuranceModal" data-renewal-decline-id="<?php echo $row['claim_id']; ?>">
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