<?php
require_once "../../includes/connection.php";
require_once "../../vendor/autoload.php"; // Make sure you have TCPDF installed via composer

if (!isset($_SESSION['employeeid'])) {
    header("LOCATION: ../../index.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $reportType = $_POST['reportType'];
    $startDate = $_POST['startDate'];
    $endDate = $_POST['endDate'];

    // Create new PDF document using full namespace
    $pdf = new \TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

    // Set document information
    $pdf->SetCreator('Radiant Insurance');
    $pdf->SetAuthor('Radiant Insurance');
    $pdf->SetTitle(ucfirst(str_replace('_', ' ', $reportType)) . ' Report');

    // Remove header/footer
    $pdf->setPrintHeader(false);
    $pdf->setPrintFooter(false);

    // Add a page
    $pdf->AddPage();

    // Set font
    $pdf->SetFont('helvetica', '', 12);

    // Title
    $pdf->Cell(0, 10, ucfirst(str_replace('_', ' ', $reportType)) . ' Report', 0, 1, 'C');
    $pdf->Cell(0, 10, "Period: $startDate to $endDate", 0, 1, 'C');
    $pdf->Ln(10);

    // Reuse the same query logic from generate_report.php
    $query = "";
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

        default:
            $query = "";
            break;
    }

    if ($query !== "") {
        $stmt = $mysqli->prepare($query);
        if ($stmt) {
            $stmt->bind_param("ss", $startDate, $endDate);
            $stmt->execute();
            $result = $stmt->get_result();

            // Generate table content based on report type
            if ($reportType === 'claims') {
                $header = ['Claim ID', 'Client Name', 'Date Filed', 'Amount', 'Status'];
                $pdf->SetFont('helvetica', 'B', 11);
                $w = [30, 50, 35, 35, 30];

                // Header
                foreach ($header as $i => $col) {
                    $pdf->Cell($w[$i], 7, $col, 1, 0, 'C');
                }
                $pdf->Ln();

                // Data
                $pdf->SetFont('helvetica', '', 10);
                while ($row = $result->fetch_assoc()) {
                    $pdf->Cell($w[0], 6, $row['claim_id'], 1);
                    $pdf->Cell($w[1], 6, ucfirst($row['firstname']) . ' ' . ucfirst($row['lastname']), 1);
                    $pdf->Cell($w[2], 6, $row['date_filed'], 1);
                    $pdf->Cell($w[3], 6, 'Rwf ' . ($row['claim_amount'] !== null ? number_format($row['claim_amount'], 2) : '0.00'), 1);
                    $pdf->Cell($w[4], 6, ucfirst($row['status']), 1);
                    $pdf->Ln();
                }
            } elseif ($reportType === 'renewals') {
                $header = ['Renewal ID', 'Client Name', 'Renewal Date', 'Renewal Amount', 'Status'];
                $pdf->SetFont('helvetica', 'B', 11);
                $w = [30, 50, 35, 35, 30];

                // Header
                foreach ($header as $i => $col) {
                    $pdf->Cell($w[$i], 7, $col, 1, 0, 'C');
                }
                $pdf->Ln();

                // Data 
                $pdf->SetFont('helvetica', '', 10);
                while ($row = $result->fetch_assoc()) {
                    $pdf->Cell($w[0], 6, $row['renewal_id'], 1);
                    $pdf->Cell($w[1], 6, ucfirst($row['firstname']) . ' ' . ucfirst($row['lastname']), 1);
                    $pdf->Cell($w[2], 6, $row['date_filed'], 1);
                    $pdf->Cell($w[3], 6, 'Rwf ' . ($row['renewal_amount'] !== null ? number_format($row['renewal_amount'], 2) : '0.00'), 1);
                    $pdf->Cell($w[4], 6, ucfirst($row['status']), 1);
                    $pdf->Ln();
                }
            }

            $stmt->close();
        }
    }

    // Output PDF
    if ($_POST['action'] === 'download') {
        $pdf->Output(strtolower($reportType) . '_report.pdf', 'D');
    } else {
        $pdf->Output(strtolower($reportType) . '_report.pdf', 'I');
    }
}
