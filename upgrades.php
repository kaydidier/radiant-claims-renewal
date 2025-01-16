<?php

include("includes/connection.php");
if (!$_SESSION['employeeid']) {
header("LOCATION:index.php");


}
switch (@$_GET['action']) {
	case 'upgrade':
		$queryDetail=mysql_query("SELECT * FROM insured_details where DetailID={$_GET['up']}");
		$queryDetailRow=mysql_fetch_array($queryDetail);
		
		$upgradeInsured=mysql_query("UPDATE insured set start_date='{$queryDetailRow['start_date']}',end_date='{$queryDetailRow['end_date']}' WHERE insured_id={$_GET['insured']}" ) or die(mysql_error());
		if ($upgradeInsured) {
			mysql_query("UPDATE insured_details set status='approved' where DetailID={$_GET['up']}");
			?>
			<script type="text/javascript">
			alert("Approved!");
			</script>
			<?php
		}
		break;
	
	
}
?>
<html>
<head><title>Radiant insurance compnany</title>
<link rel="shortcut icon" href="insurance/LOGO.png">
<link rel="stylesheet" type="text/css" href="cssweb/file.css">
<link rel="stylesheet" type="text/css" href="cssweb/dropdown.css">
<script src="js/jquery.js"></script>
<script src="js/jquery-ui.js"></script>
<link rel="stylesheet"href="css/jquery-ui.css">
<script>

</script>
</head>
<body>

<?php include("includes/header.php"); ?>
<div id="navbar">
<ul>
<li><a href="emppage.php">Home</a></li>
<li><a href="#">Clients</a>
<ul><li><a href="clientreg.php?action=add">New</a></li>
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
<div style="float:left;width:100%;border:0px solid red;margin-top:60px;">
	<div id="tra">Requested upgrades which you must Solve</div>
	<?php
		$query=mysql_query("SELECT *,clients.username as cluname,clients.phone as clphone,clients.email as clemail FROM insured,province,district,insured_details,clients,insurance,employees where  clients.id_client=insured.id_client and district.districtId=clients.district and province.provinceId=clients.province and insurance.insurance_id=insured.insurance_id and insured_details.insured_id=insured.insured_id and clients.emp_id=employees.emp_id and employees.emp_id={$_SESSION['employeeid']} and insured_details.status='waiting'");
		


	?>
	<table>
	<?php
	$display=4;
	$cols=0;
		while ($queryData=mysql_fetch_array($query)) {
		
		if($cols==0){
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
							$queryProperty=mysql_query("SELECT * FROM houses,insured WHERE insured.propertyId=houses.house_id") or die(mysql_error());
							$queryPropertyData=mysql_fetch_array($queryProperty);
							?>
							<img src="images/houses/ <?php echo $queryPropertyData['photo'];?>" width="200" height="200"></td>
							<tr>
								<td><?php echo $queryPropertyData['plot_number']; ?></td>
							</tr>
							<?php
							break;
						
						case 'car':
							$queryProperty=mysql_query("SELECT * FROM cars,insured WHERE insured.propertyId=cars.car_id");
							$queryPropertyData=mysql_fetch_array($queryProperty);
							?>
							<img src="images/cars/ <?php echo $queryPropertyData['photo'];?>" width="200" height="200">
							<?php
							break;
					}
				?>
			</td>
		</tr>
		<tr>
			<td><?php echo $queryData['cluname']; ?></td>
		</tr>
		<tr>
			<td><?php echo $queryData['provinceName']; ?></td>
		</tr>
		<tr>
			<td><?php echo $queryData['districtName']; ?></td>
		</tr>
		<tr>
			<td><?php echo $queryData['clphone']; ?></td>
		</tr>
		<tr>
			<td><?php echo $queryData['clemail']; ?></td>
		</tr>
		
		<tr>
			<td>requested duration:<br>
			from:<?php echo $queryData['start_date'];?>
			to:<?php echo $queryData['end_date']; ?></td>
		</tr>
		<tr>
			<td><center><a href="slips/<?php echo $queryData['BankSlip'] ?>">download Bankslip</a></center>

			</td>
		</tr>
		<tr>
			<td><center><a href="upgrades.php?action=upgrade&insured=<?php echo $queryData['insured_id']; ?>&up=<?php echo $queryData['DetailID']; ?>">Approve</a></center></td>
			
		</tr>
	</table>
	</td>
		<?php 
		$cols++;
		if ($cols==$display) {
			$cols=0;
			?>
			</tr>
			<?php
		}
			}
			if ($cols!=0 and $cols!=$display) {
				$neededtds=$display-$cols;

				for ($i=0; $i <$neededtds ; $i++) { 
					?>
					<td></td>
					<?php
				}
				?>
				</tr></table>
				<?php

			}else{
				?>
				</table>
				<?php
			}
		?>
	</table>
</div>
<style type="text/css">
#tra{font-family:century gothic;
}
</style>

</body>
</html>
<?php include("includes/footer.php");?>
