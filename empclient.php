<?php
require "includes/connection.php";

if (!$_SESSION['employeeid']) {
	header("LOCATION:index.php");
}
if (@$_GET['action'] == 'delete') {
	switch (@$_GET['type']) {
		case 'car':
			$prid = $_GET['prid'];
			if (mysqli_query($mysqli, "DELETE FROM cars where cars.car_id='$prid'") or die(mysqli_error($mysqli))) {
				mysqli_query($mysqli, "DELETE FROM insured where propertyId='$prid'");
				header("location=empclient.php?action=viewclient&clid={$_GET['clid']}");

?>

<?php
			}
			break;
		case 'house':
			$prid = $_GET['prid'];
			if (mysqli_query($mysqli, "DELETE FROM houses where houses.house_id='$prid'") or die(mysqli_error($mysqli))) {
				mysqli_query($mysqli, "DELETE FROM insured where propertyId='$prid'");
				header("location=empclient.php?action=viewclient&clid={$_GET['clid']}");
			}
			break;
	}
}
?>
<html>

<head>
	<style type="text/css">
	</style>
	<title>Radiant insurance company
	</title>
	<script src='js/jquery.js'></script>
	<script src='js/jquery-ui.js'></script>
	<link rel="stylesheet" type="text/css" href="js/jquery-ui.css">
	<script>
		$(function() {
			$("#dialog").dialog({


				autoOpen: false,
				width: 450,
				modal: true,
				draggable: false,
				showAnim: 'slideDown',
				resizable: false,
				position: {
					my: "center top",
					at: "center bottom",
					of: "#navbar"
				}
			});
			$(".update").click(function(e) {
				e.preventDefault();
				var id = $(this).attr('href');
				$("#dialog").dialog('open').load("updateclient.php?id=" + id);
			});
			$(".delete").click(function(e) {
				e.preventDefault();
				var id = $(this).attr('href');
				var name = $(this).attr('name');
				var conf = confirm('Are you sure to delete ' + name + '?');
				if (conf) {
					$("#col" + id).hide().load('deleteclie.php?id=' + id);
				}
			});

		});
	</script>
	<link rel="shortcut icon" href="insurance/LOGO.png">
	<link rel="stylesheet" type="text/css" href="cssweb/file.css">
	<link rel="stylesheet" type="text/css" href="cssweb/dropdown.css">
	<script src='js/jquery.js'></script>
	<script src='js/jquery-ui.js'></script>
</head>

