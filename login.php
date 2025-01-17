<? include "includes/connection.php";
// session_start();
?>


<main class="h-100 d-flex flex-column">

	<? include "includes/header.php"; ?>

	<div id="login" class="container h-100 d-flex flex-column align-items-center justify-content-center">
		<div class="col-12 col-lg-6 bg-light p-5 border rounded">
			<p class="fw-bold fs-5">Continue to your account </p>
			<form class="">
				<div class="mb-3">
					<label for="email" class="form-label">Email address</label>
					<input type="email" class="form-control" id="email" aria-describedby="emailHelp">
				</div>
				<div class="mb-3">
					<label for="password" class="form-label">Password</label>
					<input type="password" class="form-control" id="password">
				</div>
				<button type="submit" class="btn btn-primary">Login</button>
			</form>
		</div>
	</div>

</main>


<?php
// if (isset($_POST['login'])) {
// 	$ab = $_POST['uname'];
// 	$bc = $_POST['pass'];
// 	$a = mysqli_real_escape_string($ab);
// 	$b = mysqli_real_escape_string($bc);
// 	$sql1 = mysqli_query("SELECT * FROM admin where username='$a'and password='$b'") or die(mysqli_error());
// 	$sql2 = mysqli_query("SELECT * FROM employees  where username='$a' and password='$b'") or die(mysqli_error());
// 	$sql3 = mysqli_query("SELECT * FROM clients where username='$a' and password='$b'") or die(mysqli_error());
// 	//var_dump($row1);

// 	if (mysqli_num_rows($sql1) > 0) {
// 		$rowid = mysqli_fetch_array($sql1);
// 		$_SESSION['adminid'] = $rowid['ad_id'];
// 		header("location:adminpage.php");
// 	} else {
// 		if (mysqli_num_rows($sql2) > 0) {
// 			$rowid = mysqli_fetch_array($sql2) or die(mysqli_error());
// 			$_SESSION['employeeid'] = $rowid['emp_id'];
// 			header("location:emppage.php");
// 		} else {
// 			if (mysqli_num_rows($sql3) > 0) {
// 				$rowid = mysqli_fetch_array($sql3) or die(mysqli_error());
// 				$_SESSION['clientid'] = $rowid['id_client'];
// 				header("location:clientpage.php");
// 			} else {
// 				$msg = "<tr><td colspan='2'>enter your Username or<br>password which is correctly</td></tr>";
// 				header("location:index.php");
// 			}
// 		}
// 	}
// }
?>