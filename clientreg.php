<?php
require "includes/connection.php";
// session_start();
if (!$_SESSION['employeeid']) {
	header("LOCATION:index.php");
}

// Register Client
if (isset($_POST['save'])) {

	$a = mysqli_real_escape_string($mysqli, $_POST['fname']);
	$b = mysqli_real_escape_string($mysqli, $_POST['lname']);
	$c = mysqli_real_escape_string($mysqli, $_POST['uname']);
	$d = mysqli_real_escape_string($mysqli, $_POST['pass']);
	$e = mysqli_real_escape_string($mysqli, $_POST['email']);
	$v = mysqli_real_escape_string($mysqli, $_POST['sexa']);
	$f = mysqli_real_escape_string($mysqli, $_POST['dob']);
	$g = mysqli_real_escape_string($mysqli, $_POST['sector']);
	$h = mysqli_real_escape_string($mysqli, $_POST['district']);
	$i = mysqli_real_escape_string($mysqli, $_POST['province']);
	$j = mysqli_real_escape_string($mysqli, $_POST['phone']);
	$k = mysqli_real_escape_string($mysqli, $_POST['idno']);

	$sql = "INSERT INTO clients VALUES (NULL, '$a', '$b', '$c', '$d', '$e', '$f','$v', '$g', '$h', '$i','$j','$k',{$_SESSION['employeeid']})";
	$sq = "SELECT * FROM clients WHERE email='$e' or phone='$j' or ID_no='$k'";

	$query = mysqli_query($mysqli, $sq) or die(mysqli_error($mysqli));
	if (
		empty($a) or empty($b) or empty($c) or empty($d) or empty($e) or empty($v)
		or empty($f) or empty($g) or empty($h) or empty($i) or empty($j) or empty($k)
	) {
		echo "<script type='text/javascript'>alert('empty fields');</script>";
	} else if (mysqli_num_rows($query) > 0) {
		$rowquery = mysqli_fetch_array($query);

		if ($rowquery['email'] == $e || $rowquery['phone'] == $j) {

			echo "<script type='text/javascript'>alert('Information Saved Before');</script>";
		}
	} else {
		//check if date of birth is valid
		if ($f > date("Y-m-d", (time() - (18 * 365 * 24 * 60 * 60)))) {
			echo "<script type='text/javascript'>alert('Only People above 18 years old are allowed to have vehicles');</script>";
		} else {
			$insert = mysqli_query($mysqli, $sql) or die(mysqli_error($mysqli));
			if ($insert) {
				$_SESSION['clientregistration'] = mysqli_insert_id($mysqli);
				echo "<script type='text/javascript'>alert('Successfully! Continue Give Client Insurance');
			window.location='initsession.php?clid=" . mysqli_insert_id($mysqli) . "';
			</script>";
?>
				<script type="text/javascript">
					alert("hello");
				</script>
			<?php


			} else {
				echo "<script type='text/javascript'>alert(' not inserted');</script>";
			}
		}
	}
}

// Register Moto
if (isset($_POST['motor']) and isset($_SESSION['clientregistration'])) {
	$plaque = mysqli_real_escape_string($mysqli, $_POST['plaque']);
	$model = mysqli_real_escape_string($mysqli, $_POST['model']);
	$description = mysqli_real_escape_string($mysqli, $_POST['description']);
	$photo = time() . $_FILES['photo']['name'];

	$insId = mysqli_real_escape_string($mysqli, $_POST['insid']);
	$price = mysqli_real_escape_string($mysqli, $_POST['price']);
	$sdate = $_POST['startdate'];
	$edate = $_POST['enddate'];

	if (mysqli_query($mysqli, "INSERT INTO cars VALUES(null,'$plaque','$model','$description','$photo',{$_SESSION['clientregistration']})") or die("here " . mysqli_error($mysqli))) {

		move_uploaded_file($_FILES['photo']['tmp_name'], "./images/cars\ " . $photo);
		$propertyid = mysqli_insert_id($mysqli);

		$insertdata = mysqli_query($mysqli, "INSERT INTO insured VALUES(null,'$sdate','$edate','$price','$insId',{$_SESSION['clientregistration']},'$propertyid','car')") or die("here 2:" . mysqli_error($mysqli));

		if ($insertdata) {
			unset($_SESSION['clientregistration']);
			header("location:clientprint.php?ppt=" . mysqli_insert_id($mysqli));
			?>
			<script type="text/javascript">
				alert("insurance added");
			</script>
		<?php
		}
	}
}

