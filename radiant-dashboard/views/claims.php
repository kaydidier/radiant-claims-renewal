<?php include "../../includes/connection.php";

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
                <?php include "../views/layout/top_bar.php"; ?>
                <!-- Begin Page Content -->
                <div class="container-fluid">
                    <h1 class="h3 mb-2 text-gray-800">Claims</h1>
                    <?php
                    if ($_SESSION['employeeid']) {
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
                                    <h6 class="m-0 text-primary">All clients</h6>
                                </div>
                                <div class="col-md-8 col-sm-12"></div>
                                <div class="col-md-2 col-sm-12">
                                    <?php
                                    if ($_SESSION['employeeid']) {
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
                                            <th>Reply</th>
                                            <?php
                                            if ($_SESSION['employeeid']) {
                                                echo "<th>Actions</th>";
                                            } ?>
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
                                                <td>Placeholder</td>
                                                <td>Placeholder</td>
                                                <td>Placeholder</td>
                                                <td>Placeholder</td>
                                                <?php
                                                if ($_SESSION['employeeid']) {
                                                    echo "<td><a href='#' class='btn btn-sm btn-warning btn-user'>" . "Reply" . "</a></td>";
                                                } else {
                                                    echo "<td><a href='#' class='btn btn-sm btn-warning btn-user'>" . "Download" . "</a></td>";
                                                }
                                                ?>

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