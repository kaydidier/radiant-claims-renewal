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
<?php include("includes/header.php");
?>

<div id="navbar">
<ul>
<li><a href="employees.php">Home</a></li>
<li><a href="clients.php">Clients</a></li>
<li><a href="">Employees</a>
<ul><li><a href="addemployee.php">New</a></li>
<li><a href="employees.php">View</a></li>
</ul>
</li>
<li><a href="insurance.php">Insurances</a></li>
<li><a href="logout.php" id="show">Logout</a></li>
</ul>
</div>
<div id="fetclei">
<center>
<table>
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
<?php
$sql="select *from clients";	
$exec=mysql_query($sql);
$a=1;
while($row=mysql_fetch_array($exec)){
	?>
	<tr>
<td><?php echo $a;?></td> 
<td><?php echo $row['firstname'];?></td>
<td><?php echo $row['lastname'];?></td>
<td><?php echo $row['username'];?></td>

<td><?php echo $row['email'];?></td>
<td><?php echo $row['dob'];?></td>
<td><?php echo $row['sex'];?></td>
<td><?php echo $row['sector'];?></td>
<td><?php echo $row['district'];?></td>
<td><?php echo $row['province'];?></td>
<td><?php echo $row['phone'];?></td>
<td><?php echo $row['ID_no'];?></td>
</tr>
	<?php
	$a++;}
?>
</table>
</center>
</div>
</body>
</html>
<?php include("includes/footer.php");?>