// Register House property
if (isset($_POST['house']) and isset($_SESSION['clientregistration'])) {
	$plotno = mysqli_real_escape_string($mysqli, $_POST['plotno']);
	$description = mysqli_real_escape_string($mysqli, $_POST['description']);
	$photo = time() . $_FILES['photo']['name'];
	$sdate = mysqli_real_escape_string($mysqli, $_POST['startdate']);
	$edate = mysqli_real_escape_string($mysqli, $_POST['enddate']);
	$insId = mysqli_real_escape_string($mysqli, $_POST['insid']);
	$price = mysqli_real_escape_string($mysqli, $_POST['price']);

	if (mysqli_query($mysqli, "INSERT INTO houses VALUES(null,'$plotno',{$_SESSION['clientregistration']},'$description','$photo')")) {
		move_uploaded_file($_FILES['photo']['tmp_name'], "./images/houses\ " . $photo);
		$propertyid = mysqli_insert_id($mysqli);
		$insertdata = mysqli_query($mysqli, "INSERT INTO insured VALUES(null,'$sdate','$edate','$price','$insId',{$_SESSION['clientregistration']},'$propertyid','house')") or die(mysqli_error($mysqli));
		if ($insertdata) {
			unset($_SESSION['clientregistration']);
			header("location:clientprint.php?ppt=" . mysqli_insert_id($mysqli));

		?>
			<script type="text/javascript">
				alert("insurance added");
			</script>
<?php
		}
	}
}

?>
<html>

<head>
	<title>Radiant insurance company</title>
	<link rel="shortcut icon" href="insurance/LOGO.png">
	<link rel="stylesheet" type="text/css" href="cssweb/dropdown.css">
	<link rel="stylesheet" type="text/css" href="cssweb/file.css">
	<script src="js/jquery.js"></script>
	<script src="js/jquery-ui.js"></script>
	<script type="text/javascript" src="js/script.js"></script>
	<link rel="stylesheet" href="css/jquery-ui.css">
	<script>
		$(document).ready(function() {

			$(".house").hide();
			$(".motor").hide();
			$("#dat").datepicker({
				dateFormat: "yy-mm-dd",
				changeMonth: true,
				changeYear: true,
				yearRange: "c-190:c+10",
			});
			$(".sdate").datepicker({
				dateFormat: "yy-mm-dd",
				changeMonth: true,
				changeYear: true,
				yearRange: "c-100:c+100",
				minDate: "<?= date("Y-m-d"); ?>"
			});

			$(".edate").datepicker({
				dateFormat: "yy-mm-dd",
				changeMonth: true,
				changeYear: true,
				yearRange: "c-100:c+100",
				minDate: "<?= date("Y-m-d"); ?>"
			});
			$('select[name="province"]').change(function() {
				var province = $(this).val();

				$("#districts").load("ajax/loadprovince.php?province=" + province);
			});
			$('select[name="type"]').change(function() {
				switch ($(this).val()) {
					case 'Motor':
						$(".house").hide();
						$(".motor").show();
						break;

					case 'Fire':
						$(".house").show();
						$(".motor").hide();
						break;
				}
			});
		});
	</script>
	<link rel="stylesheet" type="text/css" href="cssweb/clientreg.css">

</head>

