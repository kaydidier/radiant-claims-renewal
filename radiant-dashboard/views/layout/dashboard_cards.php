<div class="row">

    <!-- New Clients Card Example -->
    <?php
    $new_clients_query = "SELECT COUNT(*) as total_clients FROM clients WHERE created_at >= CURDATE()";
    $new_clients_result = $mysqli->query($new_clients_query);
    $new_clients = $new_clients_result->fetch_assoc();
    ?>

    <?php if (isset($_SESSION['employeeid'])): ?>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                <a href="../views/clients.php" class="text-primary">New Clients</a>
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $new_clients['total_clients']; ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-user-plus fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <!-- Total renewals Card Example -->
    <?php
    $total_renewals_query = "SELECT COUNT(*) as total_renewals FROM renewals";
    $total_renewals_result = $mysqli->query($total_renewals_query);
    $total_renewals = $total_renewals_result->fetch_assoc();
    ?>
    <?php if (isset($_SESSION['employeeid'])): ?>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Total Renewals
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $total_renewals['total_renewals']; ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-file-alt fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <!-- Total Claims Card Example -->
    <?php
    $total_claims_query = "SELECT COUNT(*) as total_claims FROM claim";
    $total_claims_result = $mysqli->query($total_claims_query);
    $total_claims = $total_claims_result->fetch_assoc();
    ?>
    <?php if (isset($_SESSION['employeeid'])): ?>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Total Claims
                            </div>
                            <div class="row no-gutters align-items-center">
                                <div class="col-auto">
                                    <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800"><?php echo $total_claims['total_claims']; ?></div>
                                </div>
                                <div class="col">
                                    <div class="progress progress-sm mr-2">
                                        <div class="progress-bar bg-info" role="progressbar"
                                            style="width: 75%" aria-valuenow="75" aria-valuemin="0"
                                            aria-valuemax="100"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-check-circle fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
    <!-- Active Renewals Card Example -->
    <?php
    $active_renewals_query = "SELECT COUNT(*) as total_active_renewals FROM renewals WHERE status = 'requested'";
    $active_renewals_result = $mysqli->query($active_renewals_query);
    $active_renewals = $active_renewals_result->fetch_assoc();
    ?>
    <?php if (isset($_SESSION['employeeid'])): ?>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Pending Renewals
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $active_renewals['total_active_renewals']; ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-sync-alt fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>

<?php
// Start of Selection
if (isset($_SESSION['employeeid'])) {
    $pending_claims_query = "SELECT COUNT(*) as total_pending_claims FROM claim WHERE status = 'pending'";
    $approved_claims_query = "SELECT COUNT(*) as total_approved_claims FROM claim WHERE status = 'approved'";
    $rejected_claims_query = "SELECT COUNT(*) as total_rejected_claims FROM claim WHERE status = 'declined'";
    $rejected_renewals_query = "SELECT COUNT(*) as total_rejected_renewals FROM renewals WHERE status = 'declined'";
    $pending_renewals_query = "SELECT COUNT(*) as total_pending_renewals FROM renewals WHERE status = 'requested'";
    $approved_renewals_query = "SELECT COUNT(*) as total_approved_renewals FROM renewals WHERE status = 'approved'";
} elseif (isset($_SESSION['clientid'])) {
    $client_id = $_SESSION['clientid'];
    $pending_claims_query = "SELECT COUNT(*) as total_pending_claims FROM claim WHERE status = 'pending' AND id_client = '$client_id'";
    $approved_claims_query = "SELECT COUNT(*) as total_approved_claims FROM claim WHERE status = 'approved' AND id_client = '$client_id'";
    $rejected_claims_query = "SELECT COUNT(*) as total_rejected_claims FROM claim WHERE status = 'declined' AND id_client = '$client_id'";
    $rejected_renewals_query = "SELECT COUNT(*) as total_rejected_renewals FROM renewals WHERE status = 'declined' AND id_client = '$client_id'";
    $pending_renewals_query = "SELECT COUNT(*) as total_pending_renewals FROM renewals WHERE status = 'requested' AND id_client = '$client_id'";
    $approved_renewals_query = "SELECT COUNT(*) as total_approved_renewals FROM renewals WHERE status = 'approved' AND id_client = '$client_id'";
}

$pending_claims_result = $mysqli->query($pending_claims_query);
$pending_claims = $pending_claims_result->fetch_assoc();

$approved_claims_result = $mysqli->query($approved_claims_query);
$approved_claims = $approved_claims_result->fetch_assoc();

$rejected_claims_result = $mysqli->query($rejected_claims_query);
$rejected_claims = $rejected_claims_result->fetch_assoc();

$rejected_renewals_result = $mysqli->query($rejected_renewals_query);
$rejected_renewals = $rejected_renewals_result->fetch_assoc();

$pending_renewals_result = $mysqli->query($pending_renewals_query);
$pending_renewals = $pending_renewals_result->fetch_assoc();

$approved_renewals_result = $mysqli->query($approved_renewals_query);
$approved_renewals = $approved_renewals_result->fetch_assoc();
?>

