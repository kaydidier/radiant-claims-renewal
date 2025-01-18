<?php
mysql_connect("localhost","root","");
mysql_select_db("radiant");
session_start();
if (!$_SESSION['adminid']) {
header("LOCATION:index.php");
}
?>
<html>
<head>
<style type="text/css">
</style>
<title>Radiant insurance company
</title>
<link rel="shortcut icon" href="insurance/LOGO.png">
<link rel="stylesheet" type="text/css" href="cssweb/file.css">
<link rel="stylesheet" type="text/css" href="cssweb/dropdown.css">
</head>
<body>
<style type="text/css">
#employee{border: 0px solid red;margin-top: 50px;margin-left: 300px;}
#employee p{font-family: century gothic;font-weight: bold;}
a{text-decoration: none;color: black;font-size: 20px;}
</style>
<?php include("includes/header.php");
?>

<div id="navbar">
<ul>
<li><a href="employees.php">Home</a></li>
<li><a href="">Employees</a>
<ul><li><a href="addemployee.php">New</a></li>
<li><a href="employees.php">View</a></li>
</ul>
</li>
<li><a href="insurance.php">Insurances</a></li>
<li><a href="allclients.php">Clients</a></li>
<li><a href="logout.php" id="show">Logout</a></li>
</ul>
</div>
<div id="employee">
<p>Here You can view All clients Who are Registered By All branch-managers</p><br>
</div>
<h3>All Branch-Managers(Employees)</h3>

<?php

$employee="SELECT * FROM Employees";
$ema=mysqli_query($employee);
$x=1;
while ($emp=mysqli_fetch_array($ema)) {
	?>

<td><a href="allclients.php?sortby=employee&emp_id=<?php echo $emp['emp_id']; ?>"><?php echo $emp['firstname']." ".$emp['lastname'];?></a></td><br>	
	
<?php
$x++;
}

	
?>
<div >
<center>
<?php
$sql="SELECT clients.*,district.districtName,province.provinceName from clients,district,province where clients.district=district.districtId and clients.province=province.provinceId ";
switch (@$_GET['sortby']) {
		case 'employee':
			$sql.=" and clients.emp_id={$_GET['emp_id']}";
			break;
		
		default:
			
			break;
	}	
$exec=mysqli_query($sql)or die(mysqli_error());
if (mysqli_num_rows($exec)>0) {
	?>
	<center><h4>Clients</h4></center>
<table>
<tr id="row">
<td id="as">#</td>
<td id="as">firstName</td>
<td id="as">Lastname</td>
<td id="as">Username</td>
<td id="as">Password</td>
<td id="as">Email</td>
<td id="as">Dob</td>
<td id="as">Sex</td>
<td id="as">Sector</td>
<td id="as">District</td>
<td id="as">Province</td>
<td id="as">Phone</td>
</div>


<?php


	$a=1;
while($row=mysqli_fetch_array($exec)){
	?>
	<tr>
<td><?php echo $a;?></td> 
<td><?php echo $row['firstname'];?></td>
<td><?php echo $row['lastname'];?></td>
<td><?php echo $row['username'];?></td>
<td><?php echo $row['password'];?></td>
<td><?php echo $row['email'];?></td>
<td><?php echo $row['dob'];?></td>
<td><?php echo $row['sex'];?></td>
<td><?php echo $row['sector'];?></td>
<td><?php echo $row['districtName'];?></td>
<td><?php echo $row['provinceName'];?></td>
<td><?php echo $row['phone'];?></td>

</tr>
	<?php
	$a++;}



	
?>
</table>
<?php
}
else{
	echo "<hr><h4><font face='Century Gothic'>no data found</font>";
}
?>
</center>
</div>
</body>
</html>
<?php include("includes/footer.php");?>