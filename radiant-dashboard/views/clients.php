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


                <!-- Page Heading -->
                <h1 class="h3 mb-2 text-gray-800">Clients</h1>
                <p class="mb-4">Add, edit, or remove client profiles with ease from this centralized interface.</p>

                <!-- DataTales Example -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <div class="row">
                            <div class="col-md-2 col-sm-12">
                                <h6 class="m-0 font-weight-bold text-primary">All clients</h6>
                            </div>
                            <div class="col-md-9"></div>
                            <div class="col-md-1 justify-content-end">
                                <a href="#" class="btn btn-sm btn-outline-primary btn-user">
                                    Add
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="dataTable">
                                <thead>
                                <tr>
                                    <th>Names</th>
                                    <th>Phone Number</th>
                                    <th>Email</th>
                                    <th>ID Number</th>
                                    <th>Address</th>
                                    <th>Username</th>
                                    <th>Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php

                                ?>
                                <tr>
                                    <td>Ashton Cox</td>
                                    <td>Junior Technical Author</td>
                                    <td>San Francisco</td>
                                    <td>San Francisco</td>
                                    <td>San Francisco</td>
                                    <td>66</td>
                                    <td>
                                        <a href="#" class="btn btn-sm btn-warning btn-user">
                                            Edit
                                        </a>
                                        <a href="#" class="btn btn-sm btn-danger btn-user">
                                            Remove
                                        </a>
                                    </td>
                                </tr>
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