<? require "includes/connection.php"; ?>

<main class="h-100 d-flex flex-column">

	<? require "includes/header.view.php"; ?>

	<div id="login" class="container h-100 d-flex flex-column align-items-center justify-content-center">
		<div class="col-12 col-lg-6 bg-light p-5 border rounded">
			<p class="fw-bold fs-5">Continue to your account </p>
			<form class="" method="POST">
				<div class="mb-3">
					<label for="email" class="form-label">Email address / Username</label>
					<input type="text" class="form-control" placeholder="Please enter your identification" id="email" name="email">
				</div>
				<div class="mb-3">
					<label for="password" class="form-label">Password</label>
					<input type="password" class="form-control" placeholder="Please enter your password" id="password" name="password">
				</div>
				<button type="submit" id="login" name="login" class="btn btn-primary">Login</button>
			</form>
		</div>
	</div>

</main>

<?php
if (isset($_POST['login'])) {

	$email = $mysqli->real_escape_string($_POST['email']);
	$password = $mysqli->real_escape_string($_POST['password']);

	$sql1 = $mysqli->query("SELECT * FROM admin where username='$email' and password='$password'") or die($mysqli->error);
	$sql2 = $mysqli->query("SELECT * FROM employees  where username='$email' or email='$email'  and password='$password'") or die($mysqli->error);
	$sql3 = $mysqli->query("SELECT * FROM clients where username='$email' or email='$email'  and password='$password'") or die($mysqli->error);

	if ($sql1->num_rows > 0) {
		$rowid = $sql1->fetch_array(MYSQLI_ASSOC) or die($mysqli->error);

		$_SESSION['adminid'] = $rowid['ad_id'];
		$sql1->free_result();

		// header("Location: adminpage.php");
		echo "<script>window.location.href = 'adminpage.php';</script>";
		exit();
	} elseif ($sql2->num_rows > 0) {
		$rowid = $sql2->fetch_array(MYSQLI_ASSOC) or die($mysqli->error);

		$_SESSION['employeeid'] = $rowid['emp_id'];
		$sql2->free_result();
		
		// header("Location: emppage.php");
		echo "<script>window.location.href = 'radiant-dashboard/views/index.view.php';</script>";
		exit();
	} elseif ($sql3->num_rows > 0) {
		$rowid = $sql3->fetch_array(MYSQLI_ASSOC) or die($mysqli->error);

		$_SESSION['clientid'] = $rowid['id_client'];
		$sql3->free_result();

		// header("Location: clientpage.php");
		echo "<script>window.location.href = 'clientpage.php';</script>";
		exit();
	} else {
		$msg = "Invalid username or password.";
		header("Location: index.php?error=" . urlencode($msg));
		exit();
	}
}