<div class="row">
    <!-- Pending Claims Card Example -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            <a href="../views/claims.php" class="text-primary">Pending Claims</a>
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $pending_claims['total_pending_claims']; ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-hourglass-half fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Approved Claims Card Example -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                            <a href="../views/claims.php" class="text-success">Approved Claims</a>
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $approved_claims['total_approved_claims']; ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-check-circle fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Rejected Claims Card Example -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-danger shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                            <a href="../views/claims.php" class="text-danger">Rejected Claims</a>
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $rejected_claims['total_rejected_claims']; ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-times-circle fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Total Claims Card Example -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-danger shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                            <a href="../views/renewals.php" class="text-danger">Rejected Renewals</a>
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $rejected_renewals['total_rejected_renewals']; ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-times-circle fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
if (isset($_SESSION['employeeid'])) {
    // Fetch data for employees
    $claims_status_query = "SELECT 
                                SUM(CASE WHEN status = 'approved' THEN 1 ELSE 0 END) as approved_claims,
                                SUM(CASE WHEN status = 'declined' THEN 1 ELSE 0 END) as declined_claims,
                                SUM(CASE WHEN status = 'pending' THEN 1 ELSE 0 END) as pending_claims
                            FROM claim";
    $claims_status_result = $mysqli->query($claims_status_query);
    $claims_status = $claims_status_result->fetch_assoc();

    $renewals_status_query = "SELECT 
                                SUM(CASE WHEN status = 'approved' THEN 1 ELSE 0 END) as approved_renewals,
                                SUM(CASE WHEN status = 'declined' THEN 1 ELSE 0 END) as declined_renewals,
                                SUM(CASE WHEN status = 'requested' THEN 1 ELSE 0 END) as pending_renewals
                            FROM renewals";
    $renewals_status_result = $mysqli->query($renewals_status_query);
    $renewals_status = $renewals_status_result->fetch_assoc();
} elseif (isset($_SESSION['clientid'])) {
    // Fetch data for clients
    $client_id = $_SESSION['clientid'];
    $claims_status_query = "SELECT 
                                SUM(CASE WHEN status = 'approved' THEN 1 ELSE 0 END) as approved_claims,
                                SUM(CASE WHEN status = 'declined' THEN 1 ELSE 0 END) as declined_claims,
                                SUM(CASE WHEN status = 'pending' THEN 1 ELSE 0 END) as pending_claims
                            FROM claim
                            WHERE id_client = $client_id";
    $claims_status_result = $mysqli->query($claims_status_query);
    $claims_status = $claims_status_result->fetch_assoc();

    $renewals_status_query = "SELECT 
                                SUM(CASE WHEN status = 'approved' THEN 1 ELSE 0 END) as approved_renewals,
                                SUM(CASE WHEN status = 'declined' THEN 1 ELSE 0 END) as declined_renewals,
                                SUM(CASE WHEN status = 'requested' THEN 1 ELSE 0 END) as pending_renewals
                            FROM renewals
                            WHERE id_client = $client_id";
    $renewals_status_result = $mysqli->query($renewals_status_query);
    $renewals_status = $renewals_status_result->fetch_assoc();
}
?>

