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

                    <h1 class="h3 mb-2 text-gray-800">Reports</h1>
                    <p class="mb-4">Generate reports to analyze insurance data.</p>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card shadow mb-4">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-primary">Generate Reports</h6>
                            </div>
                            <div class="card-body">
                                <form method="POST" action="generate_report.php">
                                    <div class="form-group">
                                        <label for="reportType">Select Report Type</label>
                                        <select class="form-control" id="reportType" name="reportType" onchange="toggleFields()" required>
                                            <option value="claims">Claims (Per dates)</option>
                                            <option value="renewals">Renewals (Per dates)</option>
                                            <option value="compensation_3_months">Amount of money compensated to the clients (Per 3 months)</option>
                                            <option value="compensation_6_months">Amount of money compensated to the clients (Per 6 months)</option>
                                        </select>
                                    </div>
                                    <div class="form-group" id="stDateDiv">
                                        <label for="startDate">Start Date</label>
                                        <input type="date" class="form-control" id="startDate" name="startDate">
                                    </div>
                                    <div class="form-group" id="edDateDiv">
                                        <label for="endDate">End Date</label>
                                        <input type="date" class="form-control" id="endDate" name="endDate">
                                    </div>
                                    <button type="submit" class="btn btn-primary">Generate Report</button>
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

function toggleFields() {
const reportTypeSelect = document.getElementById('reportType');
const endDateDiv = document.getElementById('stDateDiv');
const startDateDiv = document.getElementById('edDateDiv');
const startDtinput = document.getElementById('startDate');
const endDtinput = document.getElementById('endDate');

const selectedReport = reportTypeSelect.options[reportTypeSelect.selectedIndex].text;

if (selectedReport.toLowerCase().trim().includes('months')) {
    endDateDiv.style.display = 'none';
    startDateDiv.style.display = 'none';

    if (selectedReport.toLowerCase().trim().includes('3months')) {
    startDtinput.value = formatDate(new Date()); // Set today as start date
    endDtinput.value = formatDate(addMonths(new Date(), 3)); // Add 3 months
} else {
    startDtinput.value = formatDate(new Date()); // Set today as start date
    endDtinput.value = formatDate(addMonths(new Date(), 6)); // Add 6 months
}
} else {
    endDateDiv.style.display = 'block';
    startDateDiv.style.display = 'block';
}
}
// Function to add months to a date
function addMonths(date, months) {
    let newDate = new Date(date);
    newDate.setMonth(newDate.getMonth() + months);
    return newDate;
}

// Function to format date as YYYY-MM-DD for input[type="date"]
function formatDate(date) {
    return date.toISOString().split('T')[0];
}
</script>

</body>

</html>