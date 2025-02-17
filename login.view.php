<?php require "includes/connection.php"; ?>

<main class="h-100 d-flex flex-column">

	<?php require "includes/header.view.php"; ?>

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
				<button type="submit" id="login" name="login" class="btn btn-lg btn-primary">Login</button>
			</form>
		</div>
	</div>

</main>

<?php
if (isset($_POST['login'])) {

	$email = $mysqli->real_escape_string($_POST['email']);
	$password = $mysqli->real_escape_string($_POST['password']);

	$queries = [
		// 'admin' => "SELECT * FROM admin WHERE username='$email' AND password='$password'",
		'employees' => "SELECT * FROM employees WHERE (username='$email' OR email='$email') AND password='$password'",
		'clients' => "SELECT * FROM clients WHERE (username='$email' OR email='$email') AND password='$password'"
	];

	foreach ($queries as $role => $query) {
		$result = $mysqli->query($query) or die($mysqli->error);
		if ($result->num_rows > 0) {
			$row = $result->fetch_array(MYSQLI_ASSOC) or die($mysqli->error);
			switch ($role) {
				// case 'admin':
				// 	$_SESSION['adminid'] = $row['ad_id'];
				// 	$redirectUrl = 'adminpage.php';
				// 	break;
				case 'employees':
					$_SESSION['employeeid'] = $row['emp_id'];
					$redirectUrl = './radiant-dashboard/views/index.php';
					break;
				case 'clients':
					$_SESSION['clientid'] = $row['id_client'];
					$redirectUrl = './radiant-dashboard/views/index.php';
					break;
			}
			$result->free_result();
			echo "<script>window.location.href = '$redirectUrl';</script>";
			exit();
		}
	}

	$msg = "Invalid username or password.";
	header("Location: login.view.php?error=" . urlencode($msg));
	exit();
}
