<?php include("includes/connection.php"); ?>

<!-- <div id="login"> -->
<!-- <form method="POST">
			 <table id="lg">
				<tr>
					<td>
						<p id='tt' align="center">Login Here To Continue</p>
					</td>
				</tr>
				<tr>
					<td><input type="text" name="uname" placeholder="enter Username" required></td>
				</tr>
				<tr>
					<td><input type="password" name="pass" placeholder="enter Password" required></td>
				</tr>
				<tr>
					<td colspan="2" align="center">
						<input type="submit" name="login" value="Login">


				</tr>
				<tr><td align="center"><a href="aaa"><p id="sa">Forget Password</p></a></td></tr>
			<?php
			// if (isset($_POST['login'])) {
			// 	$ab = $_POST['uname'];
			// 	$bc = $_POST['pass'];
			// 	$a = mysql_real_escape_string($ab);
			// 	$b = mysql_real_escape_string($bc);
			// 	$sql1 = mysql_query("SELECT * FROM admin where username='$a'and password='$b'") or die(mysql_error());
			// 	$sql2 = mysql_query("SELECT * FROM employees  where username='$a' and password='$b'") or die(mysql_error());
			// 	$sql3 = mysql_query("SELECT * FROM clients where username='$a' and password='$b'") or die(mysql_error());
			// 	//var_dump($row1);
			// 	if (mysql_num_rows($sql1) > 0) {
			// 		$rowid = mysql_fetch_array($sql1);
			// 		$_SESSION['adminid'] = $rowid['ad_id'];
			// 		header("location:employees.php");
			// 	} else {
			// 		if (mysql_num_rows($sql2) > 0) {
			// 			$rowid = mysql_fetch_array($sql2) or die(mysql_error());
			// 			$_SESSION['employeeid'] = $rowid['emp_id'];
			// 			header("location:emppage.php");
			// 		} else {
			// 			if (mysql_num_rows($sql3) > 0) {
			// 				$rowid = mysql_fetch_array($sql3) or die(mysql_error());
			// 				$_SESSION['clientid'] = $rowid['id_client'];
			// 				header("location:clientpage.php");
			// 			} else {
			// 				echo $msg = "<center><tr><td colspan='4' id='nop'>enter your Username or<br>password which is correct</td></tr></center>";
			// 				//header("location:index.php");
			// 			}
			// 		}
			// 	}
			// }
			?>
			</table> 
			<div id="forgot">

				<table id="lg">
					<tr>
						<td>
							<p id='bc' align="center">Forgot your Password</p>
						</td>
					</tr>
					<tr>
						<td><input type="text" name="uname" placeholder="enter your idno" required></td>
					</tr>
					<tr>
						<td><input type="password" name="pass" placeholder="enter your email" required></td>
					</tr>
					<tr>
						<td colspan="2" align="center">
							<input type="submit" name="login" value="Forgot">
						</td>
					</tr>
				</table>
			</div>
		</form> -->
<!-- </div> -->


<? include("includes/header.php"); ?>

<main class="h-100 d-flex flex-column">

	<div id="" class="w-100">

		<section class="d-flex position-relative" id="hero">

			<div class="w-100 bg-opacity-50 md:bg-opacity-75">
				<img src="./images/radiant-hero.jpg" class="img-fluid opacity-75" alt="" style="height: 700px; width: 100%; object-fit: cover;" />
			</div>

			<div class="d-flex flex-column w-100 text-center text-white position-absolute bottom-0">
				<p class="fs-4">Get Radiant Insurance Company's services easily</p>

				<p class="fs-4">We help with insurance claims and renewals, making everything simple and stress-free</p>

				<div class="py-4">
					<a href="./login.php" class="text-decoration-none text-white">
						<button type="button" class="btn btn-primary py-3" style="width: 200px; background-color: #0F95BD; border: #0F75BD;">
							Get started
						</button>
					</a>
				</div>
			</div>
		</section>


		<section class="container py-4" id="about">
		<p class="text-center font-bold">About Us</p>
			<p class="p-4">Radiant Insurance Company (Nyamirambo Branch) offers a wide range of services, including insurance claims, policy renewals, and new insurance coverage. Our goal is to provide our clients with high-quality, reliable services that make managing their insurance easy and stress-free. We put our clients at the forefront, ensuring that their needs are met with professionalism and care.

				Our experienced team is dedicated to guiding you through every step of the process, from filing claims to finding the right coverage for yourneeds. At Radiant Insurance Company, we are committed to delivering excellent customer service and building long-lasting relationships with ourclients. We strive to make your insurance experience smooth, transparent, and tailored to your individual needs.</p>
		</section>

		<section class="container d-flex flex-column justify-content-center py-4" id="services">
		<p class="text-center font-bold">Services</p>
		
		<div class="d-flex">
			<div class="border p-4 rounded m-3 bg-light hover:bg-dark" style="cursor: pointer; ">
				<p>Insurance Claims</p>
				<p>Trust our reliable insurance claims service to guide you through the process smoothly. We ensure fast, efficient support to help you get the compensation you deserve, with no stress or delays.</p>
			</div>
			<div class="border p-4 rounded m-3 bg-light hover:bg-dark" style="cursor: pointer; ">
				<p>Insurance Renewal</p>
				<p>Stay covered with our easy insurance renewals service. We help you renew your policies on time, ensuring continued protection and saving you from unnecessary hassle or interruptions in your coverage.</p>
			</div>
			<div class="border p-4 rounded m-3 bg-light hover:bg-dark" style="cursor: pointer; ">
				<p>New Insurance</p>
				<p>Easily request new insurance through our system. Whether it's for motor, medical, or agriculture, we help you find the right coverage quickly and efficiently, with a smooth and straightforward process.</p>
			</div>
		</div>
		</section>

	</div>


	<?php include("includes/footer.php") ?>
</main>
