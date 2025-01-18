<?php
session_start();
include("includes/connection.php");
if (!$_SESSION['employeeid']) {
header("LOCATION:index.php");
//var_dump($_SESSION['adminid']);


//if (!$_SESSION['admin']) {
	//header("location:login.php");
	//}
$_SESSION['edit']=$_GET['userid'];

}
echo $_SESSION['edit']; 
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

<?php
$sql=mysqli_query("SELECT * FROM employees WHERE emp_id={$_SESSION['employeeid']}") or die(mysqli_error());
$rowname=mysqli_fetch_array($sql,MYSQL_ASSOC);
?>
<div id="navbar">
<ul>
<li><a href="#">Home</a></li>
<li><a href="#">Clients</a>
<ul><li><a href="clientreg.php?action=add">New</a></li>
<li><a href="empclient.php">View</a></li>
</ul>
</li>
<li><a href="claimed.php">claimed</a></li>
<li><a href="ansfeed.php">Feedback</a></li>
<!--<li><a href="#">Products</a></li>-->
<li><a href="logout.php" id="show">Logout</a></li>
</ul>
</div>
<div><a href="edituser.php?action=edituserinfo">Update client informations</a></div>
<div>
		<div>
		Insured properties
	</div>
	<div>
		<?php
		if (isset($_SESSION['edit'])) {
			$idcl=$_SESSION['edit'];
		}else{$idcl=$_GET['userid'];}
			$query=mysqli_query("SELECT * FROM insured where id_client='$idcl'") or die(mysqli_error());
			
			while ($row=mysqli_fetch_array($query)) {
				?>
				<div><?php echo $row['type']; ?></div>
				<?php

						switch ($row['type']) {
							case 'car':
								$query2=mysqli_query("SELECT cars.* FROM cars WHERE cars.car_id={$row['propertyId']}") or die(mysqli_error());

								while ($row2=mysqli_fetch_array($query2)) {
									?>
									<div class="insured-ppt">
									<div>
										<img src="./images/cars/ <?php echo $row2['photo'];?>" height="200" width="200">
									</div>
									<div><span class="label-ppt">model: </span><?php echo $row2['model']; ?></div>
									<div><span class="label-ppt">plaque: </span><?php echo $row2['plaque']; ?></div>
									<div><span class="label-ppt">description: </span><?php echo $row2['description']; ?></div>
									<div><span class="label-ppt">price: </span><?php echo $row['price']; ?></div>
									<div><span class="label-ppt">From: </span><?php echo $row['start_date']; ?> to :<?php echo $row['end_date']; ?></div>
									<div><span class="label-ppt">remaining: </span><?php echo getInsuranceStatus($row['start_date'],$row['end_date']) ?></div>
									<?php
								}
								
								break;
							
							case 'house':
								$query2=mysqli_query("SELECT houses.* FROM houses WHERE houses.house_id={$row['propertyId']}") or die(mysqli_error());

								while ($row2=mysqli_fetch_array($query2)) {
									?>
									<div>
										<img src="./images/houses/ <?php echo $row2['photo'];?>" height="200" width="200">
									</div>
									<div><span class="label-ppt">plot no: </span><?php echo $row2['plotnumber']; ?></div>
									<div><span class="label-ppt">description: </span><?php echo $row2['description']; ?></div>
									
									
									<div><span class="label-ppt">From: </span><?php echo $row['start_date']; ?> to: <?php echo $row['end_date']; ?></div>
									<div><span class="label-ppt">remaining: </span><?php echo getInsuranceStatus($row['start_date'],$row['end_date']) ?></div>
									<div class='btn-action'><a href="edituser.php?action=renew">Renew Insurance</div>
									<?php
								}
								
								break;
						}
				?>
				</div>
				<?php
			}
		?>
	</div>
</div>

</body>
</html>
<?php include("includes/footer.php");?>
