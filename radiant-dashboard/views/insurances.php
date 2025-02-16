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

                    <h1 class="h3 mb-2 text-gray-800">Insurance</h1>
                    <p class="mb-4">Add, edit, or remove available insurances with ease from this centralized interface.</p>

                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <div class="row justify-content-end">
                                <div class="col-md-2 col-sm-12">
                                    <h6 class="m-0 text-primary">All clients</h6>
                                </div>
                                <div class="col-md-8 col-sm-12"></div>
                                <div class="col-md-2 col-sm-12">
                                    <a href="#" class="btn btn-md btn-outline-primary btn-user d-flex align-items-center" data-toggle="modal" data-target="#addInsurance">
                                        <i class="fas fa-fw fa-plus-circle"></i>
                                        <span class="ml-2">Add Insurance</span>
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
                                            <th>Insurance Names</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $allInsurances = mysqli_query($mysqli, "SELECT * FROM insurance");
                                        $a = 1;
                                        while ($row = mysqli_fetch_array($allInsurances)) {
                                        ?>
                                            <tr>
                                                <td><?php echo $row['insurance_id']; ?></td>
                                                <td><?php echo ucwords($row['insurance_name']); ?></td>
                                                <td>
                                                    <a href="#" class="btn btn-sm btn-warning edit-insurance-btn" data-toggle="modal" data-target="#editInsuranceModal" data-insurance-id="<?php echo $row['insurance_id']; ?>">
                                                        Edit
                                                    </a>
                                                    <a href="#" class="btn btn-sm btn-danger remove-insurance-btn" data-toggle="modal" data-target="#removeInsuranceModal" data-insurance-id="<?php echo $row['insurance_id']; ?>">
                                                        Remove
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

                        <!-- Edit insurance modal -->
                        <?php

                        if (isset($_POST['editInsurance'])) {
                            $editInsuranceName = $mysqli->real_escape_string($_POST['editInsuranceName']);
                            $editInsuranceId = $mysqli->real_escape_string($_POST['editInsuranceId']);

                            // Get the insurance details
                            $insuranceSql = $mysqli->query("SELECT * FROM insurance WHERE insurance_id = '$editInsuranceId'") or die($mysqli->error);
                            $insurance = mysqli_fetch_array($insuranceSql);

                            // Add validation to check if insurance name already exists
                            $checkSql = "SELECT * FROM insurance WHERE insurance_name = '$editInsuranceName' AND insurance_id != '$editInsuranceId'";
                            $result = $mysqli->query($checkSql);

                            if ($result->num_rows > 0) {
                                echo "<script type='text/javascript'>alert('Insurance name already exists. Please use a different name.');</script>";
                            } else {
                                $updateSql = "UPDATE insurance SET insurance_name = '$editInsuranceName' WHERE insurance_id = '$editInsuranceId'";

                                if ($mysqli->query($updateSql)) {
                                    echo "<script type='text/javascript'>alert('Insurance has been updated successfully!'); window.location.href = window.location.href;</script>";
                                } else {
                                    echo "<script type='text/javascript'>alert('Failed to update insurance. Please try again.');</script>";
                                }
                            }
                        }
                        ?>
                        <div class="modal fade" id="editInsuranceModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Edit Insurance</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">×</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form method="POST" action="">
                                            <input type="hidden" name="editInsuranceId" id="editInsuranceIdInput">
                                            <div class="form-group">
                                                <label for="editInsuranceName">Insurance Name <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" id="editInsuranceName" name="editInsuranceName" value="<?php echo isset($insurance['insurance_name']) ? $insurance['insurance_name'] : ''; ?>" required>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                                <button type="submit" class="btn btn-primary" name="editInsurance">Save changes</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Remove insurance modal -->
                    <?php
                    if (isset($_POST['deleteInsurance'])) {
                        $insuranceId = $mysqli->real_escape_string($_POST['removeInsuranceId']);
                        $deleteText = $mysqli->real_escape_string($_POST['deleteText']);

                        if (strtolower($deleteText) === 'remove insurance') {
                            // Delete the insurance record
                            $updateSql = "DELETE FROM insurance WHERE insurance_id = '$insuranceId'";

                            if ($mysqli->query($updateSql)) {
                                echo "<script type='text/javascript'>alert('Insurance have been deleted successfully!'); window.location.href = window.location.href;</script>";
                            } else {
                                echo "<script type='text/javascript'>alert('Failed to delete insurance. Please try again.');</script>";
                            }
                        } else {
                            echo "<script type='text/javascript'>alert('Please type correct confirmation to proceed.');</script>";
                        }
                    }
                    ?>
                    <div class="modal fade" id="removeInsuranceModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Remove Insurance</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">×</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form method="POST" action="">
                                        <input type="hidden" name="removeInsuranceId" id="removeInsuranceIdInput">
                                        <div class="mb-3">
                                            <label for="deleteText" class="form-label">Write <strong>remove insurance</strong> to proceed</label>
                                            <input type="text" class="form-control" id="deleteText" name="deleteText" required>
                                        </div>
                                        <p>Are you sure you want to remove this insurance?</p>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                            <button type="submit" class="btn btn-danger" name="deleteInsurance">Remove</button>
                                        </div>
                                    </form>
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
            $('.edit-insurance-btn').click(function() {
                var insuranceId = $(this).data('insurance-id');
                $('#editInsuranceIdInput').val(insuranceId);
            });

            $('.remove-insurance-btn').click(function() {
                var insuranceId = $(this).data('insurance-id');
                $('#removeInsuranceIdInput').val(insuranceId);
            });
        });
    </script>

</body>

</html>