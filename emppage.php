<?php
require "includes/connection.php";

if (!$_SESSION['employeeid']) {
	header("LOCATION:index.php");
}
?>

<!DOCTYPE html>
<html>

<head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title>Radiant Insurance Claimns and Renewal System</title>

        <script src="js/jquery.js"></script>
        <script src="js/jquery-ui.js"></script>

        <link rel="stylesheet" href="css/jquery-ui.css">

        <link rel="shortcut icon" href="../insurance/logo.png">
        <link rel="stylesheet" type="text/css" href="../cssweb/file.css">
        <link rel="stylesheet" type="text/css" href="../cssweb/dropdown.css">

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    </head>
<body>

	<? include "./includes/views/sidenav.view.php" ?>
	
	<form method="POST">
		<?
		$sql = mysqli_query($mysqli, "SELECT * FROM employees WHERE emp_id={$_SESSION['employeeid']}") or die(mysqli_error($mysqli));
		$rowname = mysqli_fetch_array($sql);
		?>

		<div id="navbar">
			<ul>
				<li><a href="#">Home</a></li>
				<li><a href="#">Clients</a>
					<ul>
						<li><a href="clientreg.php?action=add">New</a></li>
						<li><a href="empclient.php">View</a></li>
					</ul>
				</li>
				<li><a href="upgrades.php">Upgrades</a></li>
				<li><a href="claimed.php">claimed</a></li>
				<li><a href="ansfeed.php">Feedback</a></li>
				<!--<li><a href="#">Products</a></li>-->
				<li><a href="logout.php" id="show">Logout</a></li>
			</ul>
		</div>
	</form>
	<center>
		<div id="emppa">
			<p>Welcome&nbsp<?= $rowname['username']; ?>&nbsp
				Here you can register client and you can manage clients and then you give username and password to the
				clients and you can view all clients which make claim and then you give answer(feedback)
				and you can view all clients who make upgrades and then you can confirm it or deny it his/her upgrades
	</center>
	</div>
</body>

</html>

<?php require("includes/footer.view.php"); ?>