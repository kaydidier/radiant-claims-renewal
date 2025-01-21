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
                    <?php
                    include "../views/layout/dashboard_cards.php";
                    ?>
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