<div class="row">
    <!-- Claims Status Chart -->
    <div class="col-xl-6 col-lg-7">
        <div class="card shadow mb-4">
            <!-- Card Header - Dropdown -->
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Claims Status</h6>
                <div class="dropdown no-arrow">
                    <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink">
                        <div class="dropdown-header">Options:</div>
                        <a class="dropdown-item" href="#">View Details</a>
                        <a class="dropdown-item" href="#">Export Data</a>
                    </div>
                </div>
            </div>
            <!-- Card Body -->
            <div class="card-body">
                <div class="chart-pie pt-4 pb-2">
                    <canvas id="claimsStatusChart"></canvas>
                </div>
                <div class="mt-4 text-center small">
                    <span class="mr-2">
                        <i class="fas fa-circle text-success"></i> Approved: <?php echo $claims_status['approved_claims']; ?>
                    </span>
                    <span class="mr-2">
                        <i class="fas fa-circle text-danger"></i> Rejected: <?php echo $claims_status['declined_claims']; ?>
                    </span>
                    <span class="mr-2">
                        <i class="fas fa-circle text-warning"></i> Pending: <?php echo $claims_status['pending_claims']; ?>
                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- Renewals Status Chart -->
    <div class="col-xl-6 col-lg-7">
        <div class="card shadow mb-4">
            <!-- Card Header - Dropdown -->
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Renewals Status</h6>
                <div class="dropdown no-arrow">
                    <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink">
                        <div class="dropdown-header">Options:</div>
                        <a class="dropdown-item" href="#">View Details</a>
                        <a class="dropdown-item" href="#">Export Data</a>
                    </div>
                </div>
            </div>
            <!-- Card Body -->
            <div class="card-body">
                <div class="chart-bar">
                    <canvas id="renewalsStatusChart"></canvas>
                </div>
                <div class="mt-4 text-center small">
                    <span class="mr-2">
                        <i class="fas fa-circle text-success"></i> Approved: <?php echo $renewals_status['approved_renewals']; ?>
                    </span>
                    <span class="mr-2">
                        <i class="fas fa-circle text-danger"></i> Rejected: <?php echo $renewals_status['declined_renewals']; ?>
                    </span>
                    <span class="mr-2">
                        <i class="fas fa-circle text-warning"></i> Pending: <?php echo $renewals_status['pending_renewals']; ?>
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- <script>
    document.addEventListener('DOMContentLoaded', function() {
        if (typeof Chart !== 'undefined') {
            const chartConfig = (ctx, data, label) => {
                return new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: ["Approved", "Rejected", "Pending"],
                        datasets: [{
                            label: label,
                            data: data,
                            backgroundColor: ['#1cc88a', '#e74a3b', '#f6c23e'],
                            hoverBackgroundColor: ['#17a673', '#e02d1b', '#f4b619'],
                            borderColor: "#4e73df",
                        }],
                    },
                    options: {
                        maintainAspectRatio: false,
                        layout: {
                            padding: {
                                left: 10,
                                right: 25,
                                top: 25,
                                bottom: 0
                            }
                        },
                        scales: {
                            x: {
                                grid: {
                                    display: false,
                                    drawBorder: false
                                },
                                ticks: {
                                    maxTicksLimit: 6
                                },
                                maxBarThickness: 25,
                            },
                            y: {
                                ticks: {
                                    min: 0,
                                    max: 100,
                                    maxTicksLimit: 5,
                                    padding: 10,
                                    callback: function(value) {
                                        return number_format(value);
                                    }
                                },
                                grid: {
                                    color: "rgb(234, 236, 244)",
                                    zeroLineColor: "rgb(234, 236, 244)",
                                    drawBorder: false,
                                    borderDash: [2],
                                    zeroLineBorderDash: [2]
                                }
                            },
                        },
                        plugins: {
                            legend: {
                                display: false
                            },
                            tooltip: {
                                titleMarginBottom: 10,
                                titleColor: '#6e707e',
                                titleFont: {
                                    size: 14
                                },
                                backgroundColor: "rgb(255,255,255)",
                                bodyColor: "#858796",
                                borderColor: '#dddfeb',
                                borderWidth: 1,
                                padding: 15,
                                displayColors: false,
                                caretPadding: 10,
                                callbacks: {
                                    label: function(tooltipItem) {
                                        var datasetLabel = tooltipItem.dataset.label || '';
                                        return datasetLabel + ': ' + number_format(tooltipItem.raw);
                                    }
                                }
                            }
                        }
                    }
                });
            };

            const claimsData = [<?php echo $approved_claims['total_approved_claims']; ?>, <?php echo $rejected_claims['total_rejected_claims']; ?>, <?php echo $pending_claims['total_pending_claims']; ?>];
            const renewalsData = [<?php echo $approved_renewals['total_approved_renewals']; ?>, <?php echo $rejected_renewals['total_rejected_renewals']; ?>, <?php echo $pending_renewals['total_pending_renewals']; ?>];

            const claimsCtx = document.getElementById("claimsStatusChart").getContext('2d');
            chartConfig(claimsCtx, claimsData, "Claims");

            const renewalsCtx = document.getElementById("renewalsStatusChart").getContext('2d');
            chartConfig(renewalsCtx, renewalsData, "Renewals");
        } else {
            console.error("Chart.js library is not loaded.");
        }
    });
</script> -->

<script>
  const ctx = document.getElementById('claimsStatusChart');
  const ctx2 = document.getElementById('renewalsStatusChart');

  const claimChartData = {
    labels: ['Approved', 'Rejected', 'Pending'],
    datasets: [{
      label: 'Claims Status',
      data: [<?php echo $approved_claims['total_approved_claims']; ?>, <?php echo $rejected_claims['total_rejected_claims']; ?>, <?php echo $pending_claims['total_pending_claims']; ?>],
      borderWidth: 1,
      backgroundColor: ['#1cc88a', '#e74a3b', '#f6c23e'],
      hoverBackgroundColor: ['#17a673', '#e02d1b', '#f4b619'],
      borderColor: "#4e73df",
    }]
  };

  const renewalsChartData = {
    labels: ['Approved', 'Rejected', 'Pending'],
    datasets: [{
      label: 'Renewals Status',
      data:  [<?php echo $approved_renewals['total_approved_renewals']; ?>, <?php echo $rejected_renewals['total_rejected_renewals']; ?>, <?php echo $pending_renewals['total_pending_renewals']; ?>],
      borderWidth: 1,
      backgroundColor: ['#1cc88a', '#e74a3b', '#f6c23e'],
      hoverBackgroundColor: ['#17a673', '#e02d1b', '#f4b619'],
      borderColor: "#4e73df",
    }]
  };

  const chartOptions = {
    scales: {
      y: {
        beginAtZero: true,
        max: 100,
        min: 0,
        ticks: {
          stepSize: 20
        }
      }
    }
  };

  new Chart(ctx, {
    type: 'bar',
    data: claimChartData,
    options: chartOptions
  });

  new Chart(ctx2, {
    type: 'bar',
    data: renewalsChartData,
    options: chartOptions
  });
</script>