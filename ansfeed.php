<?php
include ("includes/connection.php");
if (!$_SESSION['employeeid']) {
header("LOCATION:index.php");
}
?>
<html>
<head>
<title>Radiant Insurance Company</title>
<link rel="shortcut icon" href="insurance/LOGO.png">
<link rel="stylesheet" type="text/css" href="cssweb/file.css">
<link rel="stylesheet" type="text/css" href="cssweb/dropdown.css">
</head>
<body>
<?php include("includes/header.php");
?>



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

<center>
<div id="fat">
<table>
<font face="century gothic">FeeBack Which You Send to Clients<hr></font>
<tr id="row">
<td id="ay">n<sup>o</sup></td>
<td id="ay">client name</td>

<td id="ay">Feedback</td>
<?php
$sel=mysql_query("SELECT feedback.*,clients.*,employees.*,clients.firstname,clients.lastname from employees,clients,feedback where clients.id_client=feedback.id_client and clients.emp_id=employees.emp_id and employees.emp_id={$_SESSION['employeeid']}");
$a=1;

while($row=mysql_fetch_array($sel)){
	?>
	<tr>
<td><?php echo $a;?></td> 
<td><?php echo $row['firstname']."  ".$row['lastname'].':';?></td>
<td><?php echo $row['feedmsg'];?></td>

</tr>
	<?php
	$a++;}
?>
</table>
</div>
</center>
<?php include("includes/footer.php");?>




</body>
</html>

