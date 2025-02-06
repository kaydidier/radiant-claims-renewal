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
                                                <td><?php echo $a; ?></td>
                                                <td><?php echo ucfirst($row['insurance_name']); ?></td>
                                                <td>
                                                    <a href="#" class="btn btn-sm btn-warning btn-user">
                                                        Edit
                                                    </a>
                                                    <a href="#" class="btn btn-sm btn-danger btn-user">
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