<body>

	<br>

	<?php
	// include("includes/header.view.php");
	?>
	<div id="navbar">
		<ul>
			<li><a href="clientpage.php">Home</a></li>
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

	<?php
	if (isset($_GET['clid'])) {




	?>

		<div id="form" style="margin-left:20em; width:100%;float:left;">
			<div id="insurance-form">


				<table id="clienttable">
					<div id="insurancep">
						<p id="titi">Continue Registering by give client insurance</p>
						<tr>
							<td>
								insurance:</td>
							<td>&nbsp;&nbsp;
								<select name="type">
									<option>Select insurance please......</option>

									<?php
									$i = 1;
									$insurances = mysqli_query($mysqli, "SELECT * FROM insurance");
									while ($row = mysqli_fetch_array($insurances)) {
									?>

										<option value="<?php $a = explode(" ", $row['insurance_name']);
														echo $a[0]; ?>"><?php echo $row['insurance_name'] ?></option>
									<?php

									}
									?>

								</select>
							</td>
						</tr>
				</table>
			</div>
			<div class="motor">
				<form method="POST" action="" enctype="multipart/form-data">
					<table id="motor">
						<tr>
							<?php $insurances = mysqli_query($mysqli, "SELECT * FROM insurance where insurance_name='Motor insurance'");
							$insData = mysqli_fetch_array($insurances);
							?>
							<input type="hidden" name="insid" value="<?php echo $insData['insurance_id']; ?>">
						<tr>
							<td>start date:</td>
							<td><input type="text" name="startdate" class="sdate"></td>

						</tr>
						<tr>
							<td>end date:</td>
							<td><input type="text" name="enddate" class='edate'></td>
						</tr>
						<td>plateNumber:</td>
						<td><input type="text" name="plaque"></td>
						</tr>
						<tr>
							<td>model:</td>
							<td><input type="text" name="model"></td>
						</tr>
						<tr>
							<td>description:</td>
							<td><textarea name="description"></textarea></td>
						</tr>
						<tr>
							<td>photo:</td>
							<td><input type="file" name="photo"></td>
						</tr>
						<tr>
							<td>Price:</td>
							<td><input type="text" name="price">/RWF</td>
						</tr>
						<tr>
							<td colspan="2" align="center"><input type="submit" value="save" name="motor"></td>
						</tr>
					</table>
				</form>
			</div>

			<div class="house">
				<form method="POST" action="" enctype="multipart/form-data">
					<table id="fire">
						<?php $insurances = mysqli_query($mysqli, "SELECT * FROM insurance where insurance_name='Motor insurance'");
						$insData = mysqli_fetch_array($insurances);
						?>
						<input type="hidden" name="insid" value="<?php echo $insData['insurance_id']; ?>">
						<tr>
							<td>start date:</td>
							<td><input type="text" name="startdate" class="sdate" readonly></td>
						</tr>
						<tr>
							<td>end date:</td>
							<td><input type="text" name="enddate" class="edate" readonly></td>
						</tr>
						<tr>

							<td>Plot number:</td>
							<td><input type="text" name="plotno"></td>
						</tr>
						<tr>
							<td>description:</td>
							<td><textarea name="description"></textarea></td>
						</tr>
						<tr>
							<td>photo:</td>
							<td><input type="file" name="photo"></td>
						</tr>
						<tr>
							<td>Price:</td>
							<td><input type="text" name="price">/RWF</td>
						</tr>
						<tr>
							<td colspan="2">
								<center><input type="submit" value="save" name="house"></center>
							</td>
						</tr>
					</table>
				</form>
			</div>
			</form>
		</div>
		</div>
	<?php
	}
	?>
	<div id="insert" style="margin-left:20em;">

		<?php
		if (@$_GET['action'] == 'add') {


		?>
			<form method="POST" enctype="multipart/form-data">
				<center>
					<table>
						<p id="tit">
						<div align="center" id='Tips'>Register New Client Here</div>
						</p>
						<tr>
							<td>First-name:</td>
							<td><input type="text" name="fname" placeholder="enter firstname" value='<?= @$_POST['fname'] ?>' pattern="[A-Za-z']{2,30}"></td>
						</tr>
						<tr>
							<td>Last-name:</td>
							<td><input type="text" name="lname" placeholder="enter lastname" value='<?= @$_POST['lname'] ?>' pattern="[A-Za-z']{2,30}"></td>
						</tr>
						<tr>
							<td>Username:</td>
							<td><input type="text" name="uname" placeholder="enter Username" value='<?= @$_POST['uname'] ?>' pattern="[A-Za-z']{2,30}"></td>
						</tr>
						<tr>
							<td>Password:</td>
							<td><input type="password" name="pass" placeholder="enter Password"></td>
						</tr>
						<tr>
							<td>E-mail:</td>
							<td><input type="email" name="email" placeholder="enter E-mail" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,3}$" value='<?= @$_POST['email'] ?>'></td>
						</tr>
						<tr>
							<td>Date-of-Birth:</td>
							<td><input type="text" name="dob" id="dat" placeholder="enter DateofBirth" value='<?= @$_POST['dob'] ?>'></td>
						</tr>
						<tr>
							<td>Sex:</td>
							<td><select name="sexa">

									<option <?= @$_POST['sexa'] == 'Male' ? "selected" : "" ?>>Male</option>
									<option <?= @$_POST['sexa'] == 'Female' ? "selected" : "" ?>>Female</option>
								</select>
							</td>
						</tr>
						<tr>
							<td>province:</td>
							<td>
								<select name="province">
									<?php
									$province = mysqli_query($mysqli, "SELECT * from province");

									$i = 0;
									while ($row = mysqli_fetch_array($province)) { {
											$i++;
											if ($i == 1) {
												$initialProvince = $row['provinceId'];
											}

									?>
											<option <?= @$_POST['province'] == $row['provinceId'] ? "selected" : "" ?> value="<?= $row['provinceId'] ?>"><?php echo $row['provinceName']; ?></option>
									<?php

										}
									}
									?>
								</select>
							</td>
						</tr>
						<tr>
							<td>District:</td>
							<td>
								<div id="districts">
									<select name="district">
										<?php
										$district = mysqli_query($mysqli, "SELECT district.* from district,province WHERE province.provinceId=district.provinceId and district.provinceId='$initialProvince'");

										$i = 0;
										while ($row = mysqli_fetch_array($district)) {


										?>
											<option <?= @$_POST['district'] == $row['districtId'] ? "selected" : "" ?> value="<?= $row['districtId'] ?>"> <?php echo $row['districtName']; ?></option>
										<?php

										}
										?>
									</select>
								</div>
							</td>
						</tr>

						<tr>
							<td>Sector:</td>
							<td><input type="text" name="sector" placeholder="enter Sector" value='<?= @$_POST['sector'] ?>'></td>
						</tr>


						<tr>
							<td>Phone:</td>
							<td><input type="text" name="phone" placeholder="enter phonenumber" value='<?= @$_POST['phone'] ?>' pattern="07[2,3,8]{1}[0-9]{7}"></td>
						</tr>
						<tr>
							<td>ID-NO:</td>
							<td><input type="text" name="idno" placeholder="enter identity-number" maxlength="16" value='<?= @$_POST['idno'] ?>' pattern="[0-9]{16}"></td>
						</tr>


						<tr>
							<td colspan="2" align="center"><input type="submit" href="nextinsert.php" name="save" value="Save"></td>
							</td>
					</table>
				</center>
			</form>
		<?php
		}
		?>
		<style>
			#insert input {
				border-radius: 3px;
				width: 130%;
				padding: 5px;
				border: 1px solid white;
				font-family: arial;
			}



			#insert {
				background-color: #ddd;
				box-shadow: 0 0 0px white;
				padding: 5px;
				width: 370px;
				margin-left: 300px;
				margin-top: 40px;
				font-family: segoe Ui;
				width: 500px;
			}

			#insert input[type="submit"] {
				padding: 5px;
				width: 67px;
				border: 2px solid black;
			}

			#insert table select {
				padding: 10px;
				width: 100%;
				border: 1px solid grey;
				border-radius: 3px;
				box-shadow: 0 0 1.5px grey;
				height: 40px;
			}

			#insert input[type="submit"]:hover {
				background-color: white;
				color: black;
			}

			.error {
				box-shadow: 0 0 5px red;
				border: none;
				border-radius: 4px;
			}

			#Tips {
				font-family: segoe UI;
				font-size: 15px;
				background: grey;
				border-radius: 3px;
				padding: 10px;
				text-align: center;
				font-weight: lighter;
				background-color: #0eb6f8;
				color: white;
				font-family: century gothic;
				font-size: 17px;
			}

			#clienttable select {
				padding: 10px;
				width: 200%;
				border: 1px solid grey;
				border-radius: 3px;
				box-shadow: 0 0 1.5px grey;
			}

			#clienttable {
				font-family: arial;
			}

			#motor textarea {
				font-size: 16px;
				width: 300px;
				height: 200px;
			}

			#motor input[type=file] {
				padding: 7px;
				background-color: white;
				border: 1px solid grey;
				border-radius: 3px;
				widows: 230px;
			}

			#motor input[type="text"] {
				padding: 3px;
				margin: 2px;
				border: 1px solid #afadad;
				width: 240px;
				height: 32px;
				font-size: 15px;
				box-shadow: 0 0 1.5px grey
			}

			#motor {
				background-color: #e4e5e6;
			}

			#motor input[type="submit"] {
				padding: 5px;
				width: 67px;
				border: 0px solid black;
				font-family: arial;
				background-color: black;
				color: white;
				font-weight: bold;
			}

			#motor input[type="submit"]:hover {
				background-color: white;
				color: black;
			}

			#fire textarea {
				font-size: 16px;
				width: 300px;
				height: 200px;
			}

			#fire input[type=file] {
				padding: 7px;
				background-color: white;
				border: 1px solid grey;
				width: 230px;
			}

			#fire input[type="text"] {
				padding: 3px;
				margin: 2px;
				border: 1px solid #afadad;
				width: 240px;
				height: 32px;
				font-size: 15px;
				box-shadow: 0 0 1.5px grey;
			}

			#fire {
				background-color: #e4e5e6;
			}

			#fire input[type="submit"] {
				padding: 5px;
				width: 67px;
				border: 0px solid black;
				font-family: arial;
				background-color: black;
				color: white;
				font-weight: bold;
			}

			#fire input[type="submit"]:hover {
				background-color: white;
				color: black;
			}

			#tit {
				font-family: century gothic;
				font-size: 20px;
				font-weight: bold;
			}

			#titi {
				font-family: century gothic;
				font-size: 20px;
				font-weight: bold;
			}

			#form {
				min-height: 400px;
			}

			#Tips {
				font-family: segoe UI;
				font-size: 15px;
				background: grey;
				border-radius: 3px;
				padding: 10px;
				text-align: center;
				font-weight: lighter;
				background-color: #0eb6f8;
				color: white;
				font-family: century gothic;
				font-size: 17px;
				margin-top: -20px;
			}
		</style>
	</div>

	<?php include("includes/footer.view.php"); ?>
</body>

</html>