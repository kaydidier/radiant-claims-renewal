<?php
include "../../includes/connection.php";
include "../../includes/utils/sms.php";
if (!isset($_SESSION['clientid'])) {
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


                    <!-- Page Heading -->
                    <h1 class="h3 mb-2 text-gray-800">My Insurances</h1>
                    <p class="mb-4">View your insurances with ease from this centralized interface.</p>

                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable">
                                    <thead>
                                        <tr>
                                            <th>Id</th>
                                            <th>Insurance</th>
                                            <th>Validity</th>
                                            <th>Proof of payment</th>
                                            <th>Contract</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $allClients = mysqli_query($mysqli, "SELECT * FROM clients INNER JOIN insurance ON clients.insurance_id = insurance.insurance_id WHERE clients.id_client = " . $_SESSION['clientid']);
                                        $a = 1;
                                        while ($row = mysqli_fetch_array($allClients)) {
                                            $validity = $row['start_date'] . " - " . $row['end_date'];
                                        ?>
                                            <tr>
                                                <td><?php echo $a; ?></td>

                                                <td><?php echo ucwords($row['insurance_name']); ?></td>
                                                <td><?php echo $validity; ?></td>
                                                <?php
                                                $incomeFilePath = './../../files/incomeproofs/' . strtolower($row['firstname']) . '/' . $row['proof_of_income'];
                                                $contractFilePath = './../../files/contracts/' . strtolower($row['firstname']) . '/' . $row['contract'];
                                                ?>
                                                <td>
                                                    <?php if (file_exists($incomeFilePath)) { ?>
                                                        <a href="<?php echo $incomeFilePath; ?>" target="_blank">View Proof of Payment</a>
                                                    <?php } else { ?>
                                                        <span class="text-danger">File not found</span>
                                                    <?php } ?>
                                                </td>
                                                <td>
                                                    <?php if (file_exists($contractFilePath)) { ?>
                                                        <a href="<?php echo $contractFilePath; ?>" target="_blank">View Contract</a>
                                                    <?php } else { ?>
                                                        <span class="text-danger">File not found</span>
                                                    <?php } ?>
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