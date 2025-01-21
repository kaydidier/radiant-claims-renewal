<?php
require "includes/connection.php";
if (!$_SESSION['adminid']) {
	header("LOCATION:index.php");
}
//var_dump($_SESSION['adminid']);
//create connectionmysql_select_db("vis");//to select from the db
//if (!$_SESSION['admin']) {
//header("location:login.php");
//}

?>
<html>

<head>
	<title>Radiant insurance company</title>
	<link rel="shortcut icon" href="insurance/LOGO.png">
	<link rel="stylesheet" type="text/css" href="cssweb/dropdown.css">
	<link rel="stylesheet" type="text/css" href="cssweb/file.css">
	<script src="js/jquery.js"></script>
	<script src="js/jquery-ui.js"></script>
	<link rel="stylesheet" href="css/jquery-ui.css">

</head>

<body>
	<?php include("includes/header.view.php"); ?>
	<form method="POST" action="">
		<?php
		$sql = mysqli_query($mysqli, "SELECT * FROM admin WHERE ad_id={$_SESSION['adminid']}") or die(mysqli_error($mysqli));
		$rowname = mysqli_fetch_array($sql);
		?>
		<div id="navbar">
			<ul>
				<li><a href="employees.php">Home</a></li>
				<li><a href="clients.php">Clients</a></li>
				<li><a href="">Employees</a>
					<ul>
						<li><a href="addemployee.php">New</a></li>
						<li><a href="employees.php">View</a></li>
					</ul>
				</li>
				<li><a href="insurance.php">Insurances</a></li>

				<li><a href="logout.php" id="show">Logout</a></li>
			</ul>
		</div>
	</form>

	<div id="adp">
		<p>Welcome <?= $rowname['username']; ?>&nbsp
			Here you can register new employee and you can manage all employees
			and clients of Radiant Insurance Company and you can get Daily report</p>
	</div>
</body>

</html>
<?php include("includes/footer.view.php"); ?>