<body>
	<?php
	// include("includes/header.view.php");
	?>
	<div id='dialog' title='Update Form'></div>
	<div id="navbar">
		<ul>
			<li><a href="emppage.php">Home</a></li>
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


	<center>
		<?php
		if (!@$_GET['action'] == 'viewclient') {

		?>
			<table id="fetclei">
				<tr id="row">
					<td id="as">#</td>
					<td id="as">firstName</td>
					<td id="as">Lastname</td>
					<td id="as">Username</td>
					<td id="as">Email</td>
					<td id="as">Dob</td>
					<td id="as">Sex</td>
					<td id="as">Sector</td>
					<td id="as">District</td>
					<td id="as">Province</td>
					<td id="as">Phone</td>
					<td id="as">IdNo</td>
					<td colspan="2" id="as">Action</td>
					<?php
					$sql = "SELECT clients.*,district.*,province.* from clients,employees,district,province where province.provinceId=clients.province and district.districtId=clients.district and employees.emp_id=clients.emp_id  and employees.emp_id=clients.emp_id and employees.emp_id={$_SESSION['employeeid']} ";
					$exec = mysqli_query($mysqli, $sql);
					$a = 1;
					while ($row = mysqli_fetch_array($exec)) {

					?>
				<tr id='col<?= $row['id_client'] ?>'>

					<td><?php echo $a; ?></td>
					<td><a href="empclient.php?action=viewclient&clid=<?php echo $row['id_client']; ?>"><?php echo $row['firstname']; ?></a></td>
					<td><a href="empclient.php?action=viewclient&clid=<?php echo $row['id_client']; ?>"><?php echo $row['lastname']; ?></a></td>
					<td><a href="empclient.php?action=viewclient&clid=<?php echo $row['id_client']; ?>"><?php echo $row['username']; ?></a></td>
					<td><a href="empclient.php?action=viewclient&clid=<?php echo $row['id_client']; ?>"><?php echo $row['email']; ?></a></td>
					<td><?php echo $row['dob']; ?></a></td>
					<td><?php echo $row['sex']; ?></a></td>
					<td><?php echo $row['sector']; ?></a></td>
					<td><?php echo $row['districtName']; ?></a></td>
					<td><?php echo $row['provinceName']; ?></a></td>
					<td><?php echo $row['phone']; ?></a></td>
					<td><?php echo $row['ID_no']; ?></a></td>
					<td><a href="deleteclie.php?action=delete&id=<?php echo $row['id_client']; ?>" class='delet' name='<?= $row['firstname']; ?>' href="#""<?php echo $row['emp_id']; ?>"><img src="insurance/delete.png" height="23"></td>
					<td><a class='update' href="<?= $row['id_client']; ?>"><img src="insurance/edit.png" height="23"></td>
				</tr>
			<?php
						$a++;
					}
			?>

			</table>


		<?php
		}
		if (@$_GET['action'] == 'viewclient') {
		?>
			<?php
			//$query=mysqli_query("SELECT * from insured,clients,province,district where clients.id_client=insured.id_client and province.provinceId=clients.province and district.districtId=clients.district and clients.id_client={$_GET['clid']}");
			$query = mysqli_query("SELECT * from insured,clients,district,province where insured.id_client=clients.id_client and district.districtId=clients.district and province.provinceId=clients.province and clients.id_client={$_GET['clid']}");


			?>
			<div id="addpro"><a href="initsession.php?clid=<?php echo $_GET['clid']; ?>">
					<p>Add property>></p>
				</a></div>
			<table>
				<?php
				$display = 4;
				$cols = 0;
				while ($queryData = mysqli_fetch_array($query)) {

					if ($cols == 0) {
				?>
						<tr>
						<?php
					}
						?>
						<td>
							<table>

								<tr>
									<td>
										<?php
										switch ($queryData['type']) {
											case 'house':
												$queryProperty = mysqli_query($mysqli, "SELECT * FROM houses where house_id={$queryData['propertyId']}") or die(mysqli_error($mysqli));
												$queryPropertyData = mysqli_fetch_array($queryProperty);
										?>
												<img src="images/houses/ <?php echo $queryPropertyData['photo']; ?>" width="100" height="100">
									</td>
								<tr>
									<td><?php echo $queryPropertyData['plot_number']; ?></td>
								</tr>
							<?php
												break;

											case 'car':
												$queryProperty = mysqli_query($mysqli, "SELECT * FROM cars where car_id={$queryData['propertyId']}") or die(mysqli_error($mysqli));
												$queryPropertyData = mysqli_fetch_array($queryProperty);
							?>
								<img src="./images/cars/ <?php echo $queryPropertyData['photo']; ?>" width="100" height="100">
								<tr>
									<td>plaque:<?php echo $queryPropertyData['plaque']; ?></td>
								</tr>
						<?php
												break;
										}
						?>
						</td>
						</tr>
						<tr>
							<td><?php echo $queryData['username']; ?></td>
						</tr>
						<tr>
							<td>location:<?php echo $queryData['provinceName']; ?></td>
						</tr>
						<tr>
							<td><?php echo $queryData['districtName']; ?></td>
						</tr>
						<tr>
							<td><?php echo $queryData['phone']; ?></td>
						</tr>
						<tr>
							<td><?php echo $queryData['email']; ?></td>
						</tr>

						<tr>
							<td>insurance duration:<br>
								from:<?php echo $queryData['start_date']; ?>
								to:<?php echo $queryData['end_date']; ?></td>
						</tr>
						<tr>
							<td>
								<a href="empclient.php?action=delete&prid=<?php echo $queryData['propertyId']; ?>&type=<?php echo $queryData['type'] ?>&clid=<?php echo $_GET['clid'];

																																								?>">delete</a>
							</td>
						</tr>

			</table>
			</td>
			<?php
					$cols++;
					if ($cols == $display) {
						$cols = 0;
			?>
				</tr>
			<?php
					}
				}
				if ($cols != 0 and $cols != $display) {
					$neededtds = $display - $cols;

					for ($i = 0; $i < $neededtds; $i++) {
			?>
				<td></td>
			<?php
					}
			?>
			</tr>
			</table>
		<?php

				} else {
		?>
			</table>
		<?php
				}
		?>
		</table>
	<?php
		}
	?>
	</center>

</body>

</html>
<?php include("includes/footer.view.php"); ?>