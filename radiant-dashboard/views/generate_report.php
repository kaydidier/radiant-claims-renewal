<?php
include "../../includes/connection.php";

if (!isset($_SESSION['employeeid'])) {
    header("LOCATION: ../../index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<?php include "../views/layout/header.php"; ?>

<body id="page-top">
    <div id="wrapper">
        <?php include "../views/layout/sidebar.php"; ?>

        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <?php include "../views/layout/top_bar.php"; ?>

                <div class="container-fluid">
                    <h1 class="h3 mb-2 text-gray-800">Generated Report</h1>

                    <?php
                    if ($_SERVER["REQUEST_METHOD"] == "POST") {
                        $reportType = $_POST['reportType'];
                        $startDate = $_POST['startDate'];
                        $endDate = $_POST['endDate'];

                        // Initialize query based on report type
                        switch ($reportType) {
                            case 'claims':
                                $query = "SELECT c.*, cl.firstname, cl.lastname 
                                         FROM claim c 
                                         JOIN clients cl ON c.id_client = cl.id_client 
                                         WHERE c.date_filed BETWEEN ? AND ?
                                         ORDER BY c.date_filed DESC";
                                break;

                            case 'renewals':
                                $query = "SELECT p.*, cl.firstname, cl.lastname 
                                         FROM renewals p 
                                         JOIN clients cl ON p.id_client = cl.id_client 
                                         WHERE p.date_filed BETWEEN ? AND ?
                                         ORDER BY p.date_filed DESC";
                                break;

                            case 'compensation_3_months':
                            case 'compensation_6_months':
                                $query = "SELECT 
                                            DATE_FORMAT(c.date_filed, '%Y-%m') as month,
                                            SUM(c.claim_amount) as total_compensation,
                                            COUNT(*) as claim_count
                                         FROM claim c 
                                         WHERE c.date_filed BETWEEN ? AND ?
                                         GROUP BY DATE_FORMAT(c.date_filed, '%Y-%m')
                                         ORDER BY month DESC";
                                break;
                        }

                        // Prepare and execute query
                        $stmt = $mysqli->prepare($query);
                        $stmt->bind_param("ss", $startDate, $endDate);
                        $stmt->execute();
                        $result = $stmt->get_result();
                    ?>

                        <div class="card shadow mb-4">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-primary">
                                    <?php echo ucfirst(str_replace('_', ' ', $reportType)); ?>
                                    (<?php echo $startDate; ?> to <?php echo $endDate; ?>)
                                </h6>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered" width="100%" cellspacing="0">
                                        <?php if ($reportType == 'claims'): ?>
                                            <thead>
                                                <tr>
                                                    <th>Claim ID</th>
                                                    <th>Client Name</th>
                                                    <th>Date Filed</th>
                                                    <th>Amount</th>
                                                    <th>Status</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php while ($row = $result->fetch_assoc()): ?>
                                                    <tr>
                                                        <td><?php echo $row['claim_id']; ?></td>
                                                        <td><?php echo ucfirst($row['firstname']) . ' ' . ucfirst($row['lastname']); ?></td>
                                                        <td><?php echo $row['date_filed']; ?></td>
                                                        <td>Rwf <?php echo number_format($row['claim_amount'], 2); ?></td>
                                                        <td><?php echo ucfirst($row['status']); ?></td>
                                                    </tr>
                                                <?php endwhile; ?>
                                            </tbody>

                                        <?php elseif ($reportType == 'renewals'): ?>
                                            <thead>
                                                <tr>
                                                    <th>Renewal ID</th>
                                                    <th>Client Name</th>
                                                    <th>Renewal Date</th>
                                                    <th>Premium</th>
                                                    <th>Status</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php while ($row = $result->fetch_assoc()): ?>
                                                    <tr>
                                                        <td><?php echo $row['renewal_id']; ?></td>
                                                        <td><?php echo ucfirst($row['firstname']) . ' ' . ucfirst($row['lastname']); ?></td>
                                                        <td><?php echo $row['date_filed']; ?></td>
                                                        <td>Rwf <?php echo " " . number_format($row['renewal_amount'], 2); ?></td>
                                                        <td><?php echo ucfirst($row['status']); ?></td>
                                                    </tr>
                                                <?php endwhile; ?>
                                            </tbody>

                                        <?php else: ?>
                                            <thead>
                                                <tr>
                                                    <th>Month</th>
                                                    <th>Total Compensation</th>
                                                    <th>Number of Claims</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php while ($row = $result->fetch_assoc()): ?>
                                                    <tr>
                                                        <td><?php echo $row['month']; ?></td>
                                                        <td>Rwf <?php echo " " . number_format($row['total_compensation'], 2); ?></td>
                                                        <td><?php echo $row['claim_count']; ?></td>
                                                    </tr>
                                                <?php endwhile; ?>
                                            </tbody>
                                        <?php endif; ?>
                                    </table>
                                </div>

                                <!-- Add PDF buttons -->
                                <div class="mt-3">
                                    <form method="POST" action="generate_pdf.php" target="_blank">
                                        <input type="hidden" name="reportType" value="<?php echo $reportType; ?>">
                                        <input type="hidden" name="startDate" value="<?php echo $startDate; ?>">
                                        <input type="hidden" name="endDate" value="<?php echo $endDate; ?>">

                                        <button type="submit" name="action" value="view" class="btn btn-primary mr-2">
                                            <i class="fas fa-eye"></i> View PDF
                                        </button>
                                        <button type="submit" name="action" value="download" class="btn btn-success">
                                            <i class="fas fa-download"></i> Download PDF
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    <?php
                        $stmt->close();
                    }
                    ?>
                </div>
            </div>

            <?php include "../views/layout/footer.php"; ?>
        </div>
    </div>

    <?php include "../views/layout/file_includes.php"; ?>
</body>